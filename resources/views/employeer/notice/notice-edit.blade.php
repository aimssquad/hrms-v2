@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Edit Notice'))
@section('content')
<div class="content container-fluid pb-0">
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Edit Notice')}}</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Edit Notice')}}</li>
            </ul>
        </div>
    </div>
</div>
@include('employeer.layout.message')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="las la-bullhorn" style="color:rgb(253, 124, 3)"></i>  {{\App\Helpers\Helper::cachedTrans('Edit Notice')}}</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="{{ route('update.notice', $notice->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Title')}}</label>
                                            <input type="text" class="form-control" name="title" value="{{ old('title', $notice->title) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Start Date')}}</label>
                                            <input type="date" name="start_date" class="form-control" 
                                                   value="{{ old('start_date', \Carbon\Carbon::parse($notice->start_date)->format('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('End Date')}}</label>
                                            <input type="date" name="end_date" class="form-control" 
                                                   value="{{ old('end_date', \Carbon\Carbon::parse($notice->end_date)->format('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Description')}}</label>
                                            <textarea name="description" class="form-control" required>{{ old('description', $notice->description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Image')}}</label>
                                            <input type="file" class="form-control" name="image">
                                            @if($notice->image)
                                                <div class="mt-2">
                                                    <label>{{\App\Helpers\Helper::cachedTrans('Current Image')}}:</label>
                                                    <a href="{{ Storage::url($notice->image) }}" target="_blank" class="btn btn-sm btn-info mt-2">{{\App\Helpers\Helper::cachedTrans('View Full Image')}}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">{{\App\Helpers\Helper::cachedTrans('Update Notice')}}</button>
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
