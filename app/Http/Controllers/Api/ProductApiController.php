<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Vinkla\Hashids\Facades\Hashids;

class ProductApiController extends Controller
{
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            return [
                'id' => Hashids::encode($product->id),
                'name' => $product->name,
                'price' => $product->price,
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }
}