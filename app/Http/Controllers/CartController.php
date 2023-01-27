<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = \Cart::getContent();

        $total = \Cart::getTotal();

        return view('cart.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        \Cart::add([
                'id' => $request->id,
                'name' => $request->name,
                'price' => floatval($request->price),
                'quantity' => 1,
                'attributes' => [
                    'image' => $request->image,
                    'description' => $request->description
                ]
            ]);

        session()->flash('success', 'An item was added to your cart.');

        return redirect()->route('cart.index');
    }

    public function update(Request $request)
    {
        try {
            \Cart::update($request->id, [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 400);
        }

        return response()->json([
            'total' => \Cart::getTotal() / 100,
            'message' => 'An item was updated from your cart.'
        ], 200);
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);

        session()->flash('success', 'An item was removed from your cart.');

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        \Cart::clear();

        session()->flash('success', 'All items from your card has been removed.');

        return redirect()->route('cart.index');
    }
}
