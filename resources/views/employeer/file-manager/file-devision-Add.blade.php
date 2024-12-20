@extends('employeer.include.app')
@section('title', 'Add Managment')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Add Division</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('file-management/dashboard')}}">File Manager Dashboard</a></li>
               <li class="breadcrumb-item active">Add Division</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               @include('employeer.layout.message')
               <form  method="post" action="{{url('file-management/fileManagment-division-adds')}}" enctype="multipart/form-data" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                           <label class="col-form-label">Name</label>
                           <input type="text" class="form-control input-border-bottom" id="name" name="name" oninput="intrFunction()" required>
                           <input type="hidden" id="sort" class="form-control" name="sort_name" >
                        </div>
                    </div>
                </div>
                <br>
                <div class="row form-group">
                   <div class="col-md-3">
                      <a href="#">
                      <button class="btn btn-primary" type="submit">Go</button></a>
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
    <script >
        function intrFunction(){
            $name=$("#name").val();
            $first=$name.charAt(0);
            $seco=$name.charAt(1);
            $finaltwochar=$first+""+$seco
            $("#sort").val($finaltwochar);
        }
    </script>
@endsection