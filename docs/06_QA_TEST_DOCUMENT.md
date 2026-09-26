# FreshMart SSMS — QA & Test Document

---

## 1. Quality Assurance Strategy & Plan
The QA process for FreshMart SSMS validates that all functional requirements, security boundaries, inventory calculations, and UI interactions execute accurately without regressions.

### Testing Methodologies Employed:
1. **Automated Feature & Unit Testing:** PHPUnit test suite validating HTTP status codes, session persistence, authentication guards, database mutations, and ACID transactions.
2. **Role Authorization Testing:** Strict boundary verification ensuring users without appropriate roles receive HTTP 403 Forbidden responses.
3. **Database Integrity Testing:** Verification that `DB::transaction()` rolls back if any inventory constraint or stock shortage occurs during checkout.
4. **End-to-End User Simulation:** Testing the full customer shopping journey from browsing to stock deduction and invoice generation.

---

## 2. Test Execution Matrix

| Test ID | Module | Test Scenario & Objective | Input / Test Action | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-01** | Storefront | Public landing page load | `GET /` | Returns HTTP 200 with FreshMart brand banner & featured items | HTTP 200 OK | **PASS** |
| **TC-02** | Catalog | Grocery catalog browsing | `GET /catalog` | Returns HTTP 200 with product list and active department pills | HTTP 200 OK | **PASS** |
| **TC-03** | Auth | Customer account registration | `POST /register` with valid profile data | User created in `users` table, authenticated via `web` guard, redirected to `/` | User created and logged in | **PASS** |
| **TC-04** | Auth | Customer login with valid credentials | `POST /login` (`john@example.com` / `password123`) | Session established, redirected to `/` with success toast | Session created successfully | **PASS** |
| **TC-05** | Auth | Customer login with invalid credentials | `POST /login` with wrong password | Returns HTTP 302 back with error message in `$errors` | Validation error returned | **PASS** |
| **TC-06** | Auth | Staff login with Admin role | `POST /staff/login` (`admin` / `password123`) | Authenticated via `staff` guard, redirected to `/admin/dashboard` | Redirected to Admin Dashboard | **PASS** |
| **TC-07** | Auth | Staff login with Stock role | `POST /staff/login` (`stock` / `password123`) | Authenticated via `staff` guard, redirected to `/stock/dashboard` | Redirected to Stock Dashboard | **PASS** |
| **TC-08** | Security | Stock role access to Admin-only Staff CRUD | Authenticate as `Stock`, `GET /admin/staff` | Intercepted by `staff.role:Admin` middleware, returns HTTP 403 Forbidden | HTTP 403 Forbidden | **PASS** |
| **TC-09** | Cart | Add in-stock product to cart | `POST /cart/add/1` with `quantity=2` | Session cart contains product, quantity=2, and correct subtotal | Product added to session cart | **PASS** |
| **TC-10** | Cart | Add product exceeding stock ceiling | Product `Qty=3`, `POST /cart/add` with `quantity=5` | Request rejected with warning: "Only 3 item(s) available in stock" | Exceeding quantity blocked | **PASS** |
| **TC-11** | Cart | Add expired product to cart | Product `ExpiredDate <= today`, `POST /cart/add` | Request rejected: "This product has expired and cannot be sold" | Expired item blocked | **PASS** |
| **TC-12** | Checkout | Complete checkout and stock deduction | Authenticated customer checks out with 2 items | Order created, OrderDetail created, Product `Qty` decremented by 2, Cart cleared | Stock accurately decremented by 2 | **PASS** |
| **TC-13** | Stock | Low-stock detection logic | Product with `Qty=3`, `MinStock=10` | `isLowStock()` returns `true`, product displays yellow alert badge | Low stock badge displayed | **PASS** |
| **TC-14** | Stock | Expiry detection logic | Product with `ExpiredDate` 3 days in past | `isExpired()` returns `true`, product displays red EXPIRED badge | Red expired badge displayed | **PASS** |
| **TC-15** | Stock | Inline quick-restock update | `POST /stock/products/{id}/quick-stock` with `Qty=50` | Product `Qty` updated to 50 in database, success toast displayed | Quantity updated to 50 | **PASS** |
| **TC-16** | Admin | Create new staff account | `POST /admin/staff` (Username: `newstaff`, Role: `Stock`) | New record in `staff` with Bcrypt password hash | Record created and hashed | **PASS** |
| **TC-17** | Admin | Prevent self-deletion of Admin account | Currently logged-in admin attempts `DELETE /admin/staff/{selfId}` | Action blocked: "Action denied: You cannot delete your own logged-in admin account" | Self-deletion prevented | **PASS** |
| **TC-18** | Category | Category delete protection | Attempt `DELETE /stock/categories/{id}` with linked products | Deletion blocked: "Cannot delete category because it contains active products" | Foreign key integrity preserved | **PASS** |
| **TC-19** | Reports | Sales date range filter | `GET /admin/sales?start_date=2025-01-01&end_date=2025-01-31` | Computes accurate revenue, orders count, and daily chart data | Revenue accurately filtered | **PASS** |
| **TC-20** | Order Status | Admin updates order status | `POST /admin/orders/{id}/status` with `status=Completed` | Order `Status` column updated, badge color updates to green | Status updated in DB | **PASS** |

---

## 3. Automated Test Suite Execution Summary
The automated test suite (`tests/Feature/SSMSSystemTest.php`) was executed via PHPUnit on the active database:

```text
Runtime:       PHP 8.4.23
Configuration: D:\Sunrise Institute\Laravel\Laravel-Project-SSMS\phpunit.xml

......                                                              6 / 6 (100%)

Time: 00:04.502, Memory: 38.00 MB

OK (6 tests, 30 assertions)
```

### Verified Test Cases in Automated Suite:
1. `test_storefront_home_returns_successful_response` &bull; **PASS**
2. `test_catalog_page_loads_with_products` &bull; **PASS**
3. `test_customer_can_register_and_login` &bull; **PASS**
4. `test_staff_login_redirects_to_correct_dashboard` &bull; **PASS**
5. `test_stock_staff_forbidden_from_admin_staff_management` &bull; **PASS**
6. `test_cart_and_checkout_flow_reduces_product_stock` &bull; **PASS**

---

## 4. Bug Tracking & Resolution Register

| Bug ID | Severity | Discovered In | Description | Root Cause | Resolution | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :---: |
| **BUG-01** | Medium | Authentication | Staff password field in table was named `Password` (uppercase P) | Laravel `Authenticatable` expects `getAuthPassword()` to match column name | Added `getAuthPassword()` override in `App\Models\Staff` returning `$this->Password` | **RESOLVED** |
| **BUG-02** | High | Checkout | Concurrent checkouts could theoretically oversell stock | Race condition if two users purchase last item simultaneously | Added `lockForUpdate()` within `DB::transaction()` in `CheckoutController` | **RESOLVED** |
| **BUG-03** | Low | UI | Category deletion could orphan foreign key in products | Deleting category without checking products | Added product count check in `CategoryController::destroy` to prevent accidental deletion | **RESOLVED** |
| **BUG-04** | Low | Images | Missing product image file could cause broken thumbnail icon | No default fallback image provided | Created clean SVG fallback (`product-placeholder.svg`) in `public/images` | **RESOLVED** |
