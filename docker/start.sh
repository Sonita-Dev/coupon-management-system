#!/bin/sh
set -e

log() {
  printf '%s\n' "$*"
}

db_host_from_env() {
  if [ -n "${DB_URL:-}" ]; then
    php -r '$host = parse_url((string) getenv("DB_URL"), PHP_URL_HOST); if (is_string($host)) { echo trim($host); }'
    return
  fi

  if [ -n "${DATABASE_URL:-}" ]; then
    php -r '$host = parse_url((string) getenv("DATABASE_URL"), PHP_URL_HOST); if (is_string($host)) { echo trim($host); }'
    return
  fi

  if [ -n "${DB_HOST:-}" ]; then
    printf '%s' "$DB_HOST"
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

db_host="$(db_host_from_env | tr -d '\r\n')"
if [ -n "$db_host" ] && [ "$db_host" != "localhost" ] && [ "$db_host" != "127.0.0.1" ]; then
  if ! wait_for_dns "$db_host" 12 5; then
    log "ERROR: database host is not resolvable: ${db_host}"
    log "Set a valid DB_URL/DB_HOST in Render before booting."
    exit 1
  fi
fi

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

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
