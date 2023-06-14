<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // join comment and reply
        $comments = Comment::with('replies')->get();
        return response()->json([
            'message' => 'Successfully retrieved comments!',
            'comments' => [$comments]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
            'comment_text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'status' => '422',
            ]);
        }

        $comment = new Comment();
        $comment->comment_text = $request->comment_text;
        $comment->user_id = $request->user_id;
        $comment->product_id = $request->product_id;
        $comment->prediksi = $request->prediksi;
        $comment->save();

        return response()->json([
            'message' => 'Successfully created comment!',
            'comment' => $comment
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $comment = Comment::find($id);
        if ($comment) {
            return response()->json([
                'message' => 'Successfully retrieved comment!',
                'comment' => [$comment]
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comment not found!',
                'status' => "404",
            ]);
        }
    }

    public function showProduct(string $id)
    {
        //join comment and product search with product_id
        $comment = Comment::join('products', 'comments.product_id', '=', 'products.id')->join('users', 'comments.user_id', '=', 'users.id')
            ->where('products.id', '=', $id)
            ->select('comments.*', 'users.name')->get();
        if ($comment) {
            return response()->json([
                'message' => 'Successfully retrieved comment!',
                'comment' => $comment
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comment not found!',
                'status' => "404",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'comment_text' => 'required',
            'comment_date' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = Comment::find($id);
        if ($comment) {
            $comment->comment_text = $request->comment_text;
            $comment->comment_date = $request->comment_date;
            $comment->user_id = $request->user_id;
            $comment->product_id = $request->product_id;
            $comment->prediksi = $request->prediksi;
            $comment->save();

            return response()->json([
                'message' => 'Successfully updated comment!',
                'comment' => $comment
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comment not found!',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return response()->json([
                'message' => 'Successfully deleted comment!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comment not found!',
            ], 404);
        }
    }
}
