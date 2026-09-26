<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SSMSSystemTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test storefront home returns 200.
     */
    public function test_storefront_home_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('FreshMart');
    }

    /**
     * Test grocery catalog loads.
     */
    public function test_catalog_page_loads_with_products(): void
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
    }

    /**
     * Test customer authentication.
     */
    public function test_customer_can_register_and_login(): void
    {
        $email = 'testbuyer_' . time() . '@example.com';

        $registerResponse = $this->post('/register', [
            'name' => 'Test Buyer',
            'email' => $email,
            'phone' => '+1 555-9876',
            'address' => '404 Test Street',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $registerResponse->assertRedirect(route('home'));
        $this->assertAuthenticated('web');

        // Logout
        $this->post('/logout');
        $this->assertGuest('web');

        // Login
        $loginResponse = $this->post('/login', [
            'email' => $email,
            'password' => 'secret123',
        ]);
        $loginResponse->assertRedirect(route('home'));
        $this->assertAuthenticated('web');
    }

    /**
     * Test staff authentication and role based redirection.
     */
    public function test_staff_login_redirects_to_correct_dashboard(): void
    {
        $admin = Staff::where('Role', 'Admin')->first();
        if ($admin) {
            $response = $this->post('/staff/login', [
                'UserName' => $admin->UserName,
                'Password' => 'password123',
            ]);
            $response->assertRedirect(route('admin.dashboard'));
            $this->assertAuthenticatedAs($admin, 'staff');

            // Logout staff
            $this->post('/staff/logout');
            $this->assertGuest('staff');
        }

        $stock = Staff::where('Role', 'Stock')->first();
        if ($stock) {
            $response = $this->post('/staff/login', [
                'UserName' => $stock->UserName,
                'Password' => 'password123',
            ]);
            $response->assertRedirect(route('stock.dashboard'));
            $this->assertAuthenticatedAs($stock, 'staff');
        }
    }

    /**
     * Test Stock staff cannot access Admin-only staff CRUD.
     */
    public function test_stock_staff_forbidden_from_admin_staff_management(): void
    {
        $stock = Staff::where('Role', 'Stock')->first();
        if ($stock) {
            $response = $this->actingAs($stock, 'staff')->get('/admin/staff');
            $response->assertStatus(403);
        }
    }

    /**
     * Test adding product to cart and checking out with inventory stock reduction.
     */
    public function test_cart_and_checkout_flow_reduces_product_stock(): void
    {
        $user = User::first();
        $product = Product::where('Qty', '>', 5)->first();

        $this->assertNotNull($product, 'Test requires at least one product with stock > 5');
        $initialStock = $product->Qty;

        // 1. Add 2 units to cart
        $addResponse = $this->actingAs($user, 'web')->post('/cart/add/' . $product->PID, [
            'quantity' => 2,
        ]);
        $addResponse->assertSessionHas('cart');

        // 2. Perform checkout
        $checkoutResponse = $this->actingAs($user, 'web')->post('/checkout', [
            'phone' => '+1 555-1234',
            'shipping_address' => '789 Grocery Way, Apt 4B',
            'payment_method' => 'Cash on Delivery',
            'customer_notes' => 'Please leave at reception',
        ]);

        $checkoutResponse->assertRedirect();

        // 3. Verify stock was reduced by 2
        $product->refresh();
        $this->assertEquals($initialStock - 2, $product->Qty);

        // 4. Verify order was created in DB
        $latestOrder = Order::latest('OrderID')->first();
        $this->assertEquals($user->id, $latestOrder->UserID);
        $this->assertEquals('Completed', $latestOrder->Status);

        $orderDetail = OrderDetail::where('OrderID', $latestOrder->OrderID)->where('PID', $product->PID)->first();
        $this->assertNotNull($orderDetail);
        $this->assertEquals(2, $orderDetail->Quantity);
    }
}
