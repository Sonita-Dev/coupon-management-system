Coupon Management System

Create a coupon management system web bassed following these requirements:


Technology stack:
- Use Laravel 
- Use Laravel Blade for Screen/UI (keep it simple, no other framework need)
- Database: MySQL
- prepare deployment setup ready to host on Vercel

Topic: Coupon Management System (a simple admin panel to manage discount coupons).

*Core Requirements & Scope (must include these – keep it minimal but complete and professional):

1. Authentication: Simple admin login system ( make it simple, use Laravel Breeze for quick scaffolding – admin-only access is enough, no user registration needed,  keep it simple by using laravel blade for screen/UI — only use other framework needed).
2. Database: Use MySQL (I will config the connection manually). Create at least one main table for coupons management (manage discount coupon, with date validation)

3. Main Features (Admin CRUD + Basic Logic):
a. Dashboard: Show summary stats (total coupons, active coupons, expired coupons, total used count).
b. Full CRUD for coupons:
     - List all coupons (table with search/filter by code/status/active/expired).
     - Create new coupon (form with validation: unique code, positive value, end_date > start_date if both set).
     - View/Edit coupon details.
     - Delete coupon (or soft-delete).
c. Basic coupon apply simulation/test page (very important for demo):
     - A simple form/page (can be admin-only or public for demo): enter coupon code + fake cart total amount.
     - Validate the coupon (check: exists, active, not expired, min order met, uses remaining).
     - If valid: calculate & show discount, new total, and increment used_count.
     - Show clear error messages for invalid cases.
d. Use Laravel Resource Controller, Validation (Form Requests preferred), Blade templates (no others framework needed), and Eloquent.

4. Additional Must-Dos:
   - Seed the database with 10–15 sample coupons.
   - Use proper routing (resource routes for coupons).
   - Add basic styling 
   - Handle success/error messages 
   - Test edge cases: expired coupon, over-used, min order not met, invalid code.