<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;
    
     /**
     * Test success checkout page redirect to payment page
     *
     * @return void
     */
    public function test_checkout_success()
    {
        $body =  [
            "id" => "cs_h8CJFNBotp3iPhFd", 
            "object" => "checkout.session", 
            "amount_subtotal" => 2500, 
            "amount_total" => 2500, 
            "bank_code" => null, 
            "branding" => [
                    "icon" => null, 
                    "logo" => null, 
                    "use_logo" => true, 
                    "primary_color" => "#fff", 
                    "secondary_color" => "#000" 
                ], 
            "billing" => null, 
            "billing_address_collection" => true, 
            "cancel_url" => "http://localhost:8000/checkout/callback?success=0", 
            "client_reference_id" => null, 
            "created" => 1674742974186, 
            "currency" => "php", 
            "customer" => null, 
            "customer_name" => null, 
            "customer_email" => "herald_suva@yahoo.com", 
            "customer_phone" => null, 
            "description" => null, 
            "line_items" => [
                [
                    "image" => "https://img.fragrancex.com/images/products/sku/large/vervmdf.webp", 
                    "amount" => 2500, 
                    "quantity" => 1, 
                    "name" => "Versace Eros", 
                    "description" => "50 ml Eau De Parfum Spray", 
                    "attributes" => [
                        "image" => "https://img.fragrancex.com/images/products/sku/large/vervmdf.webp", 
                        "description" => "50 ml Eau De Parfum Spray" 
                    ], 
                    "id" => "1", 
                    "conditions" => [
                        ] 
                ] 
            ], 
            "livemode" => true, 
            "locale" => "en", 
            "merchant" => [
                "name" => "My new name business" 
            ], 
            "metadata" => [], 
            "mode" => "payment", 
            "payment_details" => null, 
            "payment_method_types" => [
                "card", 
                "gcash" 
            ], 
            "payment_status" => "unpaid", 
            "payment_url" => "https://pay.magpie.im/cs_h8CJFNBotp3iPhFd", 
            "phone_number_collection" => false, 
            "require_auth" => true, 
            "shipping" => null, 
            "shipping_address_collection" => null, 
            "submit_type" => "pay", 
            "success_url" => "http://localhost:8000/checkout/callback?success=1", 
            "updated" => 1674742974186 
       ]; 
        
        Http::fake([
            'https://pay.magpie.im/api/v2/sessions' => Http::response($body, 200)
        ]);

        $product = Product::factory()->create([
            'price' => 25.00
        ]);

        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [
                'image' => $product->image,
                'description' => $product->description
            ]
        ]);

        \Cart::add([
            'id' => 1,
            'name' => 'Versace Eros',
            'price' => 2500,
            'quantity' => 1,
            'attributes' => [
                'image' => 'https://img.fragrancex.com/images/products/sku/large/vervmdf.webp',
                'description' => '50 ml Eau De Parfum Spray'
            ]
        ]);

        $response = $this->post('checkout');

        $response->assertRedirect('https://pay.magpie.im/cs_h8CJFNBotp3iPhFd');
    }

    /**
     * Test failed checkout
     */
    public function test_checkout_failed()
    {
        Http::fake([
            'https://pay.magpie.im/api/v2/sessions' => Http::response([], 404)
        ]);

        $response = $this->post('checkout');

        $response->assertRedirect('cart');
    }

    /**
     * Test success checkout callback
     */
    public function test_checkout_callback_success()
    {
        $product = Product::factory()->create([
            'price' => 1234
        ]);

        $user = User::factory()->create([
            'role' => 'customer'
        ]);

        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [
                'image' => $product->image,
                'description' => $product->description
            ]
        ]);

        $response = $this->actingAs($user)
            ->get('/checkout/callback?success=1');

        $response->assertStatus(200);
        $response->assertViewIs('checkout');
        $response->assertSee('Checkout success. See summary below.');
    }

    /**
     * Test failed checkout callback
     */
    public function test_checkout_callback_failed()
    {
        $user = User::factory()->create([
            'role' => 'customer'
        ]);
        
        $response = $this->actingAs($user)
            ->get('/checkout/callback?success=0');

        $response->assertStatus(200);
        $response->assertViewIs('checkout');
        $response->assertSee('Your checkout is not successful.');
    }
}
