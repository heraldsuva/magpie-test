<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page_render()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('home');

        $response->assertViewHas('products');
    }

    
     /**
     * Test checkout page
     *
     * @return void
     */
    public function test_checkout()
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
}
