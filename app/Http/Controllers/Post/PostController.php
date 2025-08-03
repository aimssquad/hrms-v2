<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use App\Models\Post\PostComment;
use App\Models\User;
use App\Models\Post\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2000',
            'post_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,mp4,mov,avi|max:10480' // 10MB max
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get authenticated user
        $email = Session::get('emp_email');
        $userData = User::where('email', $email)
                      ->where('status', 'active')
                      ->firstOrFail();
        
        try {
            $filePath = null;
            $fileType = null;
            
            // Handle file upload
            if ($request->hasFile('post_file')) {
                $file = $request->file('post_file');
                $filePath = $file->store('employee-post', 'public');
            }
            //dd($filePath);
            // Create post
            $post = Post::create([
                'emid' => $userData->emid,
                'employee_code' => $userData->employee_id,
                'title' => $request->content,
                'image_path'=> $filePath,
            ]);

            if ($post) {
                Session::flash('success', 'Post created successfully.');
                return back();
            }

            Session::flash('error', 'Failed to create post.');
            return back();
            
        } catch (\Exception $e) {
            Session::flash('error', 'Error: ' . $e->getMessage());
            return back();
        }
    }

    public function storeComment(Request $request)
    {
        //dd('okk');

        $request->validate([
            'post_id' => 'required|exists:post,id',
            'comment_text' => 'required|string|max:1000',
        ]);
        
        $email = Session::get('emp_email');
        $userData = User::where('email', $email)
                      ->where('status', 'active')
                      ->firstOrFail();
        
        $comment = PostComment::create([
            'post_id' => $request->post_id,
            'emid' => $userData->emid, // Assuming this matches your user table
            'employee_code' => $userData->employee_id,
            'comment_text' => $request->comment_text
        ]);
        
        // return response()->json([
        //     'success' => true,
        //     'comment' => $comment
        //     'commenter' => [
        //         'employee_name' => $user->employee_name,
        //         'employee_image' => $user->employee_image,
        //         'designation' => $user->designation
        //     ]
        // ]);

           // Get commenter details from employee table
        $commenter = DB::table('employee')
            ->where('emid', $userData->emid)
            ->where('emp_code', $userData->employee_id)
            ->where('status', 'active')
            ->select(
                DB::raw("CONCAT(emp_fname, ' ', emp_lname) as employee_name"),
                'emp_image as employee_image',
                'emp_designation as designation'
            )
            ->first();
        //dd($commenter);        
        return response()->json([
            'success' => true,
            'comment' => $comment,
            'commenter' => [
                'employee_name' => $commenter->employee_name ?? 'Unknown',
                'employee_image' => $commenter->employee_image 
                    ? asset("storage/app/public/".$commenter->employee_image) 
                    : asset('default_avatar.jpg'),
                'designation' => $commenter->designation ?? ''
            ]
        ]);


    }


    public function toggleLike(Request $request, $postId)
    {
        // Get authenticated user
        $email = Session::get('emp_email');
        $user = User::where('email', $email)
                  ->where('status', 'active')
                  ->firstOrFail();

        try {
            // Check if like already exists
            $existingLike = PostLike::where('post_id', $postId)
                                  ->where('emid', $user->emid)
                                  ->where('employee_code', $user->employee_id)
                                  ->first();

            if ($existingLike) {
                // Unlike the post
                $existingLike->delete();
                $action = 'unliked';
            } else {
                // Like the post
                PostLike::create([
                    'post_id' => $postId,
                    'emid' => $user->emid,
                    'employee_code' => $user->employee_id
                ]);
                $action = 'liked';
            }

            // Get updated like count
            $likesCount = PostLike::where('post_id', $postId)->count();

            return response()->json([
                'success' => true,
                'action' => $action,
                'likes_count' => $likesCount
            ]);

        } catch (\Exception $e) {
            \Log::error('Like error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to process like'
            ], 500);
        }
    }

    public function deletePost(Request $request, $id,$employee_code){
        dd($id,$employee_code);
        $post = Post::where('employee_code',$employee_code)->where('id',$id)->firstOrFail();
        return view('employeer\employee-corner\emp-post\edit-post');
    }

    public function update(Request $request)
    {
        // Validate the request
        //dd($request->post_id);
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2000',
            'post_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,mp4,mov,avi|max:10480',
            'remove_file' => 'sometimes|boolean',
            'post_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $post = Post::findOrFail($request->post_id);
            $filePath = $post->image_path;
            
            // Handle file removal
            if ($request->remove_file && $post->image_path) {
                Storage::disk('public')->delete($post->image_path);
                $filePath = null;
            }

            // Handle file upload
            if ($request->hasFile('post_file')) {
                // Delete old file if exists
                if ($post->image_path) {
                    Storage::disk('public')->delete($post->image_path);
                }
                
                $file = $request->file('post_file');
                $filePath = $file->store('employee-post', 'public');
            }

            // Update post
            $post->update([
                'title' => $request->content,
                'image_path' => $filePath
            ]);

            Session::flash('success', 'Post updated successfully.');
            return back();
            
        } catch (\Exception $e) {
            Session::flash('error', 'Error: ' . $e->getMessage());
            return back();
        }
    }

    public function edit(Request $request,$id)
    {
        //dd('okk');
        // Verify employee code
        // if ($request->employee_code && $post->employee_code !== $request->employee_code) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        $post = Post::where('id',$id)->firstOrFail();

        return response()->json([
            'title' => $post->title,
            'content' => $post->content,
            'image_path' => $post->image_path,
            'file_type' => $post->file_type,
        ]);
    }






}