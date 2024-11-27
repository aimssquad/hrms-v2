@extends('employeer.include.app')

@section('title', 'Level 1 User')

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Level 1 User</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"> Level 1 User </li>
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
                    <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Level 1 User 
                </h4>
                 <div class="row">
                    <div class="col-auto">
                        <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                            @csrf
                            <input type="hidden" name="data" id="data">
                            <input type="hidden" name="headings" id="headings">
                            <input type="hidden" name="filename" id="filename">
                            {{-- put the value - that is your file name --}}
                            <input type="hidden" id="filenameInput" value="Level-1user">
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
                            <th> Name</th>
                            <th>Designation </th>
                            <th>Phone No</th>
                            <th>Email Id</th>
                            <th>Do you have a history of Criminal conviction/Bankruptcy?</th>
                            <th>Proof Of Id</th>
                          </tr>
                       </thead>
                       <tbody> 
                            @if ($Roledata->level_f_name!='')								
                                <tr>
                                    <td>1</td>
                                    <td>{{ $Roledata->level_f_name }} {{ $Roledata->level_f_lname }}</td>
                                    <td>{{ $Roledata->level_designation }}</td>
                                    <td>{{ $Roledata->level_phone }}</td>
                                    <td>{{ $Roledata->level_email }}</td>
                                    <td>{{ $Roledata->level_bank_status }} 	@if ($Roledata->level_bank_status=='Yes')	 ( {{ $Roledata->level_bank_other }} ) 	@endif	</td>
                                    <td>
                                        @if (!empty($Roledata->level_proof))
                                            <a href="{{ asset('storage/app/public/' . $Roledata->level_proof) }}" target="_blank">
                                                <img src="{{ asset('storage/app/public/' . $Roledata->level_proof) }}" height="50px" width="50px"/>
                                            </a>
                                        @else
                                            No Proof Available
                                        @endif
                                    </td>
                                </tr>
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






