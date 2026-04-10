@extends('employeer.task-management.project-management.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Member List'))

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Project Member List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Project Member List')}}</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee">
                        <i class="fa-solid fa-plus"></i> Add Project Member
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
                            <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Project Member List
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
                                        {{-- <th>{{\App\Helpers\Helper::cachedTrans('Project Name')}}</th> --}}
                                        <th>{{\App\Helpers\Helper::cachedTrans('Members')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Role')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Task Assign Permission')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $key=>$p)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            {{-- <td>{{$project->title}}</td> --}}
                                            <td>{{$p->fname }} {{$p->mname}} {{$p->lname}}</td>
                                            <td>{{ucwords($p->role)}}</td>
                                            <td>{{ucwords($p->permission)}}</td>
                                            <!-- <td>{{$p->created_at}}</td> -->
                                            <td>
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="material-icons">more_vert</i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        {{-- <a class="dropdown-item" href="{{ url('org-task-management/'.request()->route('id').'/project-members/edit/'.encrypt($p->id)) }}">
                                                            <i class="fa-solid fas fa-pencil m-r-5"></i> Edit
                                                        </a> --}}
                                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{url('org-task-management/'.request()->route('id').'/project-members/'.encrypt($p->id))}}">
                                                            <i class="fa-solid fas fa-trash m-r-5"></i> delete
                                                        </a>
                                                    </div>
                                                </div>    
                                                {{-- <a href="#" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                                <a href="{{url('org-task-management/'.request()->route('id').'/project-members/'.encrypt($p->id))}}" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a> --}}
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
<!-- Add Project Member Modal -->
<div id="add_employee" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <form action="{{ url('org-project-control/'.request()->route('id').'/project-members/store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Project Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Member Type</label>
                            <select name="member_type" id="member_type" class="form-control" required>
                                <option value="">-- Select Member --</option>
                                <option value="employee">Employee</option>
                                <option value="guest">Guest</option>
                            </select>
                        </div>

                        <!-- Member Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Member</label>
                            <select name="user_id" id="member_list" class="form-control" required>
                                {{-- <option value="">-- Select Member --</option> --}}
                            </select>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Member Role in Project</label>
                            <select name="role" class="form-control" required>
                                <option value="">-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="member">Member</option>
                                <option value="team_lead">Team Lead</option>
                                <option value="sales_head">Sales Head</option>
                                <option value="guest">Guest</option>
                            </select>
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
<!-------- End add member modal--------->
@endsection
@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#member_type').on('change', function () {

            let type = $(this).val();

            if (type === '') {
                $('#member_list').html('<option value="">-- Select Member --</option>');
                return;
            }

            $.ajax({
                url: "{{ route('get.members.by.type') }}",
                type: "POST",
                data: {
                    type: type,
                    _token: "{{ csrf_token() }}"
                },

                success: function (res) {

                    let html = '<option value="">-- Select Member --</option>';

                    if (res.status) {

                        $.each(res.data, function (i, row) {

                            // ✅ Employee structure
                            if (res.type === 'employee') {

                                html += `<option value="${row.emp_code}">
                                            ${row.emp_fname} ${row.emp_mname ?? ''} ${row.emp_lname}
                                        </option>`;
                            }

                            // ✅ Guest structure
                            else {

                                html += `<option value="${row.guest_id}">
                                            ${row.name} (${row.company_name})
                                        </option>`;
                            }

                        });

                    } else {
                        html += `<option value="">No members found</option>`;
                    }

                    $('#member_list').html(html);
                }
            });

        });
</script>
@endsection
