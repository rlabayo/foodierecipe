<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Libraries\CommonLibrary;
use App\Logging\CustomFile;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Throwable;

class CommentController extends Controller
{
    public $common_library;

    public function __construct()
    {
        $this->common_library = new CommonLibrary();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
            DB::beginTransaction();

                $validated = $request->validated();

                Comment::create([
                    'user_id' => auth()->user()->id,
                    'recipe_id' => Crypt::decrypt($validated['recipe_id']),
                    'comment' => $validated['comment'] 
                ]);
            
            DB::commit();

            return back()->with([
                'statusCode' => 201,
                'message' => 'Comment was created successfully.'
            ]);

        }catch(Throwable $e){
            DB::rollBack();

            // Call in controller
            CustomFile::index('CommentController', 'error', [ 
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);
            
            return back()->withInput()->with([
                'errorStatusCode' => $e->getCode(),
                'message' => 'An error occurred while creating your comment. Please try again.'
            ]);
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
            DB::beginTransaction();
                $validated = $request->validated();
                $decrypted_id = Crypt::decrypt($validated['recipe_id']);
                
                $comment = Comment::find($decrypted_id);
                
                $comment->update([
                    'comment' => $validated['comment']
                ]);
            
            DB::commit();

            return back()->with([
                'statusCode' => 200,
                'message' => 'Comment was updated successfully'
            ]);

        }catch(Throwable $e){
            DB::rollBack();

            CustomFile::index('CommentController', 'error' ,[ 
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);

            return back()->withInput()->with([
                'errorStatusCode' => $e->getCode(),
                'message' => 'An error occurred while updating your comment. Please try again.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment, $id)
    {
        try{
            DB::beginTransaction();
                $comment = Comment::find(Crypt::decrypt($id));

                $comment->delete();
            DB::commit();

            return back()->with([
                'statusCode' => 200,
                'message' => 'Comment was successfully deleted.'
            ]);

        }catch(Throwable $e){
            DB::rollBack();

            CustomFile::index('CommentController', 'error', [ 
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);

            return back()->with([
                'errorStatusCode' => $e->getMessage(),
                'message' => 'Error encountered while deleting a comment. Please try again.'
            ]);
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
