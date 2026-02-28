## Coupon Management System (Laravel)

This is a simple **Coupon Management System** built with **Laravel**, **Blade**, and **MySQL**.  
It provides an admin-only panel to manage discount coupons and a small page to **test/apply** coupons against a fake cart total.

> NOTE: This repository assumes a standard Laravel installation.  
> If you have not yet created one, follow the steps below.

### 1. Create the Laravel project

Make sure you have PHP, Composer, and MySQL installed, then in this folder run:

```bash
composer create-project laravel/laravel . 
```

If the folder is not empty, you can instead create Laravel elsewhere and copy the feature files from this repo into your project.

### 2. Install and configure Laravel Breeze (admin auth)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
php artisan migrate
```

Create a single admin user (via `php artisan tinker` or registration if enabled) and restrict coupon routes to authenticated users.

### 3. Coupon feature overview

The system includes:

- **Admin authentication** using Laravel Breeze (`auth` middleware).
- **Coupons table** with:
  - `code`, `type` (`fixed`/`percent`), `value`
  - `description`, `start_date`, `end_date`
  - `min_order_amount`, `max_uses`, `used_count`
  - `is_active` flag and soft deletes
- **Dashboard** showing:
  - Total coupons
  - Active coupons
  - Expired coupons
  - Total used count
- **CRUD for coupons**:
  - List with search & filters (by code/status/active/expired)
  - Create with validation (unique code, positive value, date rules)
  - View, edit, soft-delete
- **Coupon apply test page**:
  - Enter coupon code and fake cart total
  - Validates coupon (exists, active, not expired, min order, remaining uses)
  - Shows discount amount, new total, and clear error messages

### 4. Files to add/update in your Laravel app

Once you have a Laravel project created, add/update these files (paths are relative to the Laravel root):

- `app/Models/Coupon.php`
- `app/Http/Controllers/CouponController.php`
- `app/Http/Requests/StoreCouponRequest.php`
- `app/Http/Requests/UpdateCouponRequest.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_coupons_table.php`
- `database/seeders/CouponSeeder.php`
- `routes/web.php` (add coupon routes)
- `resources/views/layouts/app.blade.php` (or adapt if Breeze already created one)
- `resources/views/dashboard.blade.php`
- `resources/views/coupons/*.blade.php` (index/create/edit/show/apply)

This repository will contain example implementations for each of these.

### 5. Database and seeding

Configure your `.env` with your MySQL credentials, then run:

```bash
php artisan migrate
php artisan db:seed --class=CouponSeeder
```

This seeds **10–15 sample coupons** for testing.

### 6. Running locally

```bash
php artisan serve
```

Open `http://localhost:8000` and log in with your admin account.

### 7. Deploying to Vercel (basic setup)

This project includes a minimal `vercel.json` that:

- Installs Composer dependencies
- Runs Laravel optimization commands
- Uses `public/index.php` as the entrypoint

You may need to:

- Set environment variables in Vercel (`APP_KEY`, `APP_ENV`, `DB_*`, etc.)
- Use a managed MySQL database (e.g., PlanetScale, Neon with MySQL compatibility, or another provider)

See `vercel.json` for the exact configuration and adjust according to Vercel/Laravel deployment guides.

