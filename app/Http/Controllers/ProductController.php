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
                    'error' => $validator->errors(),
                    'status' => '422'
                ],
            );
        }

        if (!$request->has('product_image')) {
            return response()->json(['message' => 'Missing file']);
        }
        $file = $request->file('product_image');
        $file_name = time() . '.' . $file->extension();
        $file->move(public_path('images'), $file_name);

        $product = new Product;
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;
        $product->user_id = $request->user_id;
        $product->product_image = $file_name;
        $product->save();
        return response()->json([
            'message' => 'Successfully created product!',
            'product' => $product,
            'status' => '200'
        ], 200);
    }

    public function show($id)
    {
        // $product = Product::findOrFail($id);
        // table join product and user
        $product = Product::join('users', 'users.id', '=', 'products.user_id')
            ->select('products.*', 'users.name')
            ->where('products.id', '=', $id)
            ->first();
        return response()->json([
            'message' => 'Successfully retrieved product!',
            'product' => $product,
            'status' => '200'
        ]);
    }

    public function showUser($id)
    {
        // table join product and user
        $product = Product::join('users', 'users.id', '=', 'products.user_id')
            ->select('products.*', 'users.name')
            ->where('products.user_id', '=', $id)
            ->get();
        return response()->json([
            'message' => 'Successfully retrieved product!',
            'product' => $product,
            'status' => '200'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_title' => 'required',
            'product_description' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
            'product_image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation failed',
                    'error' => $validator->errors(),
                    'status' => '422'
                ],
            );
        }

        if (!$request->has('product_image')) {
            return response()->json(['message' => 'Missing file']);
        }
        $file = $request->file('product_image');
        $file_name = time() . '.' . $file->extension();
        $file->move(public_path('images'), $file_name);

        $product = Product::findOrFail($id);
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;
        $product->product_image = $file_name;
        $product->save();
        return response()->json([
            'message' => 'Successfully updated product!',
            'product' => $product,
            'status' => '200'
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => 'Product deleted',
            'status' => '200'
        ]);
    }
}
