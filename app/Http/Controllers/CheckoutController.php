<?php

namespace App\Http\Controllers;

use App\Support\Bag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    public function index(Bag $bag): View|RedirectResponse
    {
        if ($bag->isEmpty()) {
            return redirect()->route('bag.index')->with('status', 'Your bag is empty — add something first.');
        }

        return view('checkout.index', [
            'lines' => $bag->lines(),
            'subtotal' => $bag->subtotal(),
            'deliveryAreas' => config('store.delivery.areas'),
        ]);
    }
}
