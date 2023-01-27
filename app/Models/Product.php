<?php

namespace App\Models;

use App\Traits\MoneyFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, MoneyFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock'
    ];

    public static $rules = [
        'name' => 'required',
        'price' => 'required',
        'description' => 'required',
        'stock' => 'required'
    ];

    /**
     * Get the orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getPriceFormat()
    {
        return number_format($this->price, 2);
    }
}
