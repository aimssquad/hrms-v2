@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Branch Location') )

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
           <div class="col">
              <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Branch Location')}}</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Branch Location')}} </li>
              </ul>
           </div>
           <div class="col-auto float-end ms-auto">
                <a href="{{url('organization/add-location')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Branch Location')}}</a>
           </div>
        </div>
     </div>
    <!-- /Page Header -->
    @include('employeer.layout.message')
    <div class="row">
        <div class="col-md-12">
           <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="fa fa-map-marker" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;{{\App\Helpers\Helper::cachedTrans('Organization Branch Location')}}
                </h4>
                 <div class="row">
                    <div class="col-auto">
                        <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                            @csrf
                            <input type="hidden" name="data" id="data">
                            <input type="hidden" name="headings" id="headings">
                            <input type="hidden" name="filename" id="filename">
                            {{-- put the value - that is your file name --}}
                            <input type="hidden" id="filenameInput" value="Branch-location">
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
                            <th>{{\App\Helpers\Helper::cachedTrans('Sl No.')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Branch Name')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Attendance Process')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Location')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Latitude')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Longitude')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Office Around')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Status')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                          </tr>
                       </thead>
                       <tbody> 
                            @foreach($branches as $branch)							
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $branch->branch_name }}</td>
                                    <td>{{ $branch->attendance_process }}</td>
                                    <td>{{ $branch->branch_location }}</td>
                                    <td>{{ $branch->latitude }}</td>
                                    <td>{{ $branch->longitude }}</td>
                                    <td>{{ $branch->radius }}</td>
                                    <td>
                                        <span class="badge {{ $branch->status ? 'bg-success' : 'bg-danger' }}">
                                        <a href="{{ url('organization/location-status/' . base64_encode($branch->id)) }}"> {{ $branch->status ? 'Active' : 'Inactive' }} </a>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ url('organization/edit-location/'. base64_encode($branch->id)) }}">
                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                </a>
                                                <a class="dropdown-item" href="{{ url('organization/delete-location/' . base64_encode($branch->id)) }}" onclick="confirmDelete('{{ url('organization/delete-location/' . base64_encode($branch->id)) }}')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                            </div>
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
<!-- /Page Content -->
@endsection






