<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\LicensePlansCurrencies;


class PayPalService
{
    private $client;
    private $accessToken;

    public function __construct()
    {
        // if (!config('services.paypal.enabled')) {
        //     throw new \Exception('PayPal is disabled in the configuration.');
        // }

        $this->client = new Client([
            'base_uri' => config('services.paypal.base_url', 'https://api-m.sandbox.paypal.com'),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->authenticate();
    }

    /**
     * Authenticate and retrieve an access token.
     */
    private function authenticate()
    {
        try{
            $response = $this->client->post('/v1/oauth2/token', [
                'auth' => ['AUv8rrc_P-EbP2E0mpb49BV7rFt3Usr-vdUZO8VGOnjRehGHBXkSzchr37SYF2GNdQFYSp72jh5QUhzG', 'EMnAWe06ioGtouJs7gLYT9chK9-2jJ--7MKRXpI8FesmY_2Kp-d_7aCqff7M9moEJBvuXoBO4clKtY0v'],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $this->accessToken = $data['access_token'];
            if (!$this->accessToken) {
                throw new \Exception('Failed to retrieve PayPal access token.');
            }
        } catch (\Exception $e) {
            Log::error('PayPal authentication failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    private function getHeaders(array $additionalHeaders = []): array{
        return array_merge([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ], $additionalHeaders);
    }

    // create order and capture using paypal valuted id 
    public function makePayment($amount,$token , $currency_code,$description = ""){

        try {

            $amount = ceil($amount);
            $paymentData = [
                "intent" => "CAPTURE",
                "payment_source" => [
                    "paypal" => [
                        "vault_id" => $token,
                    ]
                ],
                "purchase_units" => [
                    [
                        //"reference_id" => "quixxs_orderid_PU12345",
                        "amount" => [
                           "currency_code" => "$currency_code",
                           "value" => "$amount"
                        ],
                        "description" => "$description",
                    ]
                ]
            ];
            
            $response = $this->client->post('/v2/checkout/orders', [
                'headers' => $this->getHeaders(['PayPal-Request-Id' => 'A v4 style guid']),
                'json' => $paymentData,
            ]);
            $paymentIntent = json_decode($response->getBody(), true);
            $paymentIntent['client_secret'] = '';
            if ($paymentIntent['status'] === 'COMPLETED') {
                return $paymentIntent;
            }elseif ($paymentIntent['status'] === 'PAYER_ACTION_REQUIRED') {
                return 'Payment Requires 3DS confirmation to Proceed';
            }

        } catch (Exception $e) {
            app('log')->error('Exception : ' . $e->getMessage() , [
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
            ]);
        }
    }

    /**
     * Create a new PayPal order and authorize payment method tokens to store in valut .
     */
    public function createPaymentIntent($amount)
    {
      
        try {
            $paymentData = [
                "intent" => "CAPTURE",
                "payment_source" => [
                    "paypal" => [
                        "attributes" => [
                            "vault" => [
                                "store_in_vault" => "ON_SUCCESS",
                                "usage_type" => "MERCHANT"
                            ]
                        ],
                        "experience_context" => [
                            "return_url" => url('/paypal-redirect'),
                            "cancel_url" => url('/payment-failed'),
                            "shipping_preference" => "NO_SHIPPING"
                        ]
                    ]
                ],
                "purchase_units" => [
                    [
                        //"reference_id" => "quixxs_orderid_PU12345",
                        "amount" => [
                           "currency_code" => "GBP",
													 // is_string($licensePlanCurrency) ? LicensePlansCurrencies::where('country_numeric_code' , $customer->country)->first()->currency_code : $licensePlanCurrency->currency_code,
                           "value" => "$amount"
                        ],
                        "description" => "Test Description", //is_string($licensePlanCurrency) ? $licensePlanCurrency : $licensePlanCurrency->plan->plan_description
                    ]
                ]
            ];
          
            $response = $this->client->post('/v2/checkout/orders', [
                'headers' => $this->getHeaders(),
                'json' => $paymentData,
            ]);
            $paymentIntent = json_decode($response->getBody(), true);
            $paymentIntent = (object) $paymentIntent;
            //$paymentIntent =  json_decode($response->getBody(), true);
            return [
                'id' => $paymentIntent->id,
                'status' => $paymentIntent->status,
                'approve_url' => $paymentIntent->links[0]['href'],
                'clientSecret' => '',
                'paypal_response' => $paymentIntent,
            ];
        }catch (Exception $exception) {
            $message = $exception->getMessage();
        }
        return [
            'status' => 'error',
            'message' => $message,
        ];
    }

        /**
     * Retrieve order details.
     */
    public function retrievePaymentIntent($paymentIntent)
    {
        try {
            $response = $this->client->get("/v2/checkout/orders/{$paymentIntent}", [
                'headers' => $this->getHeaders(),
            ]);
            $paymentIntent =  json_decode($response->getBody(), true);
            $paymentIntent = (object) $paymentIntent;
            return $paymentIntent;

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
		/**
     * Capture a payment.
     */
		public function capturePayment($orderId)
    {
        try{
            $response = $this->client->post("/v2/checkout/orders/{$orderId}/capture", [
                'headers' => $this->getHeaders(),
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Authorize a payment.
     */
    public function authorizePayment($orderId)
    {
        try{
            $response = $this->client->post("/v2/checkout/orders/{$orderId}/authorize", [
                'headers' => $this->getHeaders(),
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Capture an authorized payment.
     */
    public function captureAuthorizedPayment($authorizationId, array $payment_data)
    {
        try{  
            $invoiceData = [
                "amount"=> [
                    "value"=> $payment_data['amount'],
                    "currency_code"=> $payment_data['currency']
                ],
                "invoice_id"=> $payment_data['invoice_id'],
                "final_capture"=> true,
                "note_to_payer"=> "",
                "soft_descriptor"=> "",
            ];
            $response = $this->client->post("/v2/payments/authorizations/{$authorizationId}/capture", [
                'headers' => $this->getHeaders(),
                'json' => $invoiceData,
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Refund a captured payment.
     */
    public function refundPayment($captureId)
    {
        try {
            $response = $this->client->post("/v2/payments/captures/{$captureId}/refund", [
                'headers' => $this->getHeaders(),
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
		// setup token for card payment
		public function setupToken(){
			$cardData = '{
    "payment_source": {
        "card": {
            "number": "{{card_number}}",
            "expiry": "2027-02",
            "name": "John Doe",
            "billing_address": {
                "address_line_1": "2211 N First Street",
                "address_line_2": "17.3.160",
                "admin_area_1": "CA",
                "admin_area_2": "San Jose",
                "postal_code": "95131",
                "country_code": "US"
            }
        }
    }
}';
			try {
				$response = $this->client->post('/v1/identity/generate-token', [
					'headers' => $this->getHeaders(),
					'json' => $cardData,
				]);
				$token = json_decode($response->getBody(), true);
				return $token;
			} catch (Exception $e) {
				dd($e->getMessage());
			}
		}
		// create order and capture using paypal valuted id

}