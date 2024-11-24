<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Get all products with pagination
        $products = Product::latest()->paginate(10);

        // Return paginated products as JSON
        return response()->json([
            'data' => $products,
            'links' => [
                'self' => $products->url(1),
                'next' => $products->nextPageUrl(),
                'prev' => $products->previousPageUrl(),
            ],
            'meta' => [
                'current_page' => $products->currentPage(),
                'total_pages' => $products->lastPage(),
                'total_items' => $products->total(),
            ]
        ]);
    }

    /**
     * Store a newly created product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validate request data
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        // Store image
        $image = $request->file('image');
        $imagePath = $image->storeAs('public/products', $image->hashName());

        // Create product
        $product = Product::create([
            'image' => $image->hashName(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        // Return created product as JSON
        return response()->json([
            'message' => 'Product created successfully.',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified product.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        // Find product by ID
        $product = Product::findOrFail($id);

        // Return product data as JSON
        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Update the specified product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        // Validate request data
        $validated = $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        // Find product by ID
        $product = Product::findOrFail($id);

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            // Delete old image from storage
            Storage::delete('public/products/' . $product->image);

            // Store new image
            $image = $request->file('image');
            $imagePath = $image->storeAs('public/products', $image->hashName());

            // Update product data
            $product->update([
                'image' => $image->hashName(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
            ]);
        } else {
            // Update product without image
            $product->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
            ]);
        }

        // Return updated product as JSON
        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified product.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        // Find product by ID
        $product = Product::findOrFail($id);

        // Delete image from storage
        Storage::delete('public/products/' . $product->image);

        // Delete product
        $product->delete();

        // Return success message
        return response()->json([
            'message' => 'Product deleted successfully.'
        ]);
    }
}
