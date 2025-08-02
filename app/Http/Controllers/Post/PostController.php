<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
                //dd('okk');
                $file = $request->file('post_file');
                //$fileType = $file->getClientMimeType();
                
                // Store in storage/app/public/employee-post
                $filePath = $file->store('employee-post', 'public');
            }
            //dd($filePath);
            // Create post
            $post = Post::create([
                'emid' => $userData->emid,
                'employee_code' => $userData->employee_id,
                'title' => $request->content,
                // 'file_path' => $filePath,
                // 'file_type' => $fileType,
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
}