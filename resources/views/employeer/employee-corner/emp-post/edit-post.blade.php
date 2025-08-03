@extends('employeer.employee-corner.main')
@section('title', 'Edit Post')

@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title" style="color:#ff902f">Edit Post</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}" style="color:#ff902f">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color:#ff902f">Edit Post</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-12 m-auto">
                        <form id="postForm" method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                        id="postContent" name="content" rows="5" 
                                        placeholder="What's on your mind?" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="postFile">Add File (Optional - Images, PDF, Word, Video)</label>
                                <input type="file" class="form-control @error('post_file') is-invalid @enderror" 
                                    id="postFile" name="post_file"
                                    accept="image/*,.pdf,.doc,.docx,video/*">
                                @error('post_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max file size: 10MB | Allowed formats: JPEG, PNG, GIF, PDF, DOC, DOCX, MP4, MOV, AVI</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection
