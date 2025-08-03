<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post\Post;
use App\Models\Post\PostComment;
use App\Models\HolidayApply;
use App\Models\Holiday;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;

class PostController extends Controller
{
       public function savePost(Request $request){
        //dd('okk');
        try{
            if (auth()->check()) {
                $employeeId = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
              
                $validator = Validator::make($request->all(), [
                    'content' => 'required|string|max:2000',
                    'post_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,mp4,mov,avi|max:10480' // 10MB max
                ]);

                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                    $filePath = null;
                    $fileType = null;
            
                // Handle file upload
                if ($request->hasFile('post_file')) {
                    $file = $request->file('post_file');
                    $filePath = $file->store('employee-post', 'public');
                }
                //dd($filePath);
                // Create post
                $data = Post::create([
                    'emid' => $emid,
                    'employee_code' => $employeeId,
                    'title' => $request->content,
                    'image_path'=> $filePath,
                ]);

                $dynamicFlag = 1;
                $message = "Data submit successfully";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            } else {
                $dynamicFlag = 1;
                $data=[];
                $message = "Somthing Went Wrong";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            }     
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }  
    }

   

    public function saveComment(Request $request)
    {
       
        if (!auth()->check()) {
            return Helper::rjd("Authentication required", 0, [], 401);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|integer|exists:post,id', // Assuming posts table exists
            'comment_text' => 'required|string|max:1000' // Add max length
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
                'input' => $request->all()
            ], 422);
        }

        try {
            // Prepare data
            $commentData = [
                'post_id' => $request->post_id,
                'emid' => auth()->user()->emid,
                'employee_code' => auth()->user()->employee_id,
                'comment_text' => trim($request->comment_text)
            ];

            // Create comment
            $comment = PostComment::create($commentData);

            // Optional: Fire event for notifications or other actions
            //event(new NewCommentPosted($comment));

            $data = $comment;
            $dynamicFlag = 1;
            $message = "Comment submitted successfully";
            return Helper::rjd(
                $message,
                $dynamicFlag,
                $data
            );

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Comment submission failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'input' => $request->all()
            ]);

            return Helper::rj(
                "Failed to submit comment. Please try again.",
                500
            );
        }
    }





}
