<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_cart_page_render()
    {
        $response = $this->get('/cart');

        $response->assertViewIs('cart.index');
        $response->assertViewHasAll(['items', 'total']);
        $response->assertStatus(200);
    }

    public function test_add_to_cart()
    {
        $product = Product::factory()->create();
       
        $response = $this->post('/cart', $product->toArray());

        $response->assertRedirect('cart');

        $this->assertCount(1, \Cart::getContent());
        $this->assertArrayHasKey($product->id, \Cart::getContent()->toArray());
    }

    public function test_remove_to_cart()
    {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        \Cart::add([
            [
                'id' => $product1->id,
                'name' => $product1->name,
                'price' => floatval($product1->price),
                'quantity' => 1,
                'attributes' => [
                    'image' => $product1->image,
                    'description' => $product1->description
                ]
            ],
            [
                'id' => $product2->id,
                'name' => $product2->name,
                'price' => floatval($product2->price),
                'quantity' => 1,
                'attributes' => [
                    'image' => $product2->image,
                    'description' => $product2->description
                ]
            ]
        ]);
        
        $this->assertCount(2, \Cart::getContent());

        $response = $this->post('/cart/remove', [
            'id' => $product2->id
        ]);

        $response->assertRedirect('cart');

        $this->assertCount(1, \Cart::getContent());
        $this->assertArrayHasKey($product1->id, \Cart::getContent()->toArray());
        $this->assertArrayNotHasKey($product2->id, \Cart::getContent()->toArray());
    }

    public function test_clear_cart()
    {
        $product = Product::factory()->create();

        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => floatval($product->price),
            'quantity' => 1,
            'attributes' => [
                'image' => $product->image,
                'description' => $product->description
            ]
        ]);
        
        $response = $this->get('/cart/clear');

        $response->assertRedirect('cart');

        $this->assertCount(0, \Cart::getContent());
    }
}
