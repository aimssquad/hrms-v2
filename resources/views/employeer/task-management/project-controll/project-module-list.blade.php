@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Module List'))

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Project Module List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Project Module List')}}</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_role">
                        <i class="fa-solid fa-plus"></i> Add Project Module
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
                            <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Project Module List
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
                                        <th>{{\App\Helpers\Helper::cachedTrans('Module Name')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Module Description')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Comment')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Created By')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Order By')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modules as $module)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                         
                                            <td>{{ucwords($module->module_name)}}</td>
                                            <td>{{ $module->description }}</td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="viewCommentBtn"
                                                    data-module="{{ $module->id }}"
                                                    data-name="{{ $module->module_name }}">
                                                    <i class="fa fa-comments"></i>
                                                    Comments
                                                </a>
                                            </td>
                                            @php
                                                if($module->created_by){
                                                    $creator = DB::table('users')->where('employee_id', $module->created_by)->first();
                                                    $module->created_by = $creator ? $creator->name : 'Unknown';
                                                } else {
                                                    $module->created_by = 'Unknown';
                                                }
                                            @endphp
                                            <td>{{ $module->created_by }}</td>
                                            <td>{{ $module->order_by }}</td>
                                            <td>
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="material-icons">more_vert</i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item editModuleBtn"
                                                            data-id="{{ encrypt($module->id) }}"
                                                            data-name="{{ $module->module_name }}"
                                                            data-description="{{ $module->description }}"
                                                            data-order="{{ $module->order_by }}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>

                                                        {{-- <a class="dropdown-item" href="{{ url('org-project-control/'.request()->route('id').'/project-module-edit/'.encrypt($module->id)) }}">
                                                            <i class="fa-solid fa-comment m-r-5"></i> Comment
                                                        </a> --}}

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item commentBtn"
                                                            data-module="{{ $module->id }}"
                                                            data-module-name="{{ $module->module_name }}">
                                                            <i class="fa-solid fa-comment m-r-5"></i> Add Comment
                                                        </a>

                                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{url('org-project-control/'.request()->route('id').'/project-module-delete/'.encrypt($module->id))}}">
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
    <!-------- Add modal--------->
    <div id="add_role" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                
                <form action="{{ url('org-project-control/'.request()->route('id').'/project-module/store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Add Project Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Module Name</label>
                                <input type="text" name="module_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Module Description</label>
                                <textarea 
                                    name="description" 
                                    class="form-control" 
                                    rows="5" 
                                    placeholder="Enter module description"
                                    required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Module Order</label>
                                <input type="number" name="order_by" class="form-control" required>
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
    <!-- Edit Modal -->
    <div id="edit_module_modal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <form id="editModuleForm" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Project Module</h5>
                        <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Module Name</label>
                            <input type="text"
                                name="module_name"
                                id="edit_module_name"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea
                                name="description"
                                id="edit_description"
                                class="form-control"
                                rows="5"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Module Order</label>
                            <input type="number"
                                name="order_by"
                                id="edit_order_by"
                                class="form-control"
                                required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!----------Comment Modal ---------->
    {{-- <div id="commentModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form id="commentForm" method="POST"
                    action="{{ url('org-project-control/'.request()->route('id').'/module-comment/store') }}">
                    @csrf

                    <input type="hidden" name="commentable_id" id="comment_module_id">
                    <input type="hidden" name="commentable_type" value="module">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Add Comment -
                            <span id="moduleTitle"></span>
                        </h5>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Comment</label>
                            <textarea
                            name="message"
                            rows="5"
                            class="form-control"
                            required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status"
                                class="form-control">
                                <option value="open">Open</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            Submit Comment
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="viewCommentModal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
        <h5>
        Module Discussion :
        <span id="commentModuleTitle"></span>
        </h5>

        <button class="btn-close"
        data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

        <input type="hidden"
        id="project_id"
        value="{{ decrypt(request()->route('id')) }}">

        <input type="hidden"
        id="modal_module_id">

        <div id="commentList"
        style="
        max-height:450px;
        overflow-y:auto;">
        </div>

        <hr>

        <div class="mb-2">
        <textarea
        id="quick_comment"
        class="form-control"
        rows="3"
        placeholder="Write comment"></textarea>
        </div>

        <button
        type="button"
        id="saveCommentBtn"
        class="btn btn-primary">
        Post Comment
        </button>

        </div>

        </div>
        </div>
    </div>

    <! --------Edit Comment Modal ---------->

    <div class="modal fade"
        id="editCommentModal">

        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <h5>Edit Comment</h5>

        <button class="btn-close"
        data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

        <input type="hidden"
        id="edit_comment_id">

        <textarea
        id="edit_comment_text"
        class="form-control"
        rows="5"></textarea>

        </div>

        <div class="modal-footer">
        <button
        type="button"
        id="updateCommentBtn"
        class="btn btn-primary">
        Update
        </button>
        </div>

        </div>
        </div>
    </div>

    <!-------- End add member modal--------->
@endsection
@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>

    <script>
        $(document).on('click','.editModuleBtn',function(){

            let moduleId = $(this).data('id');
            let name = $(this).data('name');
            let description = $(this).data('description');
            let order = $(this).data('order');

            $('#edit_module_name').val(name);
            $('#edit_description').val(description);
            $('#edit_order_by').val(order);

            let actionUrl =
            "{{ url('org-project-control/'.request()->route('id').'/project-module-update') }}/"
            + moduleId;

            $('#editModuleForm').attr('action',actionUrl);

            $('#edit_module_modal').modal('show');
        });
    </script>
    //Comment Modal Script
    {{-- <script>
        $(document).on('click','.commentBtn',function(){

        let moduleId=$(this).data('module');
        let moduleName=$(this).data('module-name');

        $('#comment_module_id').val(moduleId);
        $('#moduleTitle').text(moduleName);

        $('#commentModal').modal('show');

        });
    </script> --}}

    <script>

        function loadComments(moduleId){

        $.get('/module-comments/'+moduleId,function(data){

        let html='';

        if(data.length==0){
        html='<p>No comments yet</p>';
        }

        $.each(data,function(i,row){

        let edited=
        row.edited_at
        ? '<small>(edited)</small>'
        : '';

        html+=`

        <div class="border rounded p-3 mb-3"
        id="comment_${row.id}">

        <div class="d-flex justify-content-between">

        <div>
        <strong>${row.name}</strong>
        ${edited}
        </div>

        <div class="dropdown">
        <a href="#"
        data-bs-toggle="dropdown">
        <i class="fa fa-ellipsis-v"></i>
        </a>

        <div class="dropdown-menu">

        ${
        row.user_id ==
        '{{ Session::get("emid") }}'
        ?

        `
        <a href="javascript:void(0)"
        class="dropdown-item editCommentBtn"
        data-id="${row.id}"
        data-message="${row.message}">
        Edit
        </a>

        <a href="javascript:void(0)"
        class="dropdown-item deleteCommentBtn"
        data-id="${row.id}">
        Delete
        </a>
        `

        :''
        }

        </div>
        </div>

        </div>

        <p class="mt-2">
        ${row.message}
        </p>

        <small class="text-muted">
        ${row.created_at}
        </small>

        </div>

        `;

        });

        $('#commentList').html(html);

        });

        }



        $(document).on(
        'click',
        '.viewCommentBtn',
        function(){

        let id=$(this).data('module');
        let name=$(this).data('name');

        $('#modal_module_id').val(id);

        $('#commentModuleTitle').text(name);

        loadComments(id);

        $('#viewCommentModal').modal('show');

        });




        $('#saveCommentBtn').click(function(){

        $.post(
        '/module-comments/store',
        {
        _token:'{{csrf_token()}}',
        project_id:
        $('#project_id').val(),

        commentable_id:
        $('#modal_module_id').val(),

        message:
        $('#quick_comment').val()
        },
        function(){

        $('#quick_comment').val('');

        loadComments(
        $('#modal_module_id').val()
        );

        }
        );

        });





        $(document).on(
        'click',
        '.editCommentBtn',
        function(){

        $('#edit_comment_id').val(
        $(this).data('id')
        );

        $('#edit_comment_text').val(
        $(this).data('message')
        );

        $('#editCommentModal').modal('show');

        });





        $('#updateCommentBtn').click(function(){

        let id=
        $('#edit_comment_id').val();

        $.post(
        '/module-comments/update/'+id,
        {
        _token:'{{csrf_token()}}',
        message:
        $('#edit_comment_text').val()
        },
        function(){

        $('#editCommentModal').modal('hide');

        loadComments(
        $('#modal_module_id').val()
        );

        }
        );

        });






        $(document).on(
        'click',
        '.deleteCommentBtn',
        function(){

        if(confirm(
        'Delete comment?'
        )){

        let id=
        $(this).data('id');

        $.post(
        '/module-comments/delete/'+id,
        {
        _token:'{{csrf_token()}}'
        },
        function(){

        $('#comment_'+id).remove();

        }
        );

        }

        });

    </script>
@endsection
