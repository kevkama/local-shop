<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
use AuthorizesRequests;

    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Store a newly created product.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Create the product
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'user_id' => $user->id,
        ]);

        return response()->json($product, 201);
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified product.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Authorization check for the current user
        $this->authorize('update', $product);

        // Update the product
        $product->update($request->validated());

        return response()->json($product);
    }

    /**
     * Remove the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        // Authorization check for the current user
        $this->authorize('delete', $product);

        // Delete the product
        $product->delete();

        return response()->json(null, 204);
    }

    /**
     * Search for products by name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $name = $request->query('name');  // Get the 'name' query parameter

        // Search products by name (case-insensitive)
        $products = Product::where('name', 'like', '%' . $name . '%')->get();

        return response()->json($products);
    }
}
