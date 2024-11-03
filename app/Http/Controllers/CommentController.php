<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Logging\CustomFile;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Throwable;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreCommentRequest $request)
    {
        try{
            
            $validated = $request->validated();

            Comment::create([
                'user_id' => auth()->user()->id,
                'recipe_id' => $request->id,
                'comment' => $validated['comment'] 
            ]);

            return back();
            // return back()->with('commentStatus', 201);

        }catch(Throwable $e){
            // Call in controller
            CustomFile::index('CommentController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);
            
            return back();
            // return back()->withInput()->with('commentStatus', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        try{
            $validated = $request->validated();
            
            $comment = Comment::find($request->id);
            
            $comment->update([
                'comment' => $validated['comment']
            ]);
            
            return back();
            // return back()->with('commentStatus', 200);

        }catch(Throwable $e){
            CustomFile::index('CommentController', 'error' ,[
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]
            ]);
            return back();
            // return back()->withInput()->with('commentStatus', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment, $id)
    {
        try{
            $comment = Comment::find($id);

            $comment->delete();

            return back();

        }catch(Throwable $e){
            CustomFile::index('CommentController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]
            ]);

            return back();
        }
    }

    /**
     * Get comments
     */

    public function get_comments_by_user_id($id)
    {
        $comments = Recipe::find($id)->comments()->latest()->paginate(5);

        foreach($comments as $key => $comment){
            $comments[$key]->profile_thumbnail = Profile::find(['user_id', $comment->user_id])[0]->image;
            $comments[$key]->profile_name = User::select('name')->where('id', $comment->user_id)->get()[0]->name;
        }

        return $comments;
    }
}
