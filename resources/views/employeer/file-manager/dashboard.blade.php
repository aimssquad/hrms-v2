@extends('employeer.include.app')

@section('title', 'File Manager Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">File Manager Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">File Manager Dashboard</li>
                    </ul>
                </div>
                {{-- <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Job Applied</a>
                </div> --}}
            </div>
        </div>
        <!-- /Page Header -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                       

                        <div class="row">

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">File Devision</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $file_devision_count ?? 0 }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('file-management/file-devision-list') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">File Manager</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $file_manager_count ?? 0 }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('file-management/fileManagmentList') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;File Manager List
                        </h4>
                        <div class="row">
                           <div class="col-auto">
                               <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                   @csrf
                                   <input type="hidden" name="data" id="data">
                                   <input type="hidden" name="headings" id="headings">
                                   <input type="hidden" name="filename" id="filename">
                                   {{-- put the value - that is your file name --}}
                                   <input type="hidden" id="filenameInput" value="File-Manager-List">
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
                                        <th>Sl.No.</th>
                                        <th>File Name</th>
                                        <th>Organization Id</th>
                                        <th>Status</th>
                                      
                                    </tr>
                                </thead>
    
                                <tbody>
                                    @foreach($file_details as $item)
    
                                  <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->file_name}}</td>
                                    <td>{{$item->organization_id}}</td>
                                    <td>{{$item->status}}</td>
                                  
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
