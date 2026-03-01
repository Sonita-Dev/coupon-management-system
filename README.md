# Coupon Management System

A comprehensive Laravel-based coupon management platform for creating, managing, and applying discount coupons with modern web development practices.

## 🚀 Quick Start

```bash
# Clone and setup in minutes
git clone <repository-url>
cd coupon-management-system
composer run setup
php artisan serve
```

Visit `http://127.0.0.1:8000` and start managing coupons!

## 📚 Documentation

- **[📖 Complete Documentation](DOCUMENTATION.md)** - Comprehensive guide with setup, features, and API
- **[🏗️ Architecture Overview](ARCHITECTURE.md)** - System architecture and data flow diagrams
- **[🔧 Setup Guide](#setup--installation)** - Quick setup instructions below

## ✨ Key Features

- 🎫 **Complete Coupon CRUD** - Create, read, update, delete with soft deletes
- 💰 **Flexible Discounts** - Fixed amount and percentage-based discounts
- 📅 **Advanced Validation** - Date ranges, usage limits, minimum order amounts
- 🔄 **Smart Code Reuse** - Reuse coupon codes after deletion with unique constraints
- 🎨 **Modern UI** - Responsive design with Tailwind CSS and Alpine.js
- 🔐 **Secure Auth** - Laravel Breeze authentication with custom styling
- 📊 **Analytics Dashboard** - Track coupon performance and usage statistics
- 🧪 **Comprehensive Testing** - Full test suite with PHPUnit

## 🛠️ Tech Stack

### Backend

- **Laravel 12.0** - Modern PHP framework
- **MySQL** - Database with optimized constraints
- **Eloquent ORM** - Powerful database abstraction
- **Laravel Breeze** - Authentication scaffold

### Frontend

- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript for interactivity
- **Vite** - Fast build tool and dev server
- **Blade Templates** - Laravel's elegant templating

### Development Tools

- **PHPUnit** - Testing framework
- **Laravel Pint** - Code style fixing
- **Faker** - Test data generation

## 📋 Requirements

- **PHP**: ^8.2
- **Composer**: Latest version
- **Node.js**: ^18.0.0
- **Database**: MySQL 8.0+ or MariaDB 10.3+

## ⚙️ Setup & Installation

### Automated Setup (Recommended)

```bash
composer run setup
```

This command handles everything: dependencies, environment setup, migrations, and asset building.

### Manual Setup

#### 1. Install Dependencies

```bash
composer install
npm install
```

#### 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coupon_management_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 3. Database Setup

```bash
php artisan migrate
php artisan db:seed  # Optional: Load sample data
```

#### 4. Build Assets

```bash
npm run build
```

## 🏃‍♂️ How to Run

### Development

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev
```

### Production

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

## 📊 Core Data Model

### Coupons Table

```sql
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `value` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_uses` int unsigned DEFAULT NULL,
  `used_count` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`,`deleted_at`)
);
```

## 🎯 Core Functionalities

### 1. Coupon Management

Full CRUD operations with advanced validation:

```php
// Creating a coupon
$coupon = Coupon::create([
    'code' => 'SUMMER20',
    'type' => 'percent',
    'value' => 20,
    'description' => 'Summer sale discount',
    'start_date' => now(),
    'end_date' => now()->addDays(30),
    'max_uses' => 100,
    'is_active' => true
]);
```

### 2. Smart Validation

Comprehensive business logic validation:

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

### 3. Discount Calculation

Flexible discount logic for different types:

```php
public function calculateDiscount(float $cartTotal): float
{
    $discount = $this->type === 'percent'
        ? $cartTotal * ($this->value / 100)
        : $this->value;

    return round(min($discount, $cartTotal), 2);
}
```

### 4. Dashboard Analytics

Real-time coupon performance metrics:

- Total coupons and active count
- Usage statistics and redemption rates
- Recent activity and top performers

## 🔄 Application Flow

### Coupon Creation Flow

```
User → Create Form → Validation → Database → Success Message
```

### Coupon Application Flow

```
User Input → Validation → Business Rules → Discount Calc → Usage Update → Result
```

### Soft Delete Flow

```
Delete Request → Code Modification → Soft Delete → Database Update
```

## 🔐 Authentication

Built on **Laravel Breeze** with custom UI:

- Secure registration and login
- Email verification (optional)
- Password reset functionality
- Profile management
- Session management

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Code style check
./vendor/bin/pint --test
```

### Test Coverage

- Coupon CRUD operations
- Validation rules
- Discount calculations
- Authentication flows
- Business logic edge cases

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── CouponController.php      # Main coupon logic
│   │   ├── DashboardController.php   # Dashboard analytics
│   │   └── ProfileController.php     # User management
│   └── Requests/
│       ├── StoreCouponRequest.php    # Create validation
│       └── UpdateCouponRequest.php   # Update validation
├── Models/
│   ├── Coupon.php                    # Coupon business logic
│   └── User.php                      # User model
└── Providers/
    └── AppServiceProvider.php

resources/views/
├── coupons/                          # Coupon-related views
├── auth/                            # Authentication views
├── layouts/                         # Layout templates
└── components/                      # Reusable components

database/
├── migrations/                      # Database schema
├── seeders/                         # Sample data
└── factories/                       # Test data factories
```

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set proper file permissions
- [ ] Configure web server (Apache/Nginx)

### Environment Variables

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=production_db
DB_USERNAME=prod_user
DB_PASSWORD=secure_password
```

### Deploy on Vercel

This repository is now prepared for Vercel with:

- `vercel.json` for Laravel request routing and static asset serving
- `api/index.php` as the Vercel PHP serverless entrypoint

1. Push this repository to GitHub
2. In Vercel, create a new project and import this repo.
3. Set these project settings:
    - Framework Preset: `Other`
    - Install Command: `composer install --no-dev --optimize-autoloader && npm ci`
    - Build Command: `npm run build`
4. Add production environment variables in Vercel:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your_generated_key
APP_URL=https://your-vercel-domain.vercel.app

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coupon_management_system
DB_USERNAME=nita
DB_PASSWORD=root123

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
```

5. Deploy once, then run migrations against your production database:

```bash
php artisan migrate --force
```

Notes:

- Vercel filesystem is ephemeral, so do not rely on local file persistence in `storage/`.
- Use a managed external database (PlanetScale, Neon, Supabase, RDS, etc.).

## 🔧 Advanced Features

### Soft Delete with Code Reuse

The system implements intelligent soft deletes that allow coupon code reuse:

```php
// Database constraint includes deleted_at
$table->unique(['code', 'deleted_at'], 'coupons_code_unique');

// Model event modifies code on soft delete
static::deleting(function (Coupon $coupon): void {
    $suffix = '__d_' . $coupon->getKey() . '_' . now()->timestamp;
    $coupon->code = Str::limit($coupon->code, 50 - strlen($suffix)) . $suffix;
});
```

### Real-time Validation

Frontend and backend validation work together:

```php
// Unique validation that respects soft deletes
Rule::unique('coupons', 'code')->where(function ($query) {
    $query->whereNull('deleted_at');
})
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Run the test suite
6. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

- 📖 **[Documentation](DOCUMENTATION.md)** - Complete feature documentation
- 🏗️ **[Architecture](ARCHITECTURE.md)** - System design and data flow
- 🐛 **Issues** - Report bugs via GitHub Issues
- 💬 **Discussions** - Feature requests and general questions

---

**Built with ❤️ using Laravel 12, Tailwind CSS, and modern web development practices.**

_For detailed documentation, see [DOCUMENTATION.md](DOCUMENTATION.md)_
