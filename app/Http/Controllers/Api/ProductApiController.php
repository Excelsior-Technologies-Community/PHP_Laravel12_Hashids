<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ProductApiController extends Controller
{
    /**
     * Get all products (API)
     */
    public function index()
    {
        $products = Product::all()->map(function($product) {
            return [
                'hashid' => $product->hashid,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'formatted_price' => $product->formatted_price,
                'category' => $product->category,
                'stock' => $product->stock
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $products,
            'total' => $products->count()
        ]);
    }
    
    /**
     * Get single product (API)
     */
    public function show($hashid)
    {
        $product = Product::findByHashid($hashid);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'hashid' => $product->hashid,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'formatted_price' => $product->formatted_price,
                'category' => $product->category,
                'stock' => $product->stock,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at
            ]
        ]);
    }
    
    /**
     * Batch decode multiple hashids
     */
    public function batchDecode(Request $request)
    {
        $request->validate([
            'hashids' => 'required|array',
            'hashids.*' => 'string'
        ]);
        
        $decoded = [];
        foreach ($request->hashids as $hashid) {
            $product = Product::findByHashid($hashid);
            if ($product) {
                $decoded[] = [
                    'hashid' => $hashid,
                    'id' => $product->id,
                    'name' => $product->name
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'decoded' => $decoded
        ]);
    }
}