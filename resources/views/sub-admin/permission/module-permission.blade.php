@extends('sub-admin.include.app')
@section('title', 'Registered Partner')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
           <div class="col">
              <h3 class="page-title">Module Permission</h3>
              <ul class="breadcrumb">
                 <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Partner Dashboard</a></li>
                 <li class="breadcrumb-item active">Module Permission</li>
              </ul>
           </div>
        </div>
     </div>
     <div class="page-header">
        <!--<h4 class="page-title">Organisation Profile</h4>-->
     </div>
     <div class="content">
        <div class="page-inner">
           <div class="row">
              <div class="col-md-12">
                 <div class="card custom-card">
                    <div class="card-header">
                        @php
                            $data = DB::table('registration')->where('reg',$org_id)->first();
                        @endphp
                        <h2 class="card-title">
                            <i class="far fa-building"></i> ( {{$data->com_name}}) Module Permission   
                        </h2>
                       {{-- <h4 class="card-title"><i class="far fa-user"></i> Module Permission</h4> --}}
                       @if(Session::has('message'))
                       <div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                       @endif
                    </div>
                    <div class="card-body" style="">
                        <form action="{{ url('subadmin/organization/module-permission') }}" method="POST">
                            @csrf
                            <input type="hidden" name="employee_id" value="{{$org_id}}">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered custom-table">
                                    <thead>
                                        <tr>
                                            <th width="50">
                                                <label class="custom_check">
                                                    <input type="checkbox" id="all" onclick="toggleAll(this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>

                                            <th width="150" colspan="2"> <h5><b>Module Name</b></h5></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($module as $menu)
                                        <tr>
                                              <td>{{$loop->iteration}}</td>
                                            <td>
                                                <label class="custom_check">
                                                    <input type="checkbox" 
                                                        name="modules[]" 
                                                        value="{{ $menu->id }}" 
                                                        {{ in_array($menu->id, $org_module) ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <h5>{{ $menu->module_name }}</h5>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
   </div>
</div>    
<!-- /Page Content -->
@endsection
@section('script')
<script>
    function toggleAll(source) {
        checkboxes = document.querySelectorAll('input[name="modules[]"]');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
</script>
@endsection