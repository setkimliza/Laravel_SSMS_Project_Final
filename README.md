# FreshMart SSMS — Supermarket & Store Management System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=flat&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Tests](https://img.shields.io/badge/PHPUnit-100%25%20Passing-success?style=flat&logo=checkmarx)](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/tests/Feature/SSMSSystemTest.php)

FreshMart SSMS is an enterprise-ready, role-based Supermarket and Store Management System developed with **Laravel 12** and **MySQL**. It seamlessly links public customer grocery ordering to real-time warehouse inventory management, shelf-life expiration monitoring, atomic checkout stock reductions, and financial business intelligence.

---

## 🚀 Key System Features

- **1. Multi-Guard Authentication & RBAC:**
  - Dedicated portals for `ADMIN`, `STOCK`, and `USER` (Customer).
  - Role-based middleware restricting administrative operations.
  - Password hashing via Bcrypt (min 12 rounds).

- **2. Stock Control & Shelf Freshness:**
  - Dynamic Low-Stock warning badges when `Qty <= MinStock`.
  - Automated Shelf-Life Expiration detection when `ExpiredDate <= today`.
  - 30-Day Expiring-Soon warning window for clearance promotions.
  - Inline one-click quick restock adjustments.

- **3. Interactive Customer Storefront:**
  - Responsive catalog with keyword search and department filters.
  - Session-backed shopping cart validating maximum available stock.
  - Atomic database transactions (`DB::transaction`) with row locking (`lockForUpdate`) guaranteeing accurate stock deductions upon order placement.
  - Instant printable customer invoices and order history tracking.

- **4. Executive Administration & Reports:**
  - High-level KPI summary cards (Revenue, Orders, Low Stock, Expired Goods).
  - Dynamic 7-day revenue trend chart via Chart.js.
  - Ranked lists of top-selling products and top-selling supermarket departments.
  - Full staff account CRUD and order status management.

---

## 👥 Demo Access Credentials

| Role | Portal URL | Username / Email | Password | Primary Capabilities |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | `/staff/login` | `admin` | `password123` | Full control, Staff CRUD, Sales Reports, All Orders |
| **Stock Controller**| `/staff/login` | `stock` | `password123` | Products CRUD, Categories CRUD, Quick Restock, Expiry Alerts |
| **Customer (Shopper)**| `/login` | `john@example.com` | `password123` | Storefront catalog, Cart, Checkout, Order History |

---

## 🗄️ Database Architecture (6 Core Tables)

1. `staff` (`Sid`, `UserName`, `Password`, `Role`, timestamps)
2. `users` (`id`, `name`, `email`, `phone`, `address`, `password`, timestamps)
3. `categories` (`CatID`, `name`, `description`, `icon`, timestamps)
4. `products` (`PID`, `PName`, `Qty`, `MinStock`, `Price`, `ExpiredDate`, `CatID`, `image`, `description`, timestamps)
5. `orders` (`OrderID`, `UserID`, `TotalAmount`, `OrderDate`, `Status`, `payment_method`, `shipping_address`, timestamps)
6. `order_details` (`OrderDetailID`, `OrderID`, `PID`, `Quantity`, `Price`, `Subtotal`, timestamps)

---

## 📚 Complete Project Planning Documents

The project includes 8 comprehensive planning and architectural documents located in the [`docs/`](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs) directory:

1. [Project Plan](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/01_PROJECT_PLAN.md)
2. [Analysis & Feasibility Study](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/02_FEASIBILITY_STUDY.md)
3. [System Requirements Specification (SRS)](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/03_SYSTEM_REQUIREMENTS_SPECIFICATION.md)
4. [Database Design Document (with Mermaid ERD)](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/04_DATABASE_DESIGN_DOCUMENT.md)
5. [UI/UX Design Document](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/05_UI_UX_DESIGN_DOCUMENT.md)
6. [QA & Test Document (with Test Cases & Bug Register)](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/06_QA_TEST_DOCUMENT.md)
7. [User Manual & Operations Guide](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/07_USER_MANUAL.md)
8. [Final Project Report](file:///d:/Sunrise%20Institute/Laravel/Laravel-Project-SSMS/docs/08_FINAL_PROJECT_REPORT.md)

---

## 🛠️ Quick Start & Running Locally

1. **Verify Database:**
   Ensure MySQL is running and `.env` has:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_mart_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Run Migrations & Seed Sample Data:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

3. **Run Automated Test Suite:**
   ```bash
   php vendor/phpunit/phpunit/phpunit tests/Feature/SSMSSystemTest.php
   ```

4. **Launch Local Server:**
   ```bash
   php artisan serve
   ```
   Open `http://localhost:8000` in your web browser.
