@extends('sub-admin.include.app')
@section('title', 'Approved Organisation')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Partner Organisation Employee List</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
               <!--<li class="breadcrumb-item"><a href="#">Organisation Dashboard</a></li>-->
               <li class="breadcrumb-item active">Partner Organisation Employee List</li>
            </ul>
         </div>
      </div>
   </div>
   @include('sub-admin.layout.message')
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               <form  method="get" action="{{ url('subadmin/organization-employee') }}" method="get" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row form-group">
                     <div class="col-md-5">
                        <div class=" form-group">
                           <label for="for-form-date"  class="col-form-label">Organization name</label>
                           <select class="select" id="emid" name="emid">
                                <option value="">Select</option>
                                @foreach($totalActiveOrganizations as $organization)
                                <option value="{{$organization->reg}}" {{ old('emid') == $organization->reg ? 'selected' : '' }}>{{$organization->com_name}}</option>
                                @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class=" form-group">
                           <label for="for-to-date"  class="col-form-label">Status</label>
                           <select class="select" id="verify_status" name="verify_status">
                                <option value="">Select</option>
                                <option value="approved" {{ old('verify_status') == 'approved' ? 'selected' : '' }}>Active</option>
                                <option value="not approved" {{ old('verify_status') == 'not approved' ? 'selected' : '' }}>Inactive</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-2 btn-up">
                        <button class="btn btn-primary" type="submit" style="margin-top:25px;">Search</button>
                        <a class="btn btn-primary" href="" style="margin-top:25px;">Reset</a>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                  <i class="fa fa-users" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Partner Organisation Employee List
               </h4>
               <div class="row">
                  <div class="col-auto">
                     <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                        @csrf
                        <input type="hidden" name="data" id="data">
                        <input type="hidden" name="headings" id="headings">
                        <input type="hidden" name="filename" id="filename">
                        {{-- put the value - that is your file name --}}
                        <input type="hidden" id="filenameInput" value="Active-organization-employee">
                        <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export to Excel
                        </button>
                     </form>
                  </div>
                  <div class="col-auto">
                     <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                        @csrf
                        <input type="hidden" name="data" id="pdfData">
                        <input type="hidden" name="headings" id="pdfHeadings">
                        <input type="hidden" name="filename" id="pdfFilename">
                        <button type="submit" class="btn btn-info btn-sm">
                        <i class="fas fa-file-pdf"></i> Export to PDF
                        </button>
                     </form>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="basic-datatables" class="table table-striped custom-table" >
                     <thead>
                        <tr>
                           <th>Sl.No.</th>
                           <th>Employee Name</th>
                           <th>Department</th>
                           <th>Designation</th>
                           <th>Reporting Othority</th>
                           <th>Address</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($employeeList  as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->emp_fname }} {{ $employee->emp_mname }} {{ $employee->emp_lname }}</td>
                                <td>{{ $employee->emp_department }}</td>
                                <td>{{ $employee->emp_designation }}</td>
                                <td>{{ $employee->emp_reporting_auth }}</td>
                                <td>{{ $employee->emp_reporting_auth }}</td>
                                <td>
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if ($employee->verify_status == 'approved')
                                                <i class="fa-regular fa-circle-dot text-success"></i> Active
                                            @else
                                                <i class="fa-regular fa-circle-dot text-danger"></i> Inactive
                                            @endif
                                        </a>
                                        {{-- <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-success"></i> Active</a>
                                            <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-danger"></i> Inactive</a>
                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
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
@endsection