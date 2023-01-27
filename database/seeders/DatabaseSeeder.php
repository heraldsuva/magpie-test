<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::withoutForeignKeyConstraints(function () {
            User::truncate();
            Product::truncate();
            Order::truncate();
            Invoice::truncate();
        });
        
        $this->call([
            AdminSeeder::class,
            ProductSeeder::class
        ]);
    }
}
