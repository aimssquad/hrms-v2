@extends('employeer.include.app')

@section('title', 'Employees (RTI)')

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Employees (RTI)</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employees (RTI)</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">
           <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Employees (RTI)
                </h4>
                <div class="row">
                    <div class="col-auto">
                        <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                            @csrf
                            <input type="hidden" name="data" id="data">
                            <input type="hidden" name="headings" id="headings">
                            <input type="hidden" name="filename" id="filename">
                            {{-- put the value - that is your file name --}}
                            <input type="hidden" id="filenameInput" value="Employee-rtilink">
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
                    <table id="basic-datatables" class="display table table-striped table-hover">
                       <thead>
                          <tr>
                             <th>Sl No.</th>
                             <th>Employee Name</th>
                             <th>Department</th>
                             <th>Job Type</th>
                             <th>Job Title</th>
                             <th>Immigration Status</th>
                          </tr>
                       </thead>
                       <tbody>
                            @php
                                $employee_or_rs = DB::table('company_employee')->where('emid','=',$companies_rs->reg)->get();
                                $countwmploor= count($employee_or_rs);
                            @endphp
                            @if ($countwmploor!=0)
                                @foreach($employee_or_rs as $empuprotgans)
                                    @if ($empuprotgans->name!='')								
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $empuprotgans->name }}</td>
                                            <td>{{ $empuprotgans->department }}</td>
                                            <td>{{ $empuprotgans->job_type }}</td>
                                            <td>{{ $empuprotgans->designation }}</td>
                                            <td>{{ $empuprotgans->immigration }}</td>
                                            <!--<td class="text-end">-->
                                            <!--    <div class="dropdown dropdown-action">-->
                                            <!--        <a aria-expanded="false" data-bs-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>-->
                                            <!--        <div class="dropdown-menu dropdown-menu-right">-->
                                            <!--            <a href="#" class="dropdown-item"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>-->
                                            <!--            <a href="#" class="dropdown-item"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</td>-->
                                        </tr>
                                    @endif
                                @endforeach   
                            @endif
                       </tbody>
                    </table>
                 </div>
              </div>
           </div>
        </div>
     </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
<!--script Content-->
<script>

    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
     
 </script>
<!--/script Content-->
@endsection


