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

        return response()->json(['success'=>true,'url' => $session->url]);
    }

    public function success()
    {
        $response=response()->json([
            'status' => 'success',
            'message' => 'Payment Success'
        ], 201);
        $redirectUrl = 'http://localhost:4200/cart?'.http_build_query($response);
        return redirect()->away($redirectUrl);
    }

    public function cancel()
    {
        $response=response()->json([
            'status' => 'failed',
            'message' => 'Payment Failed'
        ], 201);
        $redirectUrl = 'http://localhost:4200/home?'.http_build_query($response);
        return Redirect::away($redirectUrl);
    }
}

