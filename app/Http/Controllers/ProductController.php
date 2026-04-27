<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ProductController extends Controller
{
    // LIST
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            $product->hashid = Hashids::encode($product->id);
            return $product;
        });

        return view('products.index', compact('products'));
    }

    // CREATE FORM
    public function create()
    {
        return view('products.create');
    }

    // STORE
    public function store(Request $request)
    {
        Product::create($request->only('name', 'price'));

        return redirect('/products');
    }

    // SHOW (HASHID URL)
    public function show($hash)
    {
        $id = Hashids::decode($hash)[0] ?? null;

        if (!$id) {
            abort(404);
        }

        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }
}