@extends('employeer.include.app')
@section('title', 'Employee Permission')
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('user-access-role/dashboard')}}">User Permissions Dashboard</a></li>
            <li class="breadcrumb-item active">Employee Permission</li> 
         </ul>
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title"><i class="far fa-user"></i> Employee Permission</h4>
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                    <form action="{{url('user-access/emp-permission')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                                <h6 class="card-title m-b-20">Select Employee</h6>
                                <div class="roles-menu">
                                    {{-- <h3>Select Employee</h3> --}}
                                    {{-- <label class="col-form-label" >Select Employee</label> --}}
                                    <select class="select" multiple data-live-search="true" name="member_id[]" required>
                                    <option value="" label="default"> Select</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->email}}">{{$user->name}}</option>
                                    @endforeach
                                    </select>      
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
                                <h6 class="card-title m-b-20">Module Access</h6>
                                <div class="m-b-30">
                                    <ul class="list-group notification-list">
                                        @foreach($module as $module)
                                        <li class="list-group-item">
                                            {{ $module->module_name }}
                                            <div class="status-toggle">
                                                <input 
                                                    type="checkbox" 
                                                    id="module_{{ $module->id }}" 
                                                    name="modules[]" 
                                                    value="{{ $module->id }}" 
                                                    class="check"
                                                    >
                                                <label for="module_{{ $module->id }}" class="checktoggle">checkbox</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>      	
                                {{-- <div class="table-responsive">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th>Module Permission</th>
                                                <th class="text-center">Read</th>
                                                <th class="text-center">Write</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">Import</th>
                                                <th class="text-center">Export</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Employee</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Holidays</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Leaves</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Events</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                                <input type="checkbox" checked>													
                                                                <span class="checkmark"></span>
                                                            </label>																
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> --}}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form> 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')

@endsection