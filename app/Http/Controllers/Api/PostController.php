<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post\Post;
use App\Models\Post\PostComment;
use App\Models\Post\PostLike;
use App\Models\HolidayApply;
use App\Models\Holiday;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;
use Carbon\Carbon;

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

    // public function toggleLike(Request $request, $postId)
    // {
    //     //dd(auth()->user()->emid,auth()->user()->employee_id);
    //     if (!auth()->check()) {
    //         return Helper::rjd("Authentication required", 0, [], 401);
    //     }          

    //     try {
    //         // Check if like already exists
    //         $existingLike = PostLike::where('post_id', $postId)
    //                               ->where('emid', auth()->user()->emid)
    //                               ->where('employee_code', auth()->user()->employee_id)
    //                               ->first();
    //         //dd($existingLike);
    //         if ($existingLike) {
    //             // Unlike the post
    //             //dd('okk');
    //             $existingLike->delete();
    //             $action = 'unliked';
    //         } else {
    //             // Like the post
    //             PostLike::create([
    //                 'post_id' => $postId,
    //                 'emid' => auth()->user()->emid,
    //                 'employee_code' => auth()->user()->employee_id
    //             ]);
    //             $action = 'liked';
    //         }
    //         //dd('5555k');
    //         // Get updated like count
    //         $likesCount = PostLike::where('post_id', $postId)->count();

    //         return response()->json([
    //             'flag' => true,
    //             'action' => $action,
    //             'likes_count' => $likesCount
    //         ]);

    //     } catch (\Exception $e) {
    //         \Log::error('Like error: '.$e->getMessage());
    //         return response()->json([
    //             'flag' => false,
    //             'error' => 'Failed to process like'
    //         ], 500);
    //     }
    // }

    //main function
    // public function allPost(Request $request)
    // {
    //     if (!auth()->check()) {
    //         return Helper::rjd("Authentication required", 0, [], 401);
    //     }

    //     try {
    //         $user = auth()->user();
            
    //         // Main posts query
    //         $posts = DB::table('post')
    //             ->join('employee', function($join) {
    //                 $join->on('employee.emid', '=', 'post.emid')
    //                     ->on('employee.emp_code', '=', 'post.employee_code');
    //             })
    //             ->leftJoin('post_likes', function($join) use ($user) {
    //                 $join->on('post_likes.post_id', '=', 'post.id')
    //                     ->where('post_likes.emid', $user->emid)
    //                     ->where('post_likes.employee_code', $user->employee_id);
    //             })
    //             ->where('employee.status', 'active')
    //             ->orderBy('post.created_at', 'desc')
    //             ->select(
    //                 'post.*',
    //                 'employee.emp_fname as first_name',
    //                 'employee.emp_lname as last_name',
    //                 'employee.emp_image as employee_image',
    //                 'employee.emp_designation as designation',
    //                 DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id) as likes_count'),
    //                 DB::raw('CASE WHEN post_likes.id IS NOT NULL THEN 1 ELSE 0 END as is_liked')
    //             )
    //             ->get();

    //         // If no posts found
    //         if ($posts->isEmpty()) {
    //             return Helper::rjd("No posts found", 1, ['posts' => []]);
    //         }

    //         // Get all post IDs for batch comments query
    //         $postIds = $posts->pluck('id');

    //         // Batch load all comments for these posts
    //         $allComments = DB::table('post_comments')
    //             ->join('employee', function($join) {
    //                 $join->on('employee.emid', '=', 'post_comments.emid')
    //                     ->on('employee.emp_code', '=', 'post_comments.employee_code');
    //             })
    //             ->whereIn('post_comments.post_id', $postIds)
    //             ->where('employee.status', 'active')
    //             ->orderBy('post_comments.created_at', 'asc')
    //             ->select(
    //                 'post_comments.*',
    //                 'post_comments.post_id',
    //                 'employee.emp_fname as commenter_first_name',
    //                 'employee.emp_lname as commenter_last_name',
    //                 'employee.emp_image as commenter_image',
    //                 'employee.emp_designation as commenter_designation'
    //             )
    //             ->get()
    //             ->groupBy('post_id'); // Group comments by post_id

    //         // Transform posts
    //         $transformedPosts = $posts->map(function ($post) use ($allComments) {
    //             $comments = $allComments->get($post->id, collect())->map(function ($comment) {
    //                 return (object)[
    //                     'id' => $comment->id,
    //                     'comment_text' => $comment->comment_text,
    //                     'created_at' => $comment->created_at,
    //                     'commenter_name' => trim($comment->commenter_first_name . ' ' . $comment->commenter_last_name),
    //                     'commenter_image' => $comment->commenter_image 
    //                         ? asset("storage/app/public/".$comment->commenter_image) 
    //                         : asset('assets/img/user.png'),
    //                     'commenter_designation' => $comment->commenter_designation,
    //                     'time_ago' => \Carbon\Carbon::parse($comment->created_at)->diffForHumans()
    //                 ];
    //             });

    //             return (object)[
    //                 'id' => $post->id,
    //                 'emid' => $post->emid,
    //                 'employee_code' => $post->employee_code,
    //                 'title' => $post->title,
    //                 'image_path' => $post->image_path ? asset("storage/app/public/".$post->image_path) : null,
    //                 'created_at' => $post->created_at,
    //                 'updated_at' => $post->updated_at,
    //                 'employee_name' => trim($post->first_name . ' ' . $post->last_name),
    //                 'employee_image' => $post->employee_image 
    //                     ? asset("storage/app/public/".$post->employee_image) 
    //                     : asset('assets/img/user.png'),
    //                 'designation' => $post->designation,
    //                 'time_ago' => \Carbon\Carbon::parse($post->created_at)->diffForHumans(),
    //                 'comments' => $comments,
    //                 'comments_count' => $comments->count(),
    //                 'likes_count' => $post->likes_count ?? 0,
    //                 'is_liked' => $post->is_liked ?? false
    //             ];
    //         });

    //         return Helper::rjd(
    //             "All data retrieved successfully",
    //             1,
    //             ['posts' => $transformedPosts]
    //         );

    //     } catch (\Exception $e) {
    //         \Log::error('Post error: '.$e->getMessage());
    //         return Helper::rjd(
    //             "Failed to process posts",
    //             0,
    //             [],
    //             500
    //         );
    //     }
    // }

    public function allPost(Request $request)
    {
        if (!auth()->check()) {
            return Helper::rjd("Authentication required", 0, [], 401);
        }

        try {
            $user = auth()->user();
            
            // Main posts query
            $posts = DB::table('post')
                ->join('employee', function($join) {
                    $join->on('employee.emid', '=', 'post.emid')
                        ->on('employee.emp_code', '=', 'post.employee_code');
                })
                ->leftJoin('post_likes', function($join) use ($user) {
                    $join->on('post_likes.post_id', '=', 'post.id')
                        ->where('post_likes.emid', $user->emid)
                        ->where('post_likes.employee_code', $user->employee_id);
                })
                ->where('employee.status', 'active')
                ->orderBy('post.created_at', 'desc')
                ->select(
                    'post.*',
                    'employee.emp_fname as first_name',
                    'employee.emp_lname as last_name',
                    'employee.emp_image as employee_image',
                    'employee.emp_designation as designation',
                    DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id) as total_reactions_count'),
                    DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id AND name = "like") as like_count'),
                    DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id AND name = "love") as love_count'),
                    DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id AND name = "haha") as haha_count'),

                    DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id AND name = "wow") as wow_count'),
                    DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id AND name = "sad") as sad_count'),
                    DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id AND name = "angry") as angry_count'),
                    // Add more reaction types as needed
                    DB::raw('CASE WHEN post_likes.id IS NOT NULL THEN post_likes.name ELSE NULL END as user_reaction')
                )
                ->get();

            // If no posts found
            if ($posts->isEmpty()) {
                return Helper::rjd("No posts found", 1, ['posts' => []]);
            }

            // Get all post IDs for batch comments query
            $postIds = $posts->pluck('id');

            // Batch load all comments for these posts
            $allComments = DB::table('post_comments')
                ->join('employee', function($join) {
                    $join->on('employee.emid', '=', 'post_comments.emid')
                        ->on('employee.emp_code', '=', 'post_comments.employee_code');
                })
                ->whereIn('post_comments.post_id', $postIds)
                ->where('employee.status', 'active')
                ->orderBy('post_comments.created_at', 'asc')
                ->select(
                    'post_comments.*',
                    'post_comments.post_id',
                    'employee.emp_fname as commenter_first_name',
                    'employee.emp_lname as commenter_last_name',
                    'employee.emp_image as commenter_image',
                    'employee.emp_designation as commenter_designation'
                )
                ->get()
                ->groupBy('post_id'); // Group comments by post_id

            // Transform posts
            $transformedPosts = $posts->map(function ($post) use ($allComments) {
                $comments = $allComments->get($post->id, collect())->map(function ($comment) {
                    return (object)[
                        'id' => $comment->id,
                        'comment_text' => $comment->comment_text,
                        'created_at' => $comment->created_at,
                        'commenter_name' => trim($comment->commenter_first_name . ' ' . $comment->commenter_last_name),
                        'commenter_image' => $comment->commenter_image 
                            ? asset("storage/app/public/".$comment->commenter_image) 
                            : asset('assets/img/user.png'),
                        'commenter_designation' => $comment->commenter_designation,
                        'time_ago' => \Carbon\Carbon::parse($comment->created_at)->diffForHumans()
                    ];
                });

                return (object)[
                    'id' => $post->id,
                    'emid' => $post->emid,
                    'employee_code' => $post->employee_code,
                    'title' => $post->title,
                    'image_path' => $post->image_path ? asset("storage/app/public/".$post->image_path) : null,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'employee_name' => trim($post->first_name . ' ' . $post->last_name),
                    'employee_image' => $post->employee_image 
                        ? asset("storage/app/public/".$post->employee_image) 
                        : asset('assets/img/user.png'),
                    'designation' => $post->designation,
                    'time_ago' => \Carbon\Carbon::parse($post->created_at)->diffForHumans(),
                    'comments' => $comments,
                    'comments_count' => $comments->count(),
                    'reactions' => [
                        'total' => $post->total_reactions_count ?? 0,
                        'like' => $post->like_count ?? 0,
                        'love' => $post->love_count ?? 0,
                        'haha' => $post->haha_count ?? 0,
                        'wow' => $post->wow_count ?? 0,
                        'sad' => $post->sad_count ?? 0,
                        'angry' => $post->angry_count ?? 0,
                        // Add more reaction types as needed
                    ],
                    'user_reaction' => $post->user_reaction ?? null
                ];
            });

            return Helper::rjd(
                "All data retrieved successfully",
                1,
                ['posts' => $transformedPosts]
            );

        } catch (\Exception $e) {
            \Log::error('Post error: '.$e->getMessage());
            return Helper::rjd(
                "Failed to process posts",
                0,
                [],
                500
            );
        }
    }

    public function toggleLike(Request $request, $postId)
    {
        if (!auth()->check()) {
            return Helper::rjd("Authentication required", 0, [], 401);
        }

        try {
            $user = auth()->user();
            //$request->name = $request->input('reaction_type', 'like'); // Default to 'like' if not specified
            $validator = Validator::make($request->all(), [
                'name' => [
                    'nullable',
                    'string',
                    'in:like,love,haha,wow,sad,angry'
                ]
            ]);
            // Check if reaction already exists
            $existingReaction = PostLike::where('post_id', $postId)
                                    ->where('emid', $user->emid)
                                    ->where('employee_code', $user->employee_id)
                                    ->first();

            $action = null;
            
            if ($existingReaction) {
                if ($existingReaction->name === $request->name) {
                    // Remove the reaction if it's the same type
                    $existingReaction->delete();
                    $action = 'removed';
                } else {
                    // Update to new reaction type
                    $existingReaction->update(['name' => $request->name]);
                    $action = 'updated';
                }
            } else {
                // Create new reaction
                PostLike::create([
                    'post_id' => $postId,
                    'emid' => $user->emid,
                    'employee_code' => $user->employee_id,
                    'name' => $request->name
                ]);
                $action = 'added';
            }

            // Get updated reaction counts
            $reactionCounts = PostLike::where('post_id', $postId)
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('SUM(name = "like") as like_count')
                ->selectRaw('SUM(name = "love") as love_count')
                ->selectRaw('SUM(name = "haha") as haha_count')
                // Add more reaction types as needed
                ->first();

            // Get current user's reaction after update
            $userReaction = PostLike::where('post_id', $postId)
                                ->where('emid', $user->emid)
                                ->where('employee_code', $user->employee_id)
                                ->value('name');

            return Helper::rjd(
                "Reaction processed successfully",
                1,
                [
                    'action' => $action,
                    'reaction_type' => $request->name,
                    'reactions' => [
                        'total' => $reactionCounts->total ?? 0,
                        'like' => $reactionCounts->like_count ?? 0,
                        'love' => $reactionCounts->love_count ?? 0,
                        'haha' => $reactionCounts->haha_count ?? 0,
                        // Add more reaction types as needed
                    ],
                    'user_reaction' => $userReaction
                ]
            );

        } catch (\Exception $e) {
            \Log::error('Reaction error: '.$e->getMessage());
            return Helper::rjd(
                "Failed to process reaction",
                0,
                [],
                500
            );
        }
    }

    




}
