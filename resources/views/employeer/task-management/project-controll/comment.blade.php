@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Comment'))
@section('css')
<style>
.reply-btn{
    opacity: 0;
    visibility: hidden;
    transition: all .2s ease-in-out;
}

.comment-wrapper:hover .reply-btn{
    opacity: 1;
    visibility: visible;
}

.comment-box{
    transition: all .2s ease;
}

.comment-wrapper:hover .comment-box{
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,.12) !important;
}

.reply-color{
    background-color:#FFACBA;
}
.rep-s-name{
    background-color:#FFDBFD;
}
</style>
@endsection

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Comment</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">Comment</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @include('employeer.layout.message')
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
color: #fff;">
                        <h5 class="mb-0 text-white">
                            <i class="fa fa-comments"></i>
                            Discussion ({{ count($comments) }})
                        </h5>
                    </div>
                
                    <div class="card-body"
                         id="chat-body"
                         style="height:400px;overflow-y:auto;background:#f5f7fb;">
                
                        @foreach($comments as $comment)
                
                            @php
                
                                /*
                                 |-------------------------------------------------------
                                 | Organization Comments
                                 |-------------------------------------------------------
                                 | Change according to your system
                                 */
                
                                $isOrganization =
                                    $comment->employee_id == $organizationId;
                
                            @endphp
                
                            <div class="d-flex mb-4 {{ $isOrganization ? 'justify-content-end' : '' }}">
                
                                {{-- Left Avatar --}}
                
                                @if(!$isOrganization)
                
                                    <div class="me-2">
                
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                             style="width:42px;height:42px;font-weight:bold;">
                
                                            {{ strtoupper(substr($comment->user->name,0,1)) }}
                
                                        </div>
                
                                    </div>
                
                                @endif
                
                                {{-- Message Body --}}
                
                                <div style="max-width:70%;">
                
                                    <div class="{{ $isOrganization ? 'text-end' : '' }}">
                
                                        <strong class="text-secondary">
                
                                            {{ $comment->user->name ?? $comment->employee_id }}
                
                                        </strong>
                
                                    </div>
                
                                   
                                    
                                    <div class="comment-wrapper">

                                        <div class="mt-1 p-3 rounded shadow-sm comment-box
                                            {{ $isOrganization ? 'bg-white text-dark' : 'bg-white' }}">
                                    
                                            {{ $comment->comment }}
                                    
                                            @if($comment->file)
                                    
                                                <div class="mt-2">
                                    
                                                    <a href="{{ asset('storage/'.$comment->file) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-light">
                                    
                                                        <i class="fa fa-paperclip"></i>
                                                        Attachment
                                    
                                                    </a>
                                    
                                                </div>
                                    
                                            @endif
                                    
                                        </div>
                                    
                                        <div class="mt-1 {{ $isOrganization ? 'text-end' : '' }}">
                                    
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                            </small>
                                    
                                            @if($comment->employee_id != $organizationId)
                                    
                                                <a href="javascript:void(0)"
                                                   class="reply-btn ms-2 text-primary"
                                                   data-id="{{ $comment->id }}">
                                    
                                                    <i class="fa fa-reply"></i>
                                                    Reply
                                    
                                                </a>
                                    
                                            @endif
                                    
                                        </div>
                                    
                                    </div>
                
                                </div>
                
                                {{-- Right Avatar --}}
                
                                @if($isOrganization)
                
                                    <div class="ms-2">
                
                                        <div class="rounded-circle rep-s-name text-primary d-flex align-items-center justify-content-center"
                                             style="width:42px;height:42px;font-weight:bold;">
                
                                            {{ strtoupper(substr($comment->user->name,0,1)) }}
                
                                        </div>
                
                                    </div>
                
                                @endif
                                
                                {{----Comment Reply Form-----}}
                                <div class="reply-form mt-2 ms-5"
                                     id="reply-form-{{ $comment->id }}"
                                     style="display:none;  width: 500px;">
                                
                                    <form action="{{ route('work-item.comment.store') }}"
                                          method="POST">
                                
                                        @csrf
                                
                                        <input type="hidden"
                                               name="project_id"
                                               value="{{ $project_id }}">
                                
                                        <input type="hidden"
                                               name="work_item_id"
                                               value="{{ $work_item_id }}">
                                
                                        <input type="hidden"
                                               name="parent_comment_id"
                                               value="{{ $comment->id }}">
                                
                                        <div class="input-group">
                                
                                            <input type="text"
                                                   name="comment"
                                                   class="form-control"
                                                   placeholder="Reply to {{ $comment->name }}"
                                                   required>
                                
                                            <button type="submit"
                                                    class="btn btn-primary">
                                
                                                Reply
                                
                                            </button>
                                
                                        </div>
                                
                                    </form>
                                
                                </div>
                
                            </div>
                            
                            @if($comment->replies->count())

                                <div class="ms-5 mt-2">
                            
                                    @foreach($comment->replies as $reply)
                            
                                        <div class="mb-2">
                            
                                            <div class="card border-start border-warning border-3" style="width:400px;">
                            
                                                <div class="card-body p-2">
                            
                                                    <div class="d-flex justify-content-between">
                            
                                                        <strong>
                                                            {{ $reply->user->name ?? $reply->employee_id }}
                                                        </strong>
                            
                                                        <small class="text-muted">
                                                            {{ $reply->created_at->diffForHumans() }}
                                                        </small>
                            
                                                    </div>
                            
                                                    <div class="mt-1">
                            
                                                        {{ $reply->comment }}
                            
                                                    </div>
                            
                                                </div>
                            
                                            </div>
                            
                                        </div>
                            
                                    @endforeach
                            
                                </div>
                            
                            @endif
                
                        @endforeach
                
                    </div>
                
                    {{-- Comment Form --}}
                
                    <div class="card-footer bg-white">
                
                        <form action="{{ route('work-item.comment.store') }}"
                              method="POST"
                              enctype="multipart/form-data">
                
                            @csrf
                
                            <input type="hidden"
                                   name="project_id"
                                   value="{{ $project_id }}">
                
                            <input type="hidden"
                                   name="work_item_id"
                                   value="{{ $work_item_id }}">
                
                            <div class="row">
                
                                <div class="col-md-8">
                
                                    <input type="text"
                                           name="comment"
                                           class="form-control"
                                           placeholder="Type your message..."
                                           required>
                
                                </div>
                
                                <div class="col-md-3">
                
                                    <input type="file"
                                           name="attachment"
                                           class="form-control">
                
                                </div>
                
                                <div class="col-md-1">
                
                                    <button type="submit"
                                            class="btn btn-primary w-100">
                
                                        <i class="fa fa-paper-plane"></i>
                
                                    </button>
                
                                </div>
                
                            </div>
                
                        </form>
                
                    </div>
                    
                
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
   
@endsection
@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>
    

    <script>
    
    document.addEventListener("DOMContentLoaded", function () {
    
        let chatBody = document.getElementById('chat-body');
    
        if(chatBody){
    
            chatBody.scrollTop = chatBody.scrollHeight;
    
        }
    
    });
    
    $(document).on('click', '.reply-btn', function () {

        let id = $(this).data('id');
    
        $('.reply-form').hide();
    
        $('#reply-form-' + id).slideToggle();
    
    });
    </script>
    

@endsection
