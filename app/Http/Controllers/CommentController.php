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
        //
        $comments = Comment::with('reply')->get();
        foreach ($comments as $comment) {
            $commentData = [
                'comment_text' => $comment->comment_text,
                'comment_date' => $comment->comment_date,
                'user_id' => $comment->user_id,
                'reply' => []
            ];
            foreach ($comment->reply as $reply) {
                $commentData['reply'][] = [
                    'reply_text' => $reply->reply_text,
                    'reply_date' => $reply->reply_date,
                    'user_id' => $reply->user_id,
                ];
            }
        }
        return response()->json([
            'message' => 'Successfully retrieved comments!',
            'comments' => $commentData
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
            'post_id' => 'required',
            'comment_text' => 'required',
            'comment_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = new Comment();
        $comment->comment_text = $request->comment_text;
        $comment->comment_date = $request->comment_date;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
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
                'comment' => $comment
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comment not found!',
            ], 404);
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
            'post_id' => 'required',
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
            $comment->post_id = $request->post_id;
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
