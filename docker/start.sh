#!/bin/sh
set -e

log() {
  printf '%s\n' "$*"
}

trim_env_value() {
  printf '%s' "$1" | sed -e 's/^[[:space:]]*//' -e 's/[[:space:]]*$//'
}

db_host_from_env() {
  if [ -n "${DB_HOST:-}" ]; then
    printf '%s' "$DB_HOST"
    return
  fi

  if [ -n "${DB_URL:-}" ]; then
    php -r '$host = parse_url((string) getenv("DB_URL"), PHP_URL_HOST); if (is_string($host)) { echo trim($host); }'
    return
  fi

  if [ -n "${DATABASE_URL:-}" ]; then
    php -r '$host = parse_url((string) getenv("DATABASE_URL"), PHP_URL_HOST); if (is_string($host)) { echo trim($host); }'
    return
  fi

}

wait_for_dns() {
  host="$1"
  attempts="${2:-12}"
  delay="${3:-5}"
  try=1

  while [ "$try" -le "$attempts" ]; do
    resolved_ip="$(CHECK_HOST="$host" php -r '$h = (string) getenv("CHECK_HOST"); $ip = gethostbyname($h); echo $ip;')"
    if [ "$resolved_ip" != "$host" ]; then
      log "Database DNS resolved: ${host} -> ${resolved_ip}"
      return 0
    fi

    log "Waiting for database DNS (${try}/${attempts}): ${host}"
    sleep "$delay"
    try=$((try + 1))
  done

  return 1
}

run_with_retry() {
  cmd="$1"
  attempts="${2:-5}"
  delay="${3:-5}"
  try=1

  while [ "$try" -le "$attempts" ]; do
    if sh -c "$cmd"; then
      return 0
    fi

    if [ "$try" -eq "$attempts" ]; then
      return 1
    fi

    log "Command failed (${try}/${attempts}), retrying in ${delay}s: ${cmd}"
    sleep "$delay"
    try=$((try + 1))
  done

  return 1
}

is_ip_address() {
  candidate="$1"
  is_ip="$(CHECK_IP="$candidate" php -r '$ip = (string) getenv("CHECK_IP"); echo filter_var($ip, FILTER_VALIDATE_IP) ? "1" : "0";')"
  [ "$is_ip" = "1" ]
}

hydrate_db_parts_from_url() {
  source_url="${DB_URL:-${DATABASE_URL:-}}"
  if [ -z "$source_url" ]; then
    return 0
  fi

  if [ -z "${DB_PORT:-}" ]; then
    parsed_port="$(DB_SOURCE_URL="$source_url" php -r '$p = parse_url((string) getenv("DB_SOURCE_URL")); if (is_array($p) && isset($p["port"])) { echo (string) $p["port"]; }')"
    if [ -n "$parsed_port" ]; then
      export DB_PORT="$parsed_port"
    fi
  fi

  if [ -z "${DB_DATABASE:-}" ]; then
    parsed_database="$(DB_SOURCE_URL="$source_url" php -r '$p = parse_url((string) getenv("DB_SOURCE_URL")); if (is_array($p) && isset($p["path"])) { $db = ltrim((string) $p["path"], "/"); if ($db !== "") { echo $db; } }')"
    if [ -n "$parsed_database" ]; then
      export DB_DATABASE="$parsed_database"
    fi
  fi

  if [ -z "${DB_USERNAME:-}" ]; then
    parsed_username="$(DB_SOURCE_URL="$source_url" php -r '$p = parse_url((string) getenv("DB_SOURCE_URL")); if (is_array($p) && isset($p["user"])) { echo rawurldecode((string) $p["user"]); }')"
    if [ -n "$parsed_username" ]; then
      export DB_USERNAME="$parsed_username"
    fi
  fi

  if [ -z "${DB_PASSWORD+x}" ]; then
    parsed_password="$(DB_SOURCE_URL="$source_url" php -r '$p = parse_url((string) getenv("DB_SOURCE_URL")); if (is_array($p) && array_key_exists("pass", $p)) { echo rawurldecode((string) $p["pass"]); }')"
    export DB_PASSWORD="$parsed_password"
  fi
}

if [ -n "${DB_CONNECTION:-}" ]; then
  export DB_CONNECTION="$(trim_env_value "$DB_CONNECTION")"
fi

db_host="$(db_host_from_env | tr -d '\r\n')"
if [ -n "$db_host" ] && [ "$db_host" != "localhost" ] && [ "$db_host" != "127.0.0.1" ] && ! is_ip_address "$db_host"; then
  if ! wait_for_dns "$db_host" 12 5; then
    fallback_db_ip="${DB_HOST_IP:-${DB_HOST_FALLBACK_IP:-}}"
    if [ -n "$fallback_db_ip" ]; then
      log "Database DNS failed for ${db_host}. Falling back to DB_HOST_IP=${fallback_db_ip}."
      hydrate_db_parts_from_url
      export DB_HOST="$fallback_db_ip"
      export DB_HOST_IP="$fallback_db_ip"
      unset DB_URL
      unset DATABASE_URL
    else
      log "ERROR: database host is not resolvable: ${db_host}"
      log "Set a valid DB_HOST in Render, or set DB_HOST_IP as a temporary fallback."
      exit 1
    fi
  fi
fi

# Clear stale caches before boot-time DB work so env changes always apply.
php artisan optimize:clear

# Free-tier friendly: run migrations at startup when shell/pre-deploy is unavailable.
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  run_with_retry "php artisan migrate --force --no-interaction" 5 8
fi

# Ensure production always has a recoverable admin account.
if [ "${SEED_ADMIN_ON_BOOT:-true}" = "true" ]; then
  run_with_retry "php artisan db:seed --class=AdminUserSeeder --force --no-interaction" 3 5
fi

# Seed sample coupons when requested (idempotent seeder).
if [ "${SEED_COUPONS_ON_BOOT:-true}" = "true" ]; then
  run_with_retry "php artisan db:seed --class=CouponSeeder --force --no-interaction" 3 5
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
