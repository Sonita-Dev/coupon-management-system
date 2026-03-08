#!/bin/sh
set -e

# Free-tier friendly: run migrations at startup when shell/pre-deploy is unavailable.
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  php artisan migrate --force --no-interaction
fi

# Ensure production always has a recoverable admin account.
if [ "${SEED_ADMIN_ON_BOOT:-true}" = "true" ]; then
  php artisan db:seed --class=AdminUserSeeder --force --no-interaction
fi

# Seed sample coupons when requested (idempotent seeder).
if [ "${SEED_COUPONS_ON_BOOT:-true}" = "true" ]; then
  php artisan db:seed --class=CouponSeeder --force --no-interaction
fi

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
