# FreshMart SSMS — Final Project Report

---

## 1. Executive Summary & Introduction
The **FreshMart Supermarket & Store Management System (SSMS)** is a comprehensive retail enterprise software solution developed using **Laravel 12** and **MySQL**. It addresses the operational complexities of physical and online supermarkets by unifying customer grocery shopping, real-time inventory tracking, automated shelf-life expiration monitoring, role-based staff operations, and financial sales analytics.

The system was delivered on schedule across 10 disciplined development phases, fulfilling all functional, database, security, and user-experience criteria specified in the project charter.

---

## 2. System Analysis
Supermarket retail requires precise synchronization between front-end checkout and back-end inventory. Investigation into existing grocery store operations revealed three major vulnerabilities:
1. **Unmonitored Shelf Spoilage:** Physical manual inspections frequently miss perishables nearing their expiration dates, leading to write-off losses and health violations.
2. **Stockout Disruptions:** When popular items drop below safety thresholds, stores experience lost sales before reordering can occur.
3. **Privilege Creep:** Lack of role segregation creates security risks when non-managerial staff have access to sensitive financial records or staff credentials.

The FreshMart SSMS eliminates these challenges through:
- Automated calculation of shelf expiration status (`isExpired()` and `isExpiringSoon(30)`).
- Dynamic minimum-stock triggers (`Qty <= MinStock`).
- Multi-guard Role-Based Access Control enforcing strict separation between `ADMIN`, `STOCK`, and `USER` roles.

---

## 3. System Design & Architecture

### Architectural Model:
The system adheres to Laravel's robust Model-View-Controller (MVC) architecture, separating business logic, data models, and responsive client presentations:
- **Models (`App\Models`):** Eloquent models representing `Staff`, `User`, `Category`, `Product`, `Order`, and `OrderDetail` with relationship bindings and dynamic attribute scopes.
- **Controllers (`App\Http\Controllers`):** Segregated into `Auth`, `Admin`, `Stock`, and `Customer` namespaces for modular maintenance.
- **Middleware (`App\Http\Middleware`):** `StaffRole` middleware inspecting authenticated staff roles and enforcing granular route permissions.
- **Database Architecture:** Relational schema comprising 6 core tables in 3NF with foreign keys and cascade rules.

```text
[ Client Browser ]
       │
       ▼
[ Laravel 12 HTTP Router (50 Registered Routes) ]
       │
       ├── Middleware: staff.role:Admin ────> Admin Controllers
       ├── Middleware: staff.role:Admin,Stock > Stock Controllers
       └── Middleware: auth:web ────────────> Customer Checkout & Orders
       │
       ▼
[ Eloquent ORM & Query Builder ]
       │
       ▼
[ MySQL 8.0+ / MariaDB Database (laravel_mart_db) ]
```

---

## 4. Implementation Details

### Module Delivery Highlights:
1. **Multi-Guard Authentication:**
   - Public customer login and registration using the standard `web` guard.
   - Staff portal login using the dedicated `staff` guard with `UserName` and hashed `Password`.
2. **Stock & Shelf Expiration Management:**
   - Products feature `Qty` and `MinStock` fields. Products where `Qty <= MinStock` trigger yellow alert badges.
   - Products feature `ExpiredDate`. Items with dates in the past trigger red EXPIRED warnings; items with dates within 30 days trigger warning notices.
   - Inline quick-restock inputs allow floor personnel to adjust quantities instantly.
3. **Transactional Shopping Cart & Checkout:**
   - Session-backed shopping cart enforcing maximum available stock limits.
   - Atomic database transactions (`DB::transaction`) with row-level pessimistic locking (`lockForUpdate`) prevent race conditions during checkout.
   - Automated stock decrement: `Product::decrement('Qty', $quantity)` upon order creation.
4. **Sales Analytics & Executive Reporting:**
   - Dynamic revenue calculation over arbitrary date ranges.
   - Interactive 7-day revenue trend visualization using Chart.js.
   - Ranked lists of top-selling products and top-selling supermarket departments.
   - Printable tax invoices with browser print integration.

---

## 5. Quality Assurance & Verification
System testing verified zero critical bugs across 20 distinct scenarios:
- **Automated Test Suite:** 6 comprehensive PHPUnit feature tests containing 30 assertions executed with 100% pass rate (`OK (6 tests, 30 assertions)` in 4.5 seconds).
- **Security Validation:** Confirmed that stock controllers receive HTTP 403 Forbidden when attempting to access administrator-only staff CRUD routes.
- **Data Integrity Validation:** Confirmed that deleting a category containing active products is blocked, preserving relational consistency.

---

## 6. Project Results & Achievements

| Metric / Objective | Target | Achieved Result |
| :--- | :--- | :--- |
| **System Modules Delivered** | 10 Main Modules | 10 Modules Fully Operational |
| **Database Tables Created** | 6 Main Tables | 6 Tables with Relationships & Foreign Keys |
| **Role Matrix Alignment** | Admin, Stock, User | 100% Adherence to Permission Matrix |
| **Documentation Deliverables** | 8 Documents | 8 Professional Markdown Documents in `/docs` |
| **Automated Test Pass Rate** | 100% | 100% (6/6 Feature Tests, 30/30 Assertions) |
| **View Compilation** | 0 Blade Syntax Errors | 100% Validated via `php artisan view:cache` |

---

## 7. Conclusion
The **FreshMart Supermarket & Store Management System** successfully delivers a robust, secure, and user-friendly digital retail ecosystem. By linking customer checkout directly to real-time stock deduction, automated low-stock warnings, and shelf-life expiration alerts, the platform empowers store managers to reduce inventory write-offs, prevent stockouts, and maximize customer satisfaction.

---

## 8. Recommendations for Future Improvements
1. **Barcode / QR Code Scanner Hardware Integration:** Incorporate WebAssembly or HID USB barcode scanner listeners to allow cashiers to scan physical product barcodes directly into the POS/cart.
2. **Automated Supplier Purchase Orders (EDI):** Implement automated supplier purchase order generation when a product reaches `Qty <= MinStock`.
3. **Live Payment Gateway Integration:** Integrate Stripe, PayPal, or localized mobile payment webhooks (e.g., Apple Pay, Google Pay).
4. **Customer Loyalty Points & Promo Codes:** Introduce voucher discount codes and points accumulation per dollar spent.
5. **Mobile Applications (iOS/Android):** Package the storefront into mobile apps using Capacitor or React Native utilizing Laravel REST/JSON API endpoints.
