<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test the formatted price of a product
     *
     * @return void
     */
    public function test_price_format_is_correct()
    {
        $product = Product::factory()->make([
            'price' => 1234
        ]);

        $this->assertEquals($product->getPriceFormat(), '1,234.00');
    }
}
