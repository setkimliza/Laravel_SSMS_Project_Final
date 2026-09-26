# FreshMart SSMS — System Requirements Specification (SRS)

---

## 1. Introduction & Purpose
This document specifies the complete software requirements for the **FreshMart Supermarket & Store Management System (SSMS)**. It outlines functional and non-functional requirements, user and system hardware/software specifications, and the definitive Role-Based Access Control (RBAC) permission matrix.

---

## 2. Functional Requirements (FR)

### Module 1: Authentication & Authorization
- **FR-1.1:** The system shall allow public shoppers to register a customer account with their name, unique email address, phone, address, and password.
- **FR-1.2:** The system shall provide secure customer login with email/password authentication using standard session security.
- **FR-1.3:** The system shall provide a dedicated Staff Portal login accepting `UserName` and `Password`.
- **FR-1.4:** Passwords must be hashed using the Bcrypt hashing algorithm with minimum 12 salt rounds before database persistence.
- **FR-1.5:** Middleware must intercept incoming requests and redirect unauthenticated or unauthorized users with appropriate HTTP 403 or redirect responses.

### Module 2: Admin Management
- **FR-2.1:** The Administrator shall have exclusive access to the Admin Dashboard displaying core KPIs: Total Products, Total Staff, Total Users, Total Orders, Total Sales Revenue, Low Stock Count, Expired Products Count.
- **FR-2.2:** The Administrator shall view interactive 7-day sales charts and lists of top-selling products and categories.
- **FR-2.3:** The Administrator shall view all customer orders, filter by status, and update statuses (e.g. Processing, Completed, Cancelled).

### Module 3: Staff Management
- **FR-3.1:** The system shall permit only Administrators to create, view, edit, and delete staff accounts.
- **FR-3.2:** Staff records must store `Sid`, unique `UserName`, hashed `Password`, and assigned `Role` (`Admin` or `Stock`).
- **FR-3.3:** The system must prohibit an administrator from deleting their own currently logged-in account.

### Module 4: Category Management
- **FR-4.1:** Authorized staff (`Admin` and `Stock`) shall create new categories with unique name, description, and visual icon class.
- **FR-4.2:** Authorized staff shall update existing category names and details.
- **FR-4.3:** The system must prevent deletion of any category that currently contains active products to ensure relational integrity.

### Module 5: Product Management
- **FR-5.1:** Authorized staff shall create new product records specifying `PName`, `CatID`, `Price`, `Qty`, `MinStock`, `ExpiredDate`, image, and description.
- **FR-5.2:** Authorized staff shall view the product catalog with keyword search and department filters.
- **FR-5.3:** Authorized staff shall edit any product's details and upload new product images.
- **FR-5.4:** The system shall provide an inline quick-adjustment input to update shelf stock quantities instantly.
- **FR-5.5:** Deletion of products linked to historical customer orders must be prevented or restricted to maintain audit trails.

### Module 6: Stock Control & Shelf Expiry Monitoring
- **FR-6.1:** The system shall automatically flag an item as **LOW STOCK** whenever `Qty <= MinStock`.
- **FR-6.2:** The system shall automatically flag an item as **EXPIRED** whenever `ExpiredDate <= current_date()`.
- **FR-6.3:** The system shall flag an item as **EXPIRING SOON** whenever `ExpiredDate` falls within the upcoming 30 days.
- **FR-6.4:** The system shall display a dedicated Inventory Alerts page with filterable views for Low Stock, Expired, and Expiring Soon items.

### Module 7: Shopping Cart
- **FR-7.1:** The system shall allow customers to add in-stock products to their session shopping cart.
- **FR-7.2:** The system must prevent adding or updating cart quantities beyond the current available inventory `Qty`.
- **FR-7.3:** The system must block expired products from being added to the shopping cart.
- **FR-7.4:** The cart must dynamically compute:
  $$\text{Subtotal} = \sum (\text{Unit Price} \times \text{Quantity})$$
  $$\text{Sales Tax} = \text{Subtotal} \times 0.05$$
  $$\text{Total Amount} = \text{Subtotal} + \text{Sales Tax}$$

