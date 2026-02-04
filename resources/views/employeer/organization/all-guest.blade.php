
@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('All Clients'))
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
@php
	function my_simple_crypt( $string, $action = 'encrypt' ) {
		// you may change these values to your own
		$secret_key = 'bopt_saltlake_kolkata_secret_key';
		$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
	
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	
		if( $action == 'encrypt' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	
		return $output;
	}

@endphp

<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('All Clients')}}</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('organization/employee/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Employee Dashboard')}}</a></li>
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('All Clients')}}</li>
				</ul>
			</div>
            <div class="col-auto float-end ms-auto">
                <a href="{{ route('organization.guest.addEdit') }}" class="btn add-btn me-2"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Client')}}</a>
            </div> 
		</div>
	</div>
    @include('employeer.layout.message')
	<!-- /Page Header -->
	<div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('All Clients')}}
                    </h4>   
                    <div class="row">
                       <div class="col-auto">
                           <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                               @csrf
                               <input type="hidden" name="data" id="data">
                               <input type="hidden" name="headings" id="headings">
                               <input type="hidden" name="filename" id="filename">
                               {{-- put the value - that is your file name --}}
                               <input type="hidden" id="filenameInput" value="All-Client">
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
                                    <th>{{\App\Helpers\Helper::cachedTrans('Sl No')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Company Name')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Name')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Client ID')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Designation')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Email')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Phone No')}}</th>
                                     <th>{{\App\Helpers\Helper::cachedTrans('Project Assign')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Status')}}</th>
                                    <th class="text-end no-sort">{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                </tr>
                            </thead>

                            {{-- <tbody>
                                @foreach($guests as $guest)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $guest->company_name }}</td>
                                    <td>{{ $guest->name }}</td>
                                    <td>{{ $guest->guest_id }}</td>
                                    <td>{{ $guest->designation }}</td>
                                    <td>{{ $guest->email}}</td>
                                    <td>{{ $guest->phone }}</td>
                                    <td>
                                        @if($guest->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="{{ route('organization.guest.addEdit', ['id' => my_simple_crypt($guest->id, 'encrypt')]) }}">
                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                </a>

												<a class="dropdown-item" href="{{ route('organization.guest.delete', ['id' => my_simple_crypt($guest->id, 'encrypt')]) }}" onclick="return confirmDelete();"><i class="fa-solid fa-trash-can m-r-5"></i> Delete</a>
                                                @if($guest->status == 1)
                                                <a class="dropdown-item" href="{{ route('organization.guest.project', ['id' => my_simple_crypt($guest->id, 'encrypt')]) }}"><i class="fa-solid fa-plus m-r-5"></i> Add chat group</a>
                                                @endif
											</div>
										</div>
									</td>
                                </tr>
                                @endforeach
                            </tbody> --}}
                            <tbody>
                                @foreach($guests as $guest)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $guest->company_name }}</td>
                                    <td>{{ $guest->name }}</td>
                                    <td>{{ $guest->guest_id }}</td>
                                    <td>{{ $guest->designation }}</td>
                                    <td>{{ $guest->email }}</td>
                                    <td>{{ $guest->phone }}</td>
                                    {{-- <td>
                                        @if($guest->project_title)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>{{ $guest->project_title }}</span>

                                                <a href="{{ route('organization.guest.removeProject', [
                                                    'guest_id' => my_simple_crypt($guest->id, 'encrypt'),
                                                    'project_id' => my_simple_crypt($guest->project_id, 'encrypt')
                                                ]) }}"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Remove this guest from this project?');">
                                                    Remove
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-muted">Not Assigned</span>
                                        @endif
                                    </td> --}}
                                  
                                    {{-- <td>
                                        @if(!empty($guest->project_names))
                                            <span class="badge bg-info">
                                                {{ $guest->project_names }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Not Assigned
                                            </span>
                                        @endif
                                        @if(!empty($guest->project_names))
                                            {{ $guest->project_names }}
                                        @else
                                            <span class="text-muted">Not Assigned</span>
                                        @endif
                                    </td> --}}

                                    <td>
                                        @if(!empty($guest->projects_data))

                                            @php
                                                $projects = explode('||', $guest->projects_data);
                                            @endphp

                                            @foreach($projects as $proj)
                                                @php
                                                    [$projectId, $projectTitle] = explode('::', $proj);
                                                @endphp

                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>{{ $projectTitle }}</span>

                                                    <form method="POST"
                                                        action="{{ route('organization.guest.removeProject') }}"
                                                        onsubmit="return confirm('Remove this guest from this project?');">
                                                        @csrf
                                                        <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                                                        <input type="hidden" name="project_id" value="{{ $projectId }}">

                                                        <button type="submit" class="btn btn-sm ">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                            @endforeach

                                        @else
                                            <span class="text-muted">Not Assigned</span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if($guest->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                href="{{ route('organization.guest.addEdit', ['id' => my_simple_crypt($guest->id, 'encrypt')]) }}">
                                                    <i class="fa-solid fa-pencil"></i> Edit
                                                </a>

                                                <a class="dropdown-item"
                                                href="{{ route('organization.guest.delete', ['id' => my_simple_crypt($guest->id, 'encrypt')]) }}"
                                                onclick="return confirmDelete();">
                                                    <i class="fa-solid fa-trash-can"></i> Delete
                                                </a>

                                                @if($guest->status == 1)
                                                    <a class="dropdown-item"
                                                    href="{{ route('organization.guest.project', ['id' => my_simple_crypt($guest->id, 'encrypt')]) }}">
                                                        <i class="fa-solid fa-plus"></i> Add chat group
                                                    </a>
                                                @endif
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
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this guest?");
    }

    function assignWithProject_chat(){
        return confirm("Are you sure you want to assign this client with Project Chat?");
    }
</script>

@endsection
