<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use Exception;
use Illuminate\Support\Facades\Log;

class StripeConnectController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        // Initialize the Stripe client with your secret key
        $this->stripe = new StripeClient([
            'api_key' => env('STRIPE_SECRET_KEY'),
        ]);
    }

    /**
     * Create an account link for Stripe Connect onboarding.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Create a new Stripe account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAccount()
    {
        try {
            // Create a new Stripe account
            $account = $this->stripe->accounts->create();

            // Return the account ID as a JSON response
            return response()->json([
                'account' => $account->id,
            ]);
        } catch (Exception $e) {
            // Log the error and return a 500 response
            Log::error("An error occurred when calling the Stripe API to create an account: {$e->getMessage()}");

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create an account link for Stripe Connect onboarding.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAccountLink(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'account' => 'required|string', // Ensure 'account' is present and is a string
            ]);

            // Get the connected account ID from the request
            $connectedAccountId = $request->input('account');

            // Create the account link
            $accountLink = $this->stripe->accountLinks->create([
                'account' => $connectedAccountId,
                'return_url' => route('stripe.return', ['account' => $connectedAccountId]), // Use Laravel's route helper
                'refresh_url' => route('stripe.refresh', ['account' => $connectedAccountId]), // Use Laravel's route helper
                'type' => 'account_onboarding',
            ]);

            // Return the account link URL as a JSON response
            return response()->json([
                'url' => $accountLink->url,
            ]);
        } catch (Exception $e) {
            // Log the error
            Log::error("An error occurred when calling the Stripe API to create an account link: {$e->getMessage()}");

            // Return a 500 error with the error message
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
