<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        Stripe::setApiKey('sk_test_51O3uv9JgFMnQBUHD43hs3xQWFmxdUIf0QPlGiTFbMCDA92mChQw9QxR6bNkvKoZ8jXCnZBISINextlIbXRfN6RnT009Rgb3gj7');

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Total Price',
                        ],
                        'unit_amount' => $request->value * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe_success'),
            'cancel_url' => route('stripe_cancel'),
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function success()
    {
        return "Payment is successful!";
    }

    public function cancel()
    {
        return "Payment is cancelled!";
    }
}

