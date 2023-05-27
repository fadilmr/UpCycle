<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function showUser($id)
    {
        // $transaction = Transaction::findOrFail($id);
        // transaction join table user
        $transaction = Transaction::join('users', 'users.id', '=', 'transaction.user_id')->join('products', 'products.id', '=', 'transaction.product_id')
            ->select('transaction.*', 'users.name', 'products.*')
            ->where('users.id', '=', $id)
            ->get();
        return response()->json([$transaction]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'image' => 'required'
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

        if (!$request->has('image')) {
            return response()->json(['message' => 'Missing file']);
        }
        $file = $request->file('image');
        $file_name = time() . '.' . $file->extension();
        $file->move(public_path('images'), $file_name);

        $transaction = new Transaction;
        $transaction->status = "pending";
        $transaction->product_id = $request->product_id;
        $transaction->user_id = $request->user_id;
        $transaction->image = $file_name;
        $transaction->save();
        return response()->json([
            'message' => 'Successfully created transaction!',
            'transaction' => $transaction,
            'status' => '200'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|boolean'
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
        $transaction = Transaction::findOrFail($id);

        $transaction->update($request->only(['product_id', 'user_id', 'status']));

        return response()->json([
            'message' => 'Successfully updated transaction!',
            'transaction' => $transaction
        ], 200);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        return response()->json([
            'message' => 'Successfully deleted transaction!',
            'transaction' => $transaction
        ], 200);
    }
}
