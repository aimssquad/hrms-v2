@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Level 1 User'))

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> {{\App\Helpers\Helper::cachedTrans("Level 1 User")}}
                    <span class="dual-lang-sub notranslate">
                        Level 1 User
                    </span>
                </h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans("Dashboard")}}
                            <span class="dual-lang-sub notranslate">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans("Level 1 User")}}
                        <span class="dual-lang-sub notranslate">
                            Level 1 User
                        </span>
                    </li>
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
                    <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;{{\App\Helpers\Helper::cachedTrans("Level 1 User")}}
                    <span class="dual-lang-sub notranslate">
                        Level 1 User
                    </span>
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
                            <button type="submit" class="btn-download btn-download-excel me-0">
                                {{\App\Helpers\Helper::cachedTrans("Export to Excel")}} 
                                <span class="dual-lang-sub notranslate">
                                    Export to Excel
                                </span>
                            </button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                          @csrf
                          <input type="hidden" name="data" id="pdfData">
                          <input type="hidden" name="headings" id="pdfHeadings">
                          <input type="hidden" name="filename" id="pdfFilename">
                          <button type="submit" class="btn-download btn-download-pdf">
                               {{\App\Helpers\Helper::cachedTrans("Export to PDF")}} 
                                <span class="dual-lang-sub notranslate">
                                    Export to PDF
                                </span>
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
                            <th>{{\App\Helpers\Helper::cachedTrans("Sl No.")}} 
                                <span class="dual-lang-sub notranslate">
                                    Sl No.
                                </span>
                            </th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Name")}} 
                                <span class="dual-lang-sub notranslate">
                                    Name
                                </span>
                            </th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Designation")}} 
                                <span class="dual-lang-sub notranslate">
                                    Designation
                                </span>
                            </th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Phone No")}} 
                                <span class="dual-lang-sub notranslate">
                                    Phone No.
                                </span>
                            </th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Email Id")}} 
                                <span class="dual-lang-sub notranslate">
                                    Email Id
                                </span>
                            </th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Do you have a history of Criminal conviction/Bankruptcy?")}} 
                                <span class="dual-lang-sub notranslate">
                                    Do you have a history of Criminal conviction/Bankruptcy?
                                </span>
                            </th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Proof Of Id")}} 
                                <span class="dual-lang-sub notranslate">
                                    Proof Of Id
                                </span>
                            </th>
                          </tr>
                       </thead>
                       <tbody> 
                            @if ($Roledata->level_f_name!='')								
                                <tr>
                                    <td>1</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->level_f_name) }} {{ \App\Helpers\Helper::cachedTrans($Roledata->level_f_lname) }}</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->level_designation) }}</td>
                                    <td>{{ $Roledata->level_phone }}</td>
                                    <td>{{ $Roledata->level_email }}</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->level_bank_status) }} 	@if ($Roledata->level_bank_status=='Yes')	 ( {{ $Roledata->level_bank_other }} ) 	@endif	</td>
                                    <td>
                                        @if (!empty($Roledata->level_proof))
                                            <a href="{{ asset('storage/app/public/' . $Roledata->level_proof) }}" target="_blank">
                                                <img src="{{ asset('storage/app/public/' . $Roledata->level_proof) }}" height="50px" width="50px"/>
                                            </a>
                                        @else
                                            {{\App\Helpers\Helper::cachedTrans("No Proof Available")}} 
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






