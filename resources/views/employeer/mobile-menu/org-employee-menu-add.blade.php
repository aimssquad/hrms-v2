@extends('employeer.include.app')
@section('title', 'Add Mobile Menu')
@section('content')
<div class="content container-fluid pb-0">
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Mobile Menu For Employee</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Monile Menu </li>
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
                  <h4 class="card-title"><i class="las la-mobile" style="color:rgb(253, 124, 3)"></i>Monile Menu</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Select Menu</label>
                                            <select name="menu_id" id="" class="select">
                                                <option value="">Select</option>
                                                @foreach($menus as $menu)
                                                    <option value="{{$menu->id}}">{{ $menu->menu_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">Status</label>
                                        <select name="status" id="" class="select">
                                            <option value="">Select</option>
                                            <option value="0">Active</option>
                                            <option value="1">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 pt-4">
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
</div>
@endsection
