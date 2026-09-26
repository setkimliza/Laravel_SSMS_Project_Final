# FreshMart SSMS — UI/UX Design Document

---

## 1. Design Philosophy & Aesthetic Goals
The FreshMart SSMS user interface was engineered to transcend conventional, flat enterprise portals. It blends consumer-grade visual elegance with high-efficiency administrative ergonomics:
- **Visual Warmth & Freshness:** Vibrant emerald and forest greens reflect grocery freshness and clean organic produce.
- **Cognitive Clarity:** Immediate visual status mapping using universally recognized color semantics:
  - **Green (`#10b981`):** In stock, active, completed transactions.
  - **Amber / Yellow (`#f59e0b`):** Low-stock threshold warning, expiring soon, pending status.
  - **Red (`#ef4444`):** Out of stock, expired shelf item, cancelled orders.
- **Micro-Interactions & Motion:** Subtle hover elevations (`translateY(-4px)`), backdrop blurs, and pill-shaped interactive touch targets.

---

## 2. Design System Tokens

### Typography:
- **Font Family:** `'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif`
- **Headings:** Bold to Extra-Bold (`font-weight: 700 - 800`) with tight tracking (`letter-spacing: -0.5px`).
- **Body & Data:** Medium (`font-weight: 400 - 500`) with high legibility on high-density data tables.

### Color Palette:
| Token Name | Hex Code | Purpose |
| :--- | :--- | :--- |
| `--primary` | `#10b981` | Primary Brand Green, Action Buttons, Success Badges |
| `--primary-dark` | `#059669` | Hover States, Navbar Brand Accent |
| `--primary-light`| `#d1fae5` | Subtle Accent Backgrounds, Pills |
| `--dark` | `#0f172a` | Sidebar Background, Footer, Primary Headings |
| `--sidebar-hover`| `#1e293b` | Active / Hover Sidebar Navigation Items |
| `--card-bg` | `#ffffff` | Clean Elevated Surface |
| `--border-color` | `#e2e8f0` | Subtle Card and Table Outlines |

---

## 3. Screen Specifications & Wireframe Layouts

### 1. Customer Homepage (`/`)
- **Top Announcement Bar:** Shipping promotion banner with staff login gateway.
- **Header:** Sticky navbar with search input, active category navigation, reactive cart badge counter, and customer account dropdown.
- **Hero Banner:** Full-width emerald gradient showcase with value tags and CTA button.
- **Category Department Grid:** 10 department cards with custom Bootstrap icons and product counters.
- **Fresh Arrivals Grid:** Responsive 4-column product cards featuring image container, low-stock badge, price tag, and 1-click "Add to Cart" button.

### 2. Product Catalog (`/catalog`)
- **Sticky Filter Sidebar:** Full listing of all 10 supermarket departments with dynamic counter badges and an "In-stock items only" checkbox toggle.
- **Top Toolbar:** Keyword search input and sorting dropdown (Newest, Price: Low to High, Price: High to Low, Name).
- **Product Grid:** Responsive card deck with stock indicators and out-of-stock disable states.
- **Pagination:** Clean Bootstrap 5 pagination controls.

### 3. Product Details View (`/product/{id}`)
- **Breadcrumb:** Step-by-step navigation path (`Home > Groceries > Department > Product Name`).
- **Showcase Container:** 50/50 split layout. Left: Clean high-res product photo. Right: Price display, stock count badge, shelf expiration date badge, detailed description, and quantity spinner with "Add to Cart" button.
- **Related Products:** Carousel of complementary items within the same supermarket department.

### 4. Shopping Cart (`/cart`)
- **Itemized Table:** Product thumbnail, SKU, item name, unit price, inline quantity updater form with max stock ceiling enforcement, line subtotal, and remove button.
- **Summary Sidebar:** Sticky card showing calculated Subtotal, 5% estimated sales tax, free shipping badge, grand total, and "Proceed to Checkout" button.
- **Empty State:** Illustrated card encouraging users to explore the catalog when empty.

### 5. Checkout Screen (`/checkout`)
- **Two-Column Layout:**
  - *Left Column:* Delivery recipient details, telephone verification, street address, order notes, and payment method selector (Cash on Delivery, Credit/Debit, Instant Bank Transfer).
  - *Right Column:* Order review panel listing all cart items, pricing breakdown, SSL secure checkout guarantee, and "Confirm & Place Order" button.

### 6. Order Confirmation & Receipt (`/checkout/success/{id}`)
- **Celebration Banner:** Green checkmark badge with unique order number `#0000X`.
- **Printable Tax Invoice:** Formatted receipt box displaying supermarket details, customer name, delivery address, itemized line items, unit prices, line totals, and grand total with browser `window.print()` functionality.

### 7. Customer Order History (`/orders`)
- **History Table:** Order number, timestamp, item count badge, payment method, grand total, colored status pill, and "View Receipt" button.

### 8. Staff Login Portal (`/staff/login`)
- **Dedicated Security Gate:** Dark-themed authentication card with staff credentials input.
- **Demo Quick-Fill Helper:** Clickable pill buttons to auto-populate Admin (`admin` / `password123`) or Stock Controller (`stock` / `password123`) credentials.

### 9. Admin Dashboard (`/admin/dashboard`)
- **7 Core KPI Stat Cards:** Total Sales ($), Customer Orders, Low Stock Alerts, Expired Products, Total SKUs, Staff Count, Registered Customers.
- **Interactive Chart.js Trend:** 7-day daily revenue performance graph.
- **Top 5 Selling Departments:** Visual progress bars displaying units sold per category.
- **Top 5 Selling Products & Recent Orders:** Quick audit tables.
- **Urgent Action Lists:** Quick-restock and expired item pull lists.

### 10. Stock Dashboard (`/stock/dashboard`)
- **Inventory Health KPIs:** Catalog items, departments, low-stock count, out-of-stock count, expired count, expiring-soon count.
- **Low Stock Replenishment Table:** Includes an inline quick-restock input form allowing stock controllers to update quantities with one click.
- **Shelf Expiration Tracker:** Highlights expired items and items expiring within 30 days.

### 11. Product Management CRUD (`/stock/products`)
- **Data Table:** Product photo, PID, Name, Category, Price, Stock level badge, Expiry date, inline stock adjuster, Edit and Delete actions.
- **Filter Bar:** Multi-criteria filtering by Keyword, Department, Stock level, and Expiration status.
- **Forms (Create/Edit):** Clean multi-column form with image file upload, required field validations, and safe defaults.

### 12. Category Management CRUD (`/stock/categories`)
- **Department Table:** CatID, Icon preview circle, Name, Description, Linked Product count badge, Edit and Delete actions (protected against deleting categories that contain active products).

### 13. Sales Reports & Orders Management (`/admin/sales`, `/admin/orders`)
- **Date Filter Form:** Start and End date range picker.
- **Revenue Bar Chart:** Daily revenue breakdown over selected period.
- **Top-Selling Rankings:** Volume and revenue statistics for products and departments.
- **Order Management:** Status change dropdown (Processing, Completed, Cancelled) and full-screen printable invoice.
