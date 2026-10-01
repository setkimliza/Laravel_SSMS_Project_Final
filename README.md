# FreshMart™ Supermarket Stock Management System (SSMS)

> A role-based Supermarket Stock Management System & E-Commerce Storefront developed with **Laravel 12**, **MySQL**, and **Bootstrap 5**.

---

## 👥 Default Login Accounts

| Portal | URL | Username / Email | Password | Role |
| :--- | :--- | :--- | :--- | :--- |
| **Admin Portal** | `http://127.0.0.1:8000/staff/login` | `admin` | `123` | Full Admin (Analytics, Staff CRUD, All Orders) |
| **Stock Portal** | `http://127.0.0.1:8000/staff/login` | `stock` | `123` | Stock Manager (Inventory, Categories, Expiry Alerts) |
| **Customer Store** | `http://127.0.0.1:8000/login` | `john@example.com` | `123` | Customer Shopper (Catalog, Cart, Checkout, Orders) |
| **Customer Store** | `http://127.0.0.1:8000/login` | `sarah@example.com` | `123` | Customer Shopper (Catalog, Cart, Checkout, Orders) |

---

## ⚡ Quick Setup & Running Locally

Run the following commands in the project root directory:

```bash
# 1. Install PHP dependencies
composer install

# 2. Setup environment configuration
copy .env.example .env
php artisan key:generate

# 3. Migrate database and seed sample data
php artisan migrate:fresh --seed

# 4. Start local development server
php artisan serve
```

Access the application in your browser at: **`http://127.0.0.1:8000`**

---

## 🌟 Key Features

* **Multi-Role Authentication (RBAC):** Dedicated session guards and middleware for **Admin**, **Stock Controller**, and **Customer**.
* **Real-Time Stock & Expiry Control:** Automated detection of **Low Stock** (`Qty <= MinStock`) and **Expired Goods** (`ExpiredDate <= Today`) with FEFO restocking workflow.
* **Customer E-Commerce Storefront:** Department browsing, keyword search, session-based cart, atomic database transactions (`DB::transaction` with row locking), and instant printable invoices.
* **Executive Admin Dashboard:** Business KPIs (Revenue, Orders, Low Stock, Expired), interactive 7-day revenue charts, top-selling products, and staff account management.
* **Database Seeders:** Ready-to-use sample dataset with 7 supermarket departments, 76 real grocery products, test users, and orders.
