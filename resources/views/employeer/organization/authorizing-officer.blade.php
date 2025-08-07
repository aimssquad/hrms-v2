@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Authorizing Officer') )

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> {{\App\Helpers\Helper::cachedTrans('Authorizing Officer')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Authorizing Officer')}} Dashboard</a></li>
                    <li class="breadcrumb-item active"> {{\App\Helpers\Helper::cachedTrans('Authorizing Officer')}} Authorizing Officer </li>
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
                    <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Authorizing Officer')}}  
                </h4>
                <div class="row">
                    <div class="col-auto">
                        <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                            @csrf
                            <input type="hidden" name="data" id="data">
                            <input type="hidden" name="headings" id="headings">
                            <input type="hidden" name="filename" id="filename">
                            {{-- put the value - that is your file name --}}
                            <input type="hidden" id="filenameInput" value="Authorize-officer">
                            <button type="submit" class="btn-download btn-download-excel me-0">
                                {{\App\Helpers\Helper::cachedTrans('Export to Excel')}} 
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
                              {{\App\Helpers\Helper::cachedTrans('Export to PDF')}} 
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
                            <th>{{\App\Helpers\Helper::cachedTrans('Sl No')}}.</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Name')}} </th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Designation')}}  </th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Phone No')}} </th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Email Id')}} </th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Do you have a history of Criminal conviction/Bankruptcy?')}} </th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Proof Of Id')}} </th>
                          </tr>
                       </thead>
                       <tbody>
                           
                            @if ($Roledata->f_name!='')								
                                <tr>
                                    <td>1</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->f_name) }} {{ \App\Helpers\Helper::cachedTrans($Roledata->l_name) }}</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->desig) }}</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->con_num) }}</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->authemail) }}</td>
                                    <td>{{ \App\Helpers\Helper::cachedTrans($Roledata->bank_status) }} @if($Roledata->bank_status=='Yes')( {{ $Roledata->bank_other }} )@endif</td>
                                    <td>	
                                        @if ($Roledata->proof!='')	
                                        <a href="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}" target="_blank">	<img src="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}" height="50px" width="50px"/></a>
                                        @else
                                        <P>No Proof Id</p>
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






