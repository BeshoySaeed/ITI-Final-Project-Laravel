<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Redirect;



class PaymentController extends Controller
{
  

    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal_success'),
                "cancel_url" => route('paypal_cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->value
                    ]
                ]
            ]
        ]);

        //dd($response);

        if(isset($response['id']) && $response['id']!=null) {
            foreach($response['links'] as $link) {
                if($link['rel'] === 'approve') {
                    return response()->json(['success' => true,'link'=>$link['href']]);
                }
            }
        } else {
            return redirect()->route('paypal_cancel');
        }
    }
    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        //dd($response);

        if(isset($response['status']) && $response['status'] == 'COMPLETED') {

            $response=response()->json([
                'status' => 'success',
                'message' => 'Payment Success'
            ], 201);
            $redirectUrl = 'http://localhost:4200/cart?'.http_build_query($response);
            return redirect()->away($redirectUrl);


        } else {
            return redirect()->route('paypal_cancel');
        }
    }
    public function cancel()
    {
        $response=response()->json([
            'status' => 'failed',
            'message' => 'Payment Failed'
        ], 201);
        $redirectUrl = 'http://localhost:4200/home?'.http_build_query($response);
        return redirect()->away($redirectUrl);

    }

}