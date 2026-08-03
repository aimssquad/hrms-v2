@extends('employeer.task-management.project-controll.app')

@section('title', 'Project ' . ucfirst($workItem) . ' List')

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Project {{ ucfirst($workItem) }} List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/projects')}}">{{\App\Helpers\Helper::cachedTrans('All Project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="{{url('org-task-management/project-analitic-dashboard/'.request()->route('id'))}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">Project {{ ucfirst($workItem) }} List</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                        <a href="{{ route('work-item.create', [
                                'id' => request()->route('id'),
                                'workItem' => $workItem
                            ]) }}"
                           class="btn add-btn">
                            <i class="fa-solid fa-plus"></i>
                            Add {{ ucfirst($workItem) }}
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
                            <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Project {{ ucfirst($workItem) }} List
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
                                        <th>{{\App\Helpers\Helper::cachedTrans('Unique Id.')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans(ucfirst($workItem). ' Name')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans(ucfirst($workItem). ' Description')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('File')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Start Date')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('End Date')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Remainder Email')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Created By')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Priority')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Status')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Chat')}} <i class="fa-solid fa-chat m-r-5"></i></th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workItems as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
        
                                            <td>
                                                {{ $item->unique_id }}
                                            </td>
                                            
                                            <td>
                                                {{ $item->title }}
                                            </td>
                                            
                                            <td>
                                                 {{ Str::limit(html_entity_decode(strip_tags($item->description))) }}
                                            </td>
                                            
                                            <td>
                                                @if($item->image)
                                            
                                                    @php
                                                        $extension = strtolower(pathinfo($item->image, PATHINFO_EXTENSION));
                                            
                                                        $imageExtensions = [
                                                            'jpg',
                                                            'jpeg',
                                                            'png',
                                                            'gif',
                                                            'webp'
                                                        ];
                                                    @endphp
                                            
                                                    @if(in_array($extension, $imageExtensions))
                                            
                                                        <a href="{{ asset('storage/app/public/'.$item->image) }}"
                                                           target="_blank">
                                                            <img src="{{ asset('storage/app/public/'.$item->image) }}"
                                                                 width="50"
                                                                 height="50"
                                                                 class="rounded">
                                                        </a>
                                            
                                                    @elseif($extension == 'pdf')
                                            
                                                        <a href="{{ asset('storage/app/public/'.$item->image) }}"
                                                           target="_blank"
                                                           class="btn btn-danger btn-sm">
                                                            <i class="fa fa-file-pdf"></i> PDF
                                                        </a>
                                            
                                                    @elseif(in_array($extension, ['doc','docx']))
                                            
                                                        <a href="{{ asset('storage/app/public/'.$item->image) }}"
                                                           target="_blank"
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fa fa-file-word"></i> DOC
                                                        </a>
                                            
                                                    @elseif(in_array($extension, ['xls','xlsx']))
                                            
                                                        <a href="{{ asset('storage/app/public/'.$item->image) }}"
                                                           target="_blank"
                                                           class="btn btn-success btn-sm">
                                                            <i class="fa fa-file-excel"></i> Excel
                                                        </a>
                                            
                                                    @else
                                            
                                                        <a href="{{ asset('storage/app/public/'.$item->image) }}"
                                                           target="_blank"
                                                           class="btn btn-secondary btn-sm">
                                                            Download
                                                        </a>
                                            
                                                    @endif
                                            
                                                @else
                                            
                                                    <span class="text-muted">No File</span>
                                            
                                                @endif
                                            </td>
                                            
                                            <td>
                                                {{ $item->start_date ? date('d M Y', strtotime($item->start_date)) : '-' }}
                                            </td>
                                            
                                            <td>
                                                {{ $item->end_date ? date('d M Y', strtotime($item->end_date)) : '-' }}
                                            </td>

                                            <td>
                                                {{-- <a href="{{ url('org-project-control/'.request()->route('id').'/project-module-comment/'.encrypt($item->id)) }}"
                                                   class="btn btn-info btn-sm"> --}}
                                                <a href="#"
                                                   class="btn btn-info btn-sm">   
                                                    <i class="fa-solid fa-paper-plane m-r-5"></i> Send Mail
                                                </a>
                                            </td>    
                                            
                                            <td>
                                                @php
                                                    $user = DB::table('users')
                                                        ->where('employee_id', $item->created_by)
                                                        ->when($item->emid, function ($query) use ($item) {
                                                            return $query->where('emid', $item->emid);
                                                        })
                                                        ->first();
                                                @endphp
                                            
                                                {{ $user->name ?? 'Organization' }}
                                            </td>
                                            
                                            <td>
                                                @if($item->priority == 'High')
                                                    <span class="badge bg-danger">High</span>
                                                @elseif($item->priority == 'Medium')
                                                    <span class="badge bg-warning">Medium</span>
                                                @else
                                                    <span class="badge bg-success">Low</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($item->status == 'open')
                                                    <span class="badge bg-success">Open</span>
                                                @elseif($item->status == 'close')
                                                    <span class="badge bg-warning">Closed</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ url('org-project-control/'.request()->route('id').'/project-module-comment/'.encrypt($item->id)) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-comment m-r-5"></i> Comment
                                                </a>
                                            </td>    

                                            <td>
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="material-icons">more_vert</i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ url('org-project-control/'.request()->route('id').'/project-module-comment/'.encrypt($item->id)) }}">
                                                            <i class="fa-solid fa-comment m-r-5"></i> Comment
                                                        </a>

                                                        <a class="dropdown-item" href="{{ url('org-project-control/'.request()->route('id').'/remainder-mail/'.encrypt($item->id)) }}">
                                                            <i class="fa-solid fa-cog m-r-5"></i> Remainder Mail Setting
                                                        </a>
                                                        
                                                        <a class="dropdown-item" href="{{ url('org-project-control/'.request()->route('id').'/project-module-role-assign/'.encrypt($item->id)) }}">
                                                            <i class="fas fa-user-check m-r-5"></i> Assign {{ ucfirst($workItem) }}
                                                        </a>

                                                        {{-- <a class="dropdown-item" href="{{ url('org-project-control/'.request()->route('id').'/project-module-assign/'.encrypt($item->id)) }}">
                                                            <i class="fas fa-layer-group m-r-5"></i> Assign {{ ucfirst($workItem) }}
                                                        </a> --}}

                                                        <a class="dropdown-item" href="{{ url('org-project-control/'.request()->route('id').'/project-module-edit/'.encrypt($item->id)) }}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>

                                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{url('org-project-control/'.request()->route('id').'/project-module-delete/'.encrypt($item->id))}}">
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
   
@endsection
@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>
@endsection
