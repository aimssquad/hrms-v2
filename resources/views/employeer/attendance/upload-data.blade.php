@extends('employeer.include.app')
@section('title', 'Sync')
@section('content')
<div class="content container-fluid pb-0">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Sync</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('attendance-management/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sync</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    @include('employeer.layout.message')
                    <div class="col-auto float-end ms-auto">
                        <a class="btn add-btn" href="{{ asset('public/excel/attendence1.csv')}}" download> Download</a>
                        <br><br>
                        <p class="mt-2 mb-0 text-center">Download Sample here</p>
                    </div>
                    
                    <form  method="post" action="{{ url('attendance-management/upload-data') }}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row form-group">
                            <div class="col-md-3">
                            <div class=" form-group ">
                                <label for="upload_csv" class="col-form-label">File To Upload (.csv)</label>
                                <input type="file" id="upload_csv" name="upload_csv" class="form-controll" required>
                            </div>
                            <span style="color:rgb(243, 150, 29)">*Document Size Less Than 2 MB</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                            <a href="#">
                            <button class="btn btn-primary" type="submit">Upload</button></a>
                            <a href="#">
                            <button class="btn btn-primary" type="reset">Reset</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection