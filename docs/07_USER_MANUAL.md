# FreshMart SSMS — User Manual & Operations Guide

---

## 1. Introduction
Welcome to the **FreshMart Supermarket & Store Management System (SSMS)**. This manual provides detailed, step-by-step operating instructions for all three system roles: **Administrator**, **Stock Controller**, and **Customer (User)**.

---

## 2. Administrator Operations Guide

### Accessing the Admin Portal:
1. Navigate to the top announcement bar or footer and click **Staff Portal** (or visit `/staff/login`).
2. Click the quick-fill button **Admin Login** or enter:
   - **Username:** `admin`
   - **Password:** `password123`
3. Click **Access Management Console**. You are automatically directed to `/admin/dashboard`.

---

### Key Admin Tasks:

#### A. Reviewing the Executive Dashboard
- **Financial KPIs:** View Total Sales Revenue, Orders Count, Low Stock Alerts, and Expired Item counts at a glance.
- **7-Day Revenue Trend:** Review the dynamic line graph showing daily sales volume over the past week.
- **Top 5 Selling Departments & Products:** Monitor which items generate the highest volume and revenue.
- **Recent Orders Queue:** Quickly inspect the latest customer transactions.

#### B. Managing Staff Accounts
1. In the left sidebar, click **Staff Management** (`/admin/staff`).
2. **To Create a New Staff Member:**
   - Click the **Add New Staff** button at the top right.
   - Enter a unique **Username** (e.g. `alex_stock`).
   - Select the assigned **Role** (`Stock` or `Admin`).
   - Enter an initial **Password** (min 6 characters).
   - Click **Create Staff Member**.
3. **To Edit or Reset Password:**
   - Locate the staff member and click the pencil icon.
   - Update username or role. To reset password, enter a new one (leave blank to keep existing).
   - Click **Save Changes**.
4. **To Delete a Staff Member:** Click the trash icon and confirm the prompt. (Note: The system prohibits deleting your own logged-in admin account).

#### C. Analyzing Sales & Generating Financial Reports
1. In the sidebar, click **Sales & Analytics** (`/admin/sales`).
2. Specify a **Start Date** and **End Date** in the filter bar and click **Apply Filter**.
3. Review total period revenue, orders processed, grocery units sold, and the daily revenue bar chart.
4. Click **Print Report** (or press `Ctrl+P`) to generate a clean, printer-friendly summary report for executive meetings.

#### D. Customer Order Management & Invoices
1. In the sidebar, click **Customer Orders** (`/admin/orders`).
2. Filter orders by status (`Completed`, `Processing`, `Pending`, `Cancelled`) or search by customer name/email.
3. Click the **Invoice** button next to any order to view the full tax receipt.
4. Change the order status using the dropdown selector and click **Update Status**.

---

## 3. Stock Controller Operations Guide

### Accessing the Stock Portal:
1. Visit `/staff/login`.
2. Click **Stock Controller** or enter:
   - **Username:** `stock`
   - **Password:** `password123`
3. Click **Access Management Console**. You are automatically directed to `/stock/dashboard`.

---

### Key Stock Control Tasks:

#### A. Monitoring the Stock Dashboard
- Review total catalog SKUs, department counts, low-stock alerts, out-of-stock items, and expired shelf goods.
- **Low Stock Replenishment List:** View products where current quantity is below the safety threshold (`Qty <= MinStock`).
- **Inline Quick Restock:** Adjust the number in the input box and click the checkmark button to restock a product instantly without leaving the dashboard.
- **Shelf Expiration List:** Identify expired perishables that must be pulled from the shelves immediately.

#### B. Inventory Warnings & Expiry Inspection
1. In the sidebar, click **Inventory Alerts** (`/stock/alerts`).
2. Use the filter tabs at the top:
   - **All Warnings:** Comprehensive alert list.
   - **Low Stock:** Items needing warehouse reordering.
   - **Expired:** Items past their expiration date.
   - **Expiring Soon (30d):** Products expiring within the next month, ideal for shelf-front rotation or promotional discounts.
3. Click **Print Warning Sheet** to hand a physical checklist to floor staff.

#### C. Managing Products (Product CRUD)
1. In the sidebar, click **Products CRUD** (`/stock/products`).
2. Search items by keyword or SKU, filter by Department, Stock level (Low, Out of Stock, Healthy), or Expiry status.
3. **To Add a New Product:**
   - Click **Add New Product**.
   - Enter **Product Name**, choose **Department**, enter **Price ($)**, **Current Qty**, and **Minimum Safe Stock (MinStock)**.
   - Select the **Shelf Expiration Date**.
   - Optionally upload a product photograph (`.jpg`, `.png`, `.webp`).
   - Enter description or nutritional notes.
   - Click **Register Product**.
4. **To Quick-Adjust Stock:** Enter the new count in the **Quick Adjust** column and click the checkmark icon.
5. **To Edit or Delete:** Use the pencil and trash icons in the actions column.

#### D. Managing Categories (Category CRUD)
1. In the sidebar, click **Categories CRUD** (`/stock/categories`).
2. Click **Add New Category** to create a department (e.g. `Snacks`, `Drinks`, `Bakery`).
3. Enter name, optional Bootstrap Icon (e.g. `bi-basket`), and description.
4. Deleting a category that contains active products is protected by the system. Reassign or remove its products first.

---

## 4. Customer (User) Shopping Guide

### Step 1: Browse Groceries & Search
1. Visit the FreshMart homepage (`/`).
2. Explore departments by clicking any category card (e.g. **Milk & Dairy**, **Snacks**, **Beverages**).
3. Use the search bar in the navbar to search for specific items (e.g. `Cola`, `Chips`, `Rice`).
4. On the catalog page (`/catalog`), sort items by price or name, or filter by "In-Stock items only".

### Step 2: Product Inspection & Adding to Cart
1. Click on any product card to view the dedicated product detail page.
2. Check the real-time stock indicator (e.g. *In Stock (45 available)*) and the **Best Before** expiration date.
3. Select your desired quantity.
4. Click **Add to Shopping Cart**. A green confirmation alert will confirm the addition, and the cart badge in the top right will increment.

### Step 3: Managing the Shopping Cart
1. Click the **Cart icon** in the top navbar (`/cart`).
2. Review chosen items, quantities, and line subtotals.
3. Adjust quantities using the number spinner and click the refresh button.
4. Remove unwanted items using the delete button, or click **Empty Cart** to start over.
5. Review the calculated Subtotal, 5% estimated sales tax, and Free delivery confirmation.
6. Click **Proceed to Checkout**.

### Step 4: Express Checkout & Payment
1. If not logged in, sign in using:
   - **Email:** `john@example.com`
   - **Password:** `password123`
   *(Or click "Create an Account" to register a new profile).*
2. Verify or update your **Recipient Phone Number** and **Delivery Address**.
3. Select your preferred payment method:
   - **Cash on Delivery (COD)** (Default)
   - **Credit/Debit Card**
   - **Instant Bank Transfer**
4. Enter optional delivery instructions in **Order Notes**.
5. Click **Confirm & Place Order**.

### Step 5: Confirmation Receipt & Order History
1. Upon placing the order, you will see the **Order Confirmed** screen displaying your unique Order Number `#0000X`.
2. Click **Print Receipt** to print or save a PDF copy of your tax invoice.
3. Click **View Order History** (or visit `/orders`) at any time to review your past grocery orders and re-print receipts.
