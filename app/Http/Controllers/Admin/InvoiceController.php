<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['user'])
            ->latest()
            ->get();

        return view('admin.invoices.index')
            ->with(compact('invoices'));
    }
}
