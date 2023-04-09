<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Reply::all();
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
            'comment_id' => 'required',
            'user_id' => 'required',
            'reply_text' => 'required',
            'reply_date' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $reply = Reply::find($id);
        if ($reply) {
            return response()->json([
                'message' => 'Successfully retrieved reply!',
                'reply' => $reply
            ], 200);
        } else {
            return response()->json([
                'message' => 'Reply not found!',
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
        $reply = Reply::find($id);
        if ($reply) {
            $validator = Validator::make($request->all(), [
                'comment_id' => 'required',
                'reply_text' => 'required',
                'reply_date' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $reply->comment_id = $request->comment_id;
            $reply->reply_text = $request->reply_text;
            $reply->reply_date = $request->reply_date;
            $reply->user_id = $request->user_id;
            $reply->save();

            return response()->json([
                'message' => 'Successfully updated reply!',
                'reply' => $reply
            ], 200);
        } else {
            return response()->json([
                'message' => 'Reply not found!',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $reply = Reply::find($id);
        if ($reply) {
            $reply->delete();
            return response()->json([
                'message' => 'Successfully deleted reply!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Reply not found!',
            ], 404);
        }
    }
}
