<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Search products
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sort products
        $sort = $request->get('sort', 'latest');
        switch($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(10);
        
        // Get unique categories for filter
        $categories = Product::distinct()->pluck('category');
        
        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
                'categories' => $categories
            ]);
        }
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
            'is_active' => 'boolean'
        ]);
        
        // Set default values
        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;
        
        $product = Product::create($validated);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product,
                'hashid' => $product->hashid
            ], 201);
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Get related products (same category)
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
            'is_active' => 'boolean'
        ]);
        
        $product->update($validated);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'product' => $product,
                'hashid' => $product->hashid
            ]);
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
    
    /**
     * Bulk delete products
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'hashids' => 'required|array',
            'hashids.*' => 'string'
        ]);
        
        $deletedCount = 0;
        foreach ($request->hashids as $hashid) {
            $product = Product::findByHashid($hashid);
            if ($product) {
                $product->delete();
                $deletedCount++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} products deleted successfully"
        ]);
    }
    
    /**
     * Export products to CSV
     */
    public function export()
    {
        $products = Product::all();
        
        $filename = "products_export_" . date('Y-m-d_H-i-s') . ".csv";
        $handle = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($handle, ['Hash ID', 'Name', 'Description', 'Price', 'Stock', 'Category', 'Status', 'Created At']);
        
        // Add data rows
        foreach ($products as $product) {
            fputcsv($handle, [
                $product->hashid,
                $product->name,
                $product->description,
                $product->price,
                $product->stock,
                $product->category,
                $product->is_active ? 'Active' : 'Inactive',
                $product->created_at->format('Y-m-d H:i:s')
            ]);
        }
        
        fclose($handle);
        
        return response()->stream(
            function() use ($filename) {
                // Stream the CSV content
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}