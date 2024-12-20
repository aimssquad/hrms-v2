@extends('employeer.include.app')
@section('title', 'Edit Organisation Bank')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active"> Edit Organisation Bank</li>
           </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="la la-bank" style="color:#ffa318;"></i> Edit Organisation Bank</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{url('org-settings/update-cmp-bank-details')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <input type="hidden" name="id" value="<?php print_r($bank['0']->id) ?>">
                                        <label for="inputFloatingLabel" class="col-form-label">Bank Name</label>
                                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="bankname" value="<?php print_r($bank['0']->bankname) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">Bank Branch</label>
                                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="bankbranch" value="<?php print_r($bank['0']->bankbranch) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">IFSC Code</label>
                                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="ifsccode" value="<?php print_r($bank['0']->ifsccode) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">MICR Code</label>
                                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="micrcode" value="<?php print_r($bank['0']->micrcode) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                        <select class="select" name="status">
                                                <option value="">Status</option>
                                                <option value="active" {{ $bank[0]->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inActive" {{ $bank[0]->status == 'inActive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        
                                        <!-- <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="status" > -->
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row form-group">
                                    <div class="col-md-2"><button type="submit" class="btn btn-primary">Submit</button></div>
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