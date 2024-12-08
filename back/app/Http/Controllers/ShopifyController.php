<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShopifyController extends Controller
{
    // Step 1: Redirect to Shopify for OAuth
    public function redirectToShopify(Request $request)
    {
        $token = $request->query('token');
        $shop = $request->query('shop');

        if (!$token) {
            return response()->json(['error' => 'Token is required'], 400);
        }

        // Authenticate the token manually
        $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        if (!$user || !$user->tokenable) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Retrieve the authenticated user
        // $shop = 'dexter-clothes.myshopify.com/';  // Replace with dynamic shop domain

        if (!$shop) {
            return response()->json(['error' => 'Shop URL is required or incorrect'], 400);
        }

        $apiKey = env('SHOPIFY_API_KEY');
        $scopes = 'write_products';
        $redirectUri = route('shopify.callback');

        $shopifyRedirectUrl = "https://{$shop}/admin/oauth/authorize?" . http_build_query([
            'client_id' => $apiKey,
            'scope' => $scopes,
            'redirect_uri' => $redirectUri,
            'state' => $token
        ]);

        return redirect($shopifyRedirectUrl); // Perform the redirect to Shopify
    }


    // Step 2: Handle OAuth callback and store access token
    public function handleCallback(Request $request)
    {
        $token = $request->query('state');
        $code = $request->get('code');
        $shop = $request->get('shop');

        $response = Http::post("https://$shop/admin/oauth/access_token", [
            'client_id' => env('SHOPIFY_API_KEY'),
            'client_secret' => env('SHOPIFY_API_SECRET'),
            'code' => $code,
        ]);

        $accessToken = $response->json()['access_token'];

        $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        if (!$user || !$user->tokenable) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $user->tokenable->update(
            [
                'shopify_store_id' => $shop,
                'access_token' => $accessToken
            ]
        );

        return '<h2>Successfully Connected!</h2>
            <p>You are now connected to Shopify. You will be redirected to the products page. Close this window to continue.</p>';

        // return response()->json([
        //     'accessToken' => $accessToken
        // ]);
    }

}
