<?php 
namespace App\Traits;

trait MoneyFormat
{
    public function format($value)
    {
        return number_format($value, 2);
    }
}