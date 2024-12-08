<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function pushToShopify($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        if (!$user->shopify_store_id) {
            return redirect()->back()->with('error', 'Shopify store ID not found.');
        }
        // Define the API endpoint and headers
        $url = "https://{$user->shopify_store_id}/admin/api/2023-07/products.json";

        $headers = [
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => $user->access_token,
        ];

        $body = [
            'product' => [
                'title' => $product->name,
                'body_html' => '<strong>' . $product->description . '</strong>',
                'vendor' => $product->vendor,
                'product_type' => 'Category',
                'images' => [
                    [
                        'src' => $product->image
                    ]
                ],
                'variants' => [
                    [
                        'option1' => 'Default Title',
                        'price' => $product->price,
                        'sku' => $product->sku,
                    ],
                ],
            ],
        ];
        // Send the POST request
        $response = Http::withHeaders($headers)->post($url, $body);
        return $response->body();
    }
}
