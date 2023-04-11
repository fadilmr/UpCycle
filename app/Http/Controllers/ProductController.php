<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_title' => 'required',
            'product_description' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation failed',
                    'error' => $validator->errors()
                ],
                422
            );
        }

        $product = new Product;
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;
        $product->user_id = $request->user_id;
        $product->save();
        return response()->json([
            'message' => 'Successfully created product!',
            'product' => $product
        ], 200);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_title' => 'required',
            'product_description' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation failed',
                    'error' => $validator->errors()
                ],
                422
            );
        }

        $product = Product::findOrFail($id);
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;
        $product->save();
        return response()->json([
            'message' => 'Successfully updated product!',
            'product' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
