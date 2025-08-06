@extends('employeer.employee-corner.main')
@section('title', 'Edit Post')
@section('css')
<style>
    
    /* Comment Container Styles */
    .comment-container {
        background: #f0f2f5;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    /* Comment Header Styles */
    .comment-header {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .commenter-avatar {
        margin-right: 10px;
    }
    
    .commenter-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .commenter-info {
        flex-grow: 1;
    }
    
    .commenter-name {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        color: #050505;
    }
    
    .comment-time {
        font-size: 12px;
        color: #65676b;
    }
    
    /* Comment Body Styles */
    .comment-body {
        margin-left: 50px; /* Align with text below avatar */
    }
    
    .comment-text {
        font-size: 15px;
        line-height: 1.4;
        color: #050505;
        margin: 0;
        padding-bottom: 8px;
    }
    
    /* Comment Actions Styles */
    .comment-actions {
        display: flex;
        margin-left: 50px;
        padding-top: 4px;
    }
    
    .comment-action-btn {
        background: none;
        border: none;
        color: #65676b;
        font-size: 13px;
        font-weight: 600;
        padding: 0 12px 0 0;
        cursor: pointer;
    }
    
    .comment-action-btn:hover {
        text-decoration: underline;
    }
    
    /* Reply Form Styles */
    .reply-form-container {
        margin-top: 12px;
        margin-left: 50px;
    }
    
    .reply-form {
        background: #fff;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .reply-input-group {
        display: flex;
        align-items: center;
    }
    
    .reply-user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 8px;
    }
    
    .reply-textarea {
        flex-grow: 1;
        border-radius: 20px;
        background: #f0f2f5;
        border: none;
        resize: none;
        padding: 8px 12px;
        min-height: 40px;
        max-height: 100px;
        overflow-y: auto;
    }
    
    .reply-textarea:focus {
        background: #fff;
        box-shadow: 0 0 0 1px #e7f3ff;
    }
    
    .reply-buttons {
        display: flex;
        justify-content: flex-end;
        margin-top: 8px;
    }
    
    .cancel-reply {
        margin-left: 8px;
    }
</style>


@endsection

@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title" style="color:#ff902f">Comment Reply</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}" style="color:#ff902f">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color:#ff902f">Comment Reply</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-12 col-lg-12 m-auto">
                        <p>{{$commenter->employee_name}}</p>
                        <img src="{{asset('storage/'.$commenter->employee_image)}}" alt="">
                        <p>{{$comments->comment_text}}</p>
                        <form id="postForm" method="post" action="" enctype="multipart/form-data">
                           
                            @csrf
                            <div class="form-group mb-3">
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                        id="reply" name="reply" rows="5" 
                                        placeholder="What's on your mind?" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Reply</button>
                        </form>
                    </div> --}}

                    <div class="col-12 col-lg-12 m-auto">
                        <div class="comment-container">
                            <!-- Comment Header with user info -->
                            <div class="comment-header">
                                <div class="commenter-avatar">
                                    @if($commenter->employee_image == null)
                                        <img src="{{asset('assets/img/user.png')}}" alt="You" class="reply-user-avatar">
                                    @else
                                    <img src="{{ asset('storage/app/public/'.$commenter->employee_image) }}" alt="{{ $commenter->employee_name }}" class="commenter-image">
                                    @endif
                                    
                                </div>
                                <div class="commenter-info">
                                    <h5 class="commenter-name">{{ $commenter->employee_name }}</h5>
                                    <span class="comment-time">{{\Carbon\Carbon::parse($comments->created_at)->diffForHumans()}}</span>
                                </div>
                            </div>
                            
                            <!-- Comment Content -->
                            <div class="comment-body">
                                <p class="comment-text">{{ $comments->comment_text }}</p>
                            </div>
                            
                            <!-- Comment Actions (Like, Reply) -->
                            <div class="comment-actions">
                                {{-- <button class="comment-action-btn">Like</button> --}}
                                <button class="comment-action-btn reply-trigger">Reply</button>
                            </div>
                            
                            <!-- Reply Form (Initially hidden) -->
                            <div class="reply-form-container">
                                <form id="postForm" method="post" action="{{route('comment.reply.save')}}" enctype="multipart/form-data" class="reply-form">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{$comments->post_id}}">
                                    <input type="hidden" name="comment_id" value="{{$comments->id}}">
                                    <input type="hidden" name="comment_employee_id" value="{{$comments->employee_code}}">
                                    <div class="form-group mb-3">
                                        <div class="reply-input-group">
                                            @if($emp_image == null)
                                                <img src="{{asset('assets/img/user.png')}}" alt="You" class="reply-user-avatar">
                                            @else
                                                <img src="{{ asset('storage/app/public/'.$emp_image) }}" alt="Your profile" class="reply-user-avatar">
                                            @endif
                                            
                                            <textarea class="form-control reply-textarea @error('content') is-invalid @enderror" 
                                                    id="reply" name="reply" rows="1" 
                                                    placeholder="Write a reply..." required>{{ old('content') }}</textarea>
                                        </div>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="reply-buttons">
                                        <button type="submit" class="btn btn-primary">Reply</button>
                                        <button type="button" class="btn btn-outline-secondary cancel-reply">Cancel</button>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection

