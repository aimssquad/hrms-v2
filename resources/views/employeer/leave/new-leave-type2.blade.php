@extends('employeer.include.app')
@section('title', 'Add Catagory')
@if(!empty($holidaydtl->id))  
@section('title', 'Edit Catagory')
@else   
@section('title', 'Add Catagory')
@endif 
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('leave/dashboard')}}">Dashboard</a></li>
            @if(!empty($holidaydtl->id))
            <li class="breadcrumb-item active">Edit Catagory</li>
            @else
            <li class="breadcrumb-item active">Add New Catagory</li>
            @endif
         </ul>
         <div class="card custom-card">
            <div class="card-header">
               @if(!empty($holidaydtl->id))  
               <h4 class="card-title"><i class="far fa-user"></i>  Edit Catagory</h4>
               @else   
               <h4 class="card-title"><i class="far fa-user"></i>  Add New Catagory</h4>
               @endif 
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form action="{{url('leave/new-leave-type')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="<?php if(!empty($holidaydtl->id)){echo $holidaydtl->id;} ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave-type" class="col-form-label">Leave Type</label>
                                        <input type="text" class="form-control input-border-bottom" required="" name='leave_type_name' id="leave-type" value="<?php if(isset($holidaydtl->id)){ echo $holidaydtl->leave_type_name; }?>{{ old('leave_type_name') }}">
                                        @if($errors->has('leave_type_name'))
                                        <div class="error" style="color:red;">{{$errors->first('leave_type_name')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alias" class="col-form-label">Leave Type Sort Code</label>
                                        <input type="text" class="form-control input-border-bottom" required="" name='alies' id="alias" value="<?php if(isset($holidaydtl->id)){ echo $holidaydtl->alies; }?>{{ old('alies') }}">
                                        @if($errors->has('alies'))
                                        <div class="error" style="color:red;">{{ $errors->first('alies') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputFloatingLabel-remarks" class="col-form-label">Remarks</label>
                                        <input id="inputFloatingLabel-remarks" type="text" class="form-control input-border-bottom" name='remarks' value="<?php if(isset($holidaydtl->id)){ echo $holidaydtl->remarks; }?>">
                                    </div>
                                </div>
                                <!-- New Color Picker Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color_code" class="col-form-label">Color Code</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control" id="color_code" name="color_code" value="<?php if(isset($holidaydtl->color_code)){ echo $holidaydtl->color_code; } else { echo '#3a87ad'; } ?>" style="height: 38px; padding: 3px;">
                                            <input type="text" class="form-control input-border-bottom" id="color_code_text" value="<?php if(isset($holidaydtl->color_code)){ echo $holidaydtl->color_code; } else { echo '#3a87ad'; } ?>" placeholder="Hex color code" style="max-width: 120px;">
                                        </div>
                                        @if($errors->has('color_code'))
                                        <div class="error" style="color:red;">{{ $errors->first('color_code') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
@endsection
@section('script')
    <script>
        // Sync color picker and text input
        document.getElementById('color_code').addEventListener('input', function() {
            document.getElementById('color_code_text').value = this.value;
        });
        
        document.getElementById('color_code_text').addEventListener('input', function() {
            if(/^#[0-9A-F]{6}$/i.test(this.value)) {
                document.getElementById('color_code').value = this.value;
            }
        });
    </script>
@endsection