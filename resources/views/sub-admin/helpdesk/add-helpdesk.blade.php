@extends('sub-admin.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Add Technical Support'))
@section('content')
<div class="content container-fluid pb-0">
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Technical Support')}}</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Technical Support')}} </li>
            </ul>
        </div>
    </div>
</div>
@include('sub-admin.layout.message')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="fa fa-wrench" style="color:rgb(253, 124, 3)"></i>  {{\App\Helpers\Helper::cachedTrans('Add New Technical Support')}}</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="{{ url('subadmin-store-helpdesk') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-group">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Name')}}</label>
                                            <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name"
                                                    value="{{ old('name', $comdtl->com_name) }}">

                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                        </div>
                                    </div>
                                   
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Email')}}</label>
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email"
                                                value="{{ old('email', $comdtl->email) }}">

                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                            
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Message')}}</label>
                                            <textarea name="message"
                                                    class="form-control @error('message') is-invalid @enderror"
                                                    required>{{ old('message') }}</textarea>

                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Image')}}</label>
                                           <input type="file"
                                                class="form-control @error('image') is-invalid @enderror"
                                                name="image">

                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                                <br>   
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="hidden" name="notice_for" value="employees"> 
                                            <input type="hidden" name="created_by_type" value="Organization"> 
                                            <button type="submit" class="btn btn-primary">{{\App\Helpers\Helper::cachedTrans('Submit')}}</button>
                                        </div>
                                    </div> 
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
