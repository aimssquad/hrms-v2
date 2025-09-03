
@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Attendance Permission'))

@section('content')

<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Attendance Permission')}}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</li>
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Attendance Permission')}}</li>
				</ul>
			</div>
            @include('employeer.layout.message')
		</div>
	</div>
	<!-- /Page Header -->
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Attendance Permission')}}
                    </h4>
                    <div class="row">
                        <div class="col-auto">
                            <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                @csrf
                                <input type="hidden" name="data" id="data">
                                <input type="hidden" name="headings" id="headings">
                                <input type="hidden" name="filename" id="filename">
                                
                                <input type="hidden" id="filenameInput" value="Permission">
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
                    <form action="" method="POST">
                        @csrf

                        <div class="col-md-4">
                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Attendance Permission')}}</label>
                            <select name="punch_type" class="form-control">
                                <option value="">Select</option>
                                @foreach($punch_type as $type)
                                    <option value="{{ \App\Helpers\Helper::cachedTrans($type->punch_type_name) }}">{{ $type->punch_type_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <br>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered custom-table">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="all_check" class="checkmark">
                                        </th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Employee Name')}}</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Attendance Type')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee as $emp)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="emp_code[]" value="{{ $emp->emp_code }}" id="checkmark" class="emp-checkbox">
                                    </td>
                                    <td>{{ $emp->emp_fname }} {{ $emp->emp_lname }}</td>
                                    <td> 
                                        @if($emp->punch_type)
                                            <span class="badge badge-info">{{ $emp->punch_type }}</span>
                                        @else
                                            <span class="badge badge-warning">{{$emp->default_punch_type}}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                                </tbody>
                            </table>
                        </div>

                        <br>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">{{\App\Helpers\Helper::cachedTrans('Submit')}}</button>
                        </div>
                    </form>      
                </div>
            </div>
		</div>
	</div>
</div>
<!-- /Page Content -->


@endsection

@section('script')
	
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = url;
        }
    }
</script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
    document.getElementById('all_check').addEventListener('change', function () {
        const isChecked = this.checked;
        document.querySelectorAll('.emp-checkbox').forEach(function (checkbox) {
            checkbox.checked = isChecked;
        });
    });
</script>



@endsection
