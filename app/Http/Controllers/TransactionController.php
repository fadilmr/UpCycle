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

    public function store(Request $request)
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

        $transaction = Transaction::create($request->only(['product_id', 'user_id', 'status']));

        return response()->json([
            'message' => 'Successfully created transaction!',
            'transaction' => $transaction
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
