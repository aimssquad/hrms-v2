@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Permission Master'))

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Project Permission Master</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Project Permission Master')}}</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_role">
                        <i class="fa-solid fa-plus"></i> Add Project Permission
                    </a>
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
                            <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Project Permission List
                        </h4>
                        <div class="row">
                            <div class="col-auto">
                                <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="data" id="data">
                                    <input type="hidden" name="headings" id="headings">
                                    <input type="hidden" name="filename" id="filename">
                                    {{-- put the value - that is your file name --}}
                                    <input type="hidden" id="filenameInput" value="Hired">
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
                            <table class="table table-striped custom-table" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Sl No.')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Permission Name')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                         
                                            <td>{{ ucwords(str_replace('_', ' ', $permission->name)) }}</td>
                                            <td>
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="material-icons">more_vert</i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" 
                                                        class="dropdown-item editBtn"
                                                        data-id="{{ $permission->id }}"
                                                        data-name="{{ $permission->name }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit_role">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{url('org-project-control/'.request()->route('id').'/project-role-edit/'.$permission->id)}}">
                                                            <i class="fa-solid fas fa-trash m-r-5"></i> delete
                                                        </a>
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
    <!-------- Add member modal--------->
    <div id="add_role" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                
                <form action="{{ url('org-project-control/'.request()->route('id').'/permission-master') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Add Project Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Permission Name</label>
                                <input type="text" name="role_name" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
<!-- Add Project Member Modal -->
    <div id="edit_role" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <form id="editForm" method="POST">
                    @csrf
                    @method('POST')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Project permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Permission Name</label>
                            <input type="text" name="role_name" id="edit_role_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

<!-------- End add member modal--------->
@endsection
@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>

    <script id="edit-modal-script">
        $(document).on('click', '.editBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');

            // convert "member_assign" → "Member Assign"
            let formattedName = name.replaceAll('_', ' ')
                                    .replace(/\b\w/g, l => l.toUpperCase());

            $('#edit_role_name').val(formattedName);

            // set dynamic action URL
            let actionUrl = "{{ url('org-project-control/'.request()->route('id').'/project-role-update') }}/" + id;

            $('#editForm').attr('action', actionUrl);
        });
        </script>
@endsection
