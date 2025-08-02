<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post\Post;
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
}
