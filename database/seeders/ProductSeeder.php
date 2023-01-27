<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::withoutForeignKeyConstraints(function () {
            Product::truncate();
        });
        
        Product::insert([
            [
                'name' => 'Versace Eros',
                'price' => 3185.53,
                'description' => '50 ml Eau De Parfum Spray',
                'image' => 'https://img.fragrancex.com/images/products/sku/large/vervmdf.webp'
            ], 
            [
                'name' => 'Cool Water Cologne',
                'price' => 1698.95,
                'description' => '200 ml Eau De Toilette Spray',
                'image' => 'https://img.fragrancex.com/images/products/sku/large/cwmt67.webp'
            ], 
            [
                'name' => 'Eternity Cologne',
                'price' => 1592.53,
                'description' => '100 ml Eau De Toilette Spray',
                'image' => 'https://img.fragrancex.com/images/products/sku/large/emt34tt.webp'
            ], 
            [
                'name' => 'Versace Man Cologne',
                'price' => 2407,
                'description' => '100 ml Eau Fraiche Eau De Toilette Spray (Blue)',
                'image' => 'https://img.fragrancex.com/images/products/sku/large/vefm34.webp'
            ]
        ]);
    }
}
