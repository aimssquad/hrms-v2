@extends('employeer.include.app')
@section('title', 'Add Employee')
@section('css')
<style>
   .tab, .tab2, .tab3, .tab4, .tab5, .tab6, .tab7, .tab8 {
     display: none;
   }
   .active {
     display: block;
   }
  
   .btn:disabled {
     background-color: #dcdcdc;
     cursor: not-allowed;
   }
   #basicform {
    height: auto !important; 
   }
 </style>
@endsection
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
       <div class="col">
            <h3 class="page-title">Sync Bulk Employee</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
    			<li class="breadcrumb-item"><a href="{{url('organization/employee/employerdashboard')}}">Employee Dashboard</a></li>
    			<li class="breadcrumb-item active">Sync Bulk Employee</li>
            </ul>
        </div>
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title"><i class="far fa-user"></i>Sync Bulk Employees</h4>
            </div>
            <div class="card-body">
                  <div class="row">
                     {{-- <div class="col-12 col-lg-12 m-auto">
                         @include('employeer.layout.message')
                        <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data">
                           @csrf

                           <div class="form-group">
                              <label for="emid" class="col-form-label">Organization name</label>
                              <input type="text" name="organization_name" id="organization_name" 
                                    value="{{ $organizationDtl->com_name }}" class="form-control" required readonly>

                              <input type="text" name="emid" id="emid" 
                                    value="{{ $organizationDtl->reg }}" required hidden>
                     
                           </div>

                           <div class="form-group">
                              <label for="csv_file" class="col-form-label">CSV File</label>
                              <div class="custom-file">
                                 <input type="file" name="csv_file" id="csv_file"
                                          class="form-control input-border-bottom @error('csv_file') is-invalid @enderror" 
                                          accept=".csv" required>
                               
                                 @error('csv_file')
                                       <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                       </span>
                                 @enderror
                              </div>
                           </div>
                           <br>
                           <div class="form-group mb-0">
                              <button type="submit" class="btn btn-primary">
                                 <i class="fas fa-upload mr-2"></i> Import Data
                              </button>
                              <a href="{{ asset('bulk-employee-csv/bulk_employee_entry.csv') }}" class="btn btn-link">
                                 <i class="fas fa-download mr-1"></i> Download Sample CSV
                              </a>
                           </div>
                        </form>
                     </div> --}}

                     <div class="col-12 col-lg-12 m-auto">
                        @include('employeer.layout.message')

                        <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data">
                           @csrf

                           <div class="form-row"> <!-- Bootstrap row for horizontal layout -->
                                 <!-- Organization Name -->
                                 <div class="form-group col-md-6">
                                    <label for="organization_name" class="col-form-label">Organization Name</label>
                                    <input type="text" name="organization_name" id="organization_name"
                                          value="{{ $organizationDtl->com_name }}" class="form-control" required readonly>
                                    <input type="hidden" name="emid" id="emid" value="{{ $organizationDtl->reg }}">
                                 </div>

                                 <!-- CSV Upload -->
                                 <div class="form-group col-md-6">
                                    <label for="csv_file" class="col-form-label">CSV File</label>
                                    <input type="file" name="csv_file" id="csv_file"
                                          class="form-control @error('csv_file') is-invalid @enderror"
                                          accept=".csv" required>

                                    @error('csv_file')
                                       <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                       </span>
                                    @enderror
                                 </div>
                           </div>

                           <div class="form-group mt-3">
                                 <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload mr-2"></i> Import Data
                                 </button>
                                 <a href="{{ asset('bulk-employee-csv/bulk_employee_entry.csv') }}" class="btn btn-link">
                                    <i class="fas fa-download mr-1"></i> Download Sample CSV
                                 </a>
                           </div>
                        </form>
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')

@endsection