### Module 8: Checkout & Orders
- **FR-8.1:** The system shall require customer login prior to proceeding with order placement.
- **FR-8.2:** The checkout process must execute inside an ACID database transaction (`DB::transaction`).
- **FR-8.3:** The system must lock product records (`lockForUpdate`), re-verify stock availability, create an `Order` record, create associated `OrderDetail` records, and decrement inventory stock (`Product::decrement('Qty')`).
- **FR-8.4:** Upon successful placement, the cart must be emptied, and the customer redirected to a printable confirmation receipt.
- **FR-8.5:** Customers must be able to view their complete past order history and individual order details.

### Module 9: Sales & Financial Reports
- **FR-9.1:** The Administrator shall filter sales analytics by arbitrary date ranges (`start_date` to `end_date`).
- **FR-9.2:** The system shall compute total revenue, total orders processed, and total grocery units sold within the selected period.
- **FR-9.3:** The system shall generate lists of top 10 selling products and top 10 selling departments ranked by sales volume.

### Module 10: Role-Based Dashboards
- **FR-10.1:** Admin Dashboard: Full system financial KPIs, staff count, order statistics, stock warnings, sales chart.
- **FR-10.2:** Stock Dashboard: Inventory statistics, low-stock replenishment list, shelf expiration warnings, department item counts.
- **FR-10.3:** Customer Storefront: Featured categories, fresh arrivals, banner promotions, shopping cart, customer order history.

---

## 3. Non-Functional Requirements (NFR)

### Security Requirements:
- **NFR-S1:** Passwords must be hashed using Bcrypt. Plaintext passwords must never be stored or logged.
- **NFR-S2:** All form submissions must include a valid CSRF token (`@csrf`) to protect against Cross-Site Request Forgery.
- **NFR-S3:** Database queries must use parameterized statements or Eloquent ORM to eliminate SQL Injection vulnerabilities.
- **NFR-S4:** User sessions must invalidate and regenerate tokens upon login and logout.

### Performance Requirements:
- **NFR-P1:** Catalog and dashboard page response times must not exceed 500ms under standard local network conditions.
- **NFR-P2:** Database schema must utilize primary keys and indexed foreign keys for rapid join lookups.

### Usability & Responsiveness:
- **NFR-U1:** The web interface must be fully responsive across mobile (375px+), tablet, and desktop viewports.
- **NFR-U2:** Visual indicators must follow universal conventions (Green = In Stock / Completed, Yellow = Low Stock / Pending, Red = Expired / Out of Stock).

---

## 4. System & Hardware Requirements

### Server Requirements:
- **Operating System:** Windows 10/11, Ubuntu 20.04+, or macOS
- **PHP Version:** PHP 8.2 or higher (with `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `curl` extensions enabled)
- **Database Engine:** MySQL 8.0+ or MariaDB 10.4+
- **Composer:** Composer 2.x
- **Web Server:** Apache (via XAMPP/WAMP) or Nginx or Laravel built-in development server

### Client Requirements:
- Any modern web browser: Google Chrome 90+, Mozilla Firefox 88+, Microsoft Edge 90+, Apple Safari 14+.

---

## 5. Final Role Permission Matrix

| Feature / Action | Admin | Stock Controller | Customer (User) |
| :--- | :---: | :---: | :---: |
| **Customer Registration** | ❌ | ❌ | ✅ |
| **Customer Login** | ❌ | ❌ | ✅ |
| **Staff Portal Login** | ✅ | ✅ | ❌ |
| **Admin Dashboard** | ✅ | ❌ | ❌ |
| **Stock Dashboard** | ✅ | ✅ | ❌ |
| **Staff CRUD (Create/Edit/Delete)** | ✅ | ❌ | ❌ |
| **Category CRUD** | ✅ | ✅ | ❌ |
| **Product CRUD** | ✅ | ✅ | ❌ |
| **Quick Stock Adjustment** | ✅ | ✅ | ❌ |
| **Low-Stock Alert Inspection** | ✅ | ✅ | ❌ |
| **Shelf Expiration Inspection** | ✅ | ✅ | ❌ |
| **Browse Catalog & Search** | ✅ | ✅ | ✅ |
| **Shopping Cart Management** | ❌ | ❌ | ✅ |
| **Checkout & Place Orders** | ❌ | ❌ | ✅ |
| **View Personal Order History** | ❌ | ❌ | ✅ |
| **Manage All Orders & Statuses** | ✅ | ❌ | ❌ |
| **Sales Analytics & Revenue Reports**| ✅ | ❌ | ❌ |
| **Printable Tax Invoices** | ✅ | ❌ | ✅ (Own orders) |
