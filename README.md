# Coupon Management System

A Laravel-based coupon management platform for creating, managing, and testing discount coupons with a simple Blade + Tailwind UI.

## Table of Contents
- [Project Overview](#project-overview)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Setup & Installation](#setup--installation)
- [How to Run](#how-to-run)
- [Core Data Model](#core-data-model)
- [Core Functionalities](#core-functionalities)
- [Application Flow](#application-flow)
- [Authentication](#authentication)
- [Testing](#testing)
- [Notes](#notes)

## Project Overview
This project helps teams:
- Manage coupon lifecycle (create, edit, delete, activate/deactivate).
- Track coupon usage and status (active/expired/inactive).
- Simulate applying a coupon to a cart total to validate business logic.
- View dashboard metrics to monitor coupon performance.

## Tech Stack
- **Backend:** Laravel 12 (PHP)
- **Frontend:** Blade templates + TailwindCSS (via Vite)
- **Database:** MySQL / MariaDB / PostgreSQL / SQLite (Laravel supported drivers)
- **Authentication:** Laravel Breeze (routes/controllers scaffolding) with customized Blade UI

## Requirements
- PHP 8.2+
- Composer 2+
- Node.js 18+ and npm
- A database supported by Laravel

## Setup & Installation

```bash
# 1) Install backend dependencies
composer install

# 2) Install frontend dependencies
npm install

# 3) Configure environment
cp .env.example .env
php artisan key:generate

# 4) Configure DB credentials in .env
# DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5) Run migrations and (optional) seeders
php artisan migrate
php artisan db:seed
```

## How to Run

```bash
# Terminal A: Laravel app
php artisan serve

# Terminal B: Vite assets
npm run dev
```

Open `http://127.0.0.1:8000`.

## Core Data Model

### `coupons` table
Stores the coupon configuration and lifecycle fields:

```php
Schema::create('coupons', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->enum('type', ['fixed', 'percent'])->default('fixed');
    $table->decimal('value', 10, 2);
    $table->string('description')->nullable();
    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();
    $table->decimal('min_order_amount', 10, 2)->nullable();
    $table->unsignedInteger('max_uses')->nullable();
    $table->unsignedInteger('used_count')->default(0);
    $table->boolean('is_active')->default(true);
    $table->softDeletes();
    $table->timestamps();
});
```

## Core Functionalities

### 1) Coupon CRUD
Implemented by `CouponController` resource methods:
- `index()` — searchable + status-filtered coupon listing
- `create()` / `store()` — add new coupon
- `show()` — view details
- `edit()` / `update()` — modify coupon settings
- `destroy()` — soft delete coupon

### 2) Coupon validation and discount rules
Business rules live in `App\Models\Coupon`:

```php
public function isCurrentlyValid(float $cartTotal): bool
{
    if (! $this->is_active) return false;
    if ($this->start_date && $this->start_date->isFuture()) return false;
    if ($this->end_date && $this->end_date->isPast()) return false;
    if ($this->min_order_amount && $cartTotal < $this->min_order_amount) return false;
    if (! is_null($this->max_uses) && $this->used_count >= $this->max_uses) return false;

    return true;
}
```

And discount calculation:

```php
public function calculateDiscount(float $cartTotal): float
{
    $discount = $this->type === 'percent'
        ? $cartTotal * ($this->value / 100)
        : $this->value;

    return round(min($discount, $cartTotal), 2);
}
```

### 3) Coupon apply simulation
`POST /coupons-apply` validates request input, finds coupon dynamically by code, checks validity, calculates discount, increments `used_count`, and returns result data to the UI.

### 4) Dashboard analytics
`DashboardController@index()` computes:
- total coupons
- active coupons
- expired coupons
- total redemption count
- average usage rate
- recent coupons
- top redeemed coupons

## Application Flow

### Coupon management flow
```text
User -> Coupons index -> Create/Edit form -> Validation -> DB save -> Redirect with flash message
```

### Coupon apply flow
```text
User input code + cart total
    -> Controller validates request
    -> Finds coupon by code
    -> Validity checks (active/date/min-order/max-uses)
    -> Calculates discount
    -> Increments used_count
    -> Returns result summary to UI
```

## Authentication
Authentication routes/controllers are provided by **Laravel Breeze**, while the login/register UI has been customized using Blade/Tailwind components (not the Breeze default page styling).

## Testing

```bash
# Run test suite
php artisan test

# Optional: code style check if Pint is available
./vendor/bin/pint --test
```

## Notes
- UI is built with **Blade templates only** and Tailwind utility classes.
- Coupon listing and dashboard data are fully dynamic from database records.
- Seeder data is for local/demo usage only and can be replaced with production data sources.
