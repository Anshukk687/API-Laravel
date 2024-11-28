<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function allProduct (Request $request)
    {
        $product = Product::all();
        return $product;
    }

    public function addProduct (Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $filePath = $request->file('file_path')->store('products', 'public');
        $product->file_path = $filePath;
        $product->save();

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    public function editProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return response()->json($product);
    }

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::find($id);
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('products', 'public');
            $product->file_path = $filePath;
        }
        $product->save();

        return response()->json($product, 200);
    }

    public function searchProduct(Request $request)
    {
        $query = $request->input('search');
        
        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->get();

        return response()->json($products, 200);
    }

}