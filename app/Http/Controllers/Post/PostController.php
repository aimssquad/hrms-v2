<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use App\Models\Post\PostComment;
use App\Models\Post\PostCommentReply;
use App\Models\User;
use App\Models\Employee;
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
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2000',
            'post_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,mp4,mov,avi|max:10480' // 10MB max
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $email = Session::get('emp_email');
        $userData = User::where('email', $email)
                      ->where('status', 'active')
                      ->firstOrFail();
        
        try {
            $filePath = null;
            $fileType = null;

            if ($request->hasFile('post_file')) {
                $file = $request->file('post_file');
                $filePath = $file->store('employee-post', 'public');
            }
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

    public function edit(Request $request,$id)
    {
        $post = Post::where('id',$id)->firstOrFail();

        return response()->json([
            'title' => $post->title,
            'content' => $post->content,
            'image_path' => $post->image_path,
            'file_type' => $post->file_type,
        ]);
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

    public function deletePost(Request $request, $id,$employee_code){
        $post = Post::where('id', $id)
                ->where('employee_code', $employee_code)
                ->firstOrFail();
        // Delete all likes for this post
        $post->likes()->delete();  
        // Delete all comments for this post  
        $post->comments()->delete(); 

        // Finally delete the post itself
        $post->delete();
        Session::flash('success', 'Post deleted successfully.');
        return redirect('organization/employerdashboard');
    }

    public function storeComment(Request $request)
    {
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

    public function commentReply(Request $request, $commentId){
        $email = Session::get('emp_email');
        $user = User::where('email', $email)->first();
        $employee = Employee::where('emp_code',$user->employee_id)->where('emid',$user->emid)->first();
        //dd($user);
        $data['emp_image'] = $employee->emp_image;
        $data['comments'] =  PostComment::find($commentId);
        $data['commenter'] = DB::table('employee')
            ->where('emid', $data['comments']->emid)
            ->where('emp_code', $data['comments']->employee_code)
            ->where('status', 'active')
            ->select(
                DB::raw("CONCAT(emp_fname, ' ', emp_lname) as employee_name"),
                'emp_image as employee_image'
            )
            ->first();
            // $data = [
            //     'comment_id' => $comments->id,
            //     'emid' => $comments->emid,
            //     'employee_code' => $comments->employee_code,
               
            // ]
        //dd($data);
        return view('employeer/employee-corner/emp-post/edit-post', $data);
    }

    public function commentReplySave(Request $request){
        return redirect('organization/employerdashboard');
    }

  //\Carbon\Carbon::parse($comment->created_at)->diffForHumans()



    

}