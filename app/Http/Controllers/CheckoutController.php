<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $lineItems = \Cart::getContent()->values()->map(function($item, $key){
            $item->put('amount',  (int) (floatval($item->price) * 100));
            $item->put('quantity', (int) $item->quantity);
            $item->put('description', $item->attributes->description);
            $item->put('image', $item->attributes->image);
            return $item;
        })->toArray();

        // $lineItems = [
        //     [
        //         "id" => "1",
        //         "name" => "Versace Eros",
        //         "quantity" => 1,
        //         "attributes" => [
        //             "image" => "https://img.fragrancex.com/images/products/sku/large/vervmdf.webp",
        //             "description" => "50 ml Eau De Parfum Spray"
        //         ],
        //         "conditions" => [],
        //         "amount" => 2500,
        //         "description" => "50 ml Eau De Parfum Spray",
        //         "image" => "https://img.fragrancex.com/images/products/sku/large/vervmdf.webp",
        //     ]
        // ];

        $payload = [
            "billing_address_collection" => true,
            "success_url" => route('checkout.callback', ['success' => true]),
            "cancel_url" => route('checkout.callback', ['success' => false]),
            "currency" => "php",
            "customer_email" => 'herald_suva@yahoo.com',
            "line_items" => $lineItems,
            "locale" => "en",
            "metadata" => (object)[],
            "payment_method_types" => [
                "card",
                'gcash'
            ],
            "submit_type" => "pay"
        ];

        $secret_key = env('MAGPIE_API_SK') . ':';
        $http = Http::withToken('Basic ' . base64_encode($secret_key), null)
            ->post('https://pay.magpie.im/api/v2/sessions', $payload);
        

        if ($http->failed()) {
            return redirect()
                ->route('cart.index')
                ->with('status', 'Error occur while requesting magpie session.');
        }

        $magpie = $http->object();

        return redirect($magpie->payment_url);
    }

    public function callback(Request $request)
    {
        $success = $request->query('success');
        $items = [];
        $total = 0;

        if ($success) {
            $items = \Cart::getContent();
            $total = \Cart::getTotal();

            // $userId = 1;
            $userId = \Auth::id();

            $invoice = Invoice::create([
                'user_id' => $userId,
                'amount' => $total
            ]);

            foreach ($items as $id => $item) {
                $order = Order::create([
                    'user_id' => $userId,
                    'product_id' => $id,
                    'invoice_id' => $invoice->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);
            }

            \Cart::clear();
        }

        return view('checkout')
            ->with(compact('success', 'items', 'total'));
    }
}
