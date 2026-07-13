@extends('employeer.include.app')
@section('title', 'Leave Application list')

@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp

@php
function my_simple_crypt( $string, $action = 'encrypt' ) {
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

@section('css')
<style>
   

    /* --- Navbar (Orange) --- */
    .navbar-custom {
        background: #FF902F !important;
        box-shadow: 0 2px 12px rgba(255, 144, 47, 0.25);
        padding: 0 20px;
        height: 64px;
    }
    .navbar-custom .navbar-brand {
        color: #FFFFFF !important;
        font-weight: 700;
        font-size: 1.1rem;
        text-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .navbar-custom .navbar-brand i {
        margin-right: 10px;
        color: #FFFFFF;
    }
    .navbar-custom .nav-link {
        color: rgba(255,255,255,0.9) !important;
        font-weight: 500;
        padding: 0 16px;
        transition: 0.2s;
        border-radius: 6px;
    }
    .navbar-custom .nav-link:hover {
        color: #FFFFFF !important;
        background: rgba(255,255,255,0.2);
    }
    .navbar-custom .nav-link i {
        color: rgba(255,255,255,0.85);
    }
    .navbar-custom .nav-link:hover i {
        color: #FFFFFF;
    }
    .navbar-custom .dropdown-toggle::after {
        color: rgba(255,255,255,0.8);
    }
    .navbar-custom .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        margin-top: 8px;
        border-top: 3px solid #FF902F;
    }
    .navbar-custom .dropdown-item {
        color: #1A2940;
        padding: 10px 20px;
        font-weight: 500;
        transition: 0.2s;
    }
    .navbar-custom .dropdown-item:hover {
        background: #FFF0E6;
        color: #FF902F;
    }
    .navbar-custom .dropdown-item i {
        color: #FF902F;
        width: 20px;
        margin-right: 8px;
    }
    .navbar-custom .badge-notification {
        background: #d63384;
        color: #FFFFFF;
        font-size: 0.6rem;
        padding: 2px 7px;
        border-radius: 20px;
        position: relative;
        top: -8px;
        right: 4px;
    }
    .navbar-custom .navbar-toggler {
        border-color: rgba(255,255,255,0.3);
    }
    .navbar-custom .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* --- Sidebar (Dark Navy) --- */
    .sidebar {
        background: #1A2940 !important;
    }
    .sidebar .nav-link {
        color: rgba(255,255,255,0.7) !important;
        border-left: 3px solid transparent;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: #FFFFFF !important;
        background: rgba(255, 144, 47, 0.15) !important;
        border-left-color: #FF902F !important;
    }
    .sidebar .nav-link i {
        color: #FF902F;
    }
    .sidebar .nav-link:hover i {
        color: #FF902F;
    }
    .sidebar .brand h3 {
        color: #FFFFFF;
    }
    .sidebar .brand h3 span {
        color: #FF902F;
    }

    /* --- Badge Styles --- */
    .badge-orange {
        background: #FF902F;
        color: #FFFFFF;
        padding: 4px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-pink {
        background: #d63384;
        color: #FFFFFF;
        padding: 4px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-number {
        background: #FF902F;
        color: #FFFFFF;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(255, 144, 47, 0.35);
    }

    /* --- Info Boxes --- */
    .info-box {
        transition: 0.2s ease;
        background: #F5F8FC;
        border-left: 4px solid #FF902F;
        padding: 12px 16px;
        border-radius: 10px;
        height: 100%;
    }
    .info-box:hover {
        background: #FFF0E6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 144, 47, 0.15);
    }
    .info-box .label {
        display: block;
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #7A8BA0;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .info-box .value {
        display: block;
        font-size: 1rem;
        font-weight: 500;
        color: #1A2940;
        margin-top: 2px;
    }

    /* --- Cards --- */
    .custom-card {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #E8ECF0;
        background: #FFFFFF;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .custom-card .card-header {
        background: #FFFFFF;
        border-bottom: 1px solid #F0F2F5;
        padding: 16px 24px;
    }
    .custom-card .card-header h4 {
        color: #1A2940;
        font-weight: 600;
    }

    /* --- Tables --- */
    .table th {
        font-weight: 600;
        border-bottom-width: 2px;
        border-color: #1A2940;
    }
    .table td {
        vertical-align: middle;
    }
    .table-hover tbody tr:hover {
        background-color: #FFF0E6;
    }

    /* --- Form Elements --- */
    .form-select:focus, .form-control:focus {
        border-color: #FF902F;
        box-shadow: 0 0 0 0.25rem rgba(255, 144, 47, 0.25);
    }

    /* --- Buttons --- */
    .btn-primary-custom {
        background: #FF902F;
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.2s ease;
    }
    .btn-primary-custom:hover {
        background: #fd7e14;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 144, 47, 0.35);
    }
    .btn-pink {
        background: #d63384;
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.2s ease;
    }
    .btn-pink:hover {
        background: #c2256e;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(214, 51, 132, 0.35);
    }

    /* --- Breadcrumb --- */
    .breadcrumb-item a {
        color: #FF902F;
        text-decoration: none;
    }
    .breadcrumb-item a:hover {
        color: #fd7e14;
        text-decoration: underline;
    }
    .breadcrumb-item.active {
        color: #1A2940;
        font-weight: 500;
    }

    /* --- Decision Section --- */
    .decision-section {
        background: #F5F8FC;
        border: 1px solid #E8ECF0;
        border-left: 4px solid #FF902F;
    }

    /* --- Status Badge Colors --- */
    .status-approved {
        background: #28A745;
        color: #FFFFFF;
    }
    .status-rejected {
        background: #dc3545;
        color: #FFFFFF;
    }
    .status-pending {
        background: #FF902F;
        color: #FFFFFF;
    }
    .status-cancel {
        background: #dc3545;
        color: #FFFFFF;
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
        .info-box {
            padding: 10px 14px;
        }
        .decision-section .row > div {
            margin-bottom: 10px;
        }
        .decision-section .row > div:last-child {
            margin-bottom: 0;
        }
        .navbar-custom {
            height: auto;
            padding: 10px 16px;
        }
    }

    /* --- Pink Accent for Highlights --- */
    .text-pink {
        color: #d63384;
    }
    .bg-pink-light {
        background: #FFF0F6;
    }
    .border-pink {
        border-color: #d63384 !important;
    }
    .orange-glow {
        box-shadow: 0 0 20px rgba(255, 144, 47, 0.15);
    }
</style>
@endsection

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title" style="color: #1A2940;">
                    Leave Application Details
                </h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('leaveapprover/leave-dashboard') }}">Leave Authorizer Dashboard</a></li>
                    <li class="breadcrumb-item active">Leave Application List</li>
                </ul>
            </div>
            
        </div>
    </div>
    <!-- /Page Header -->

    @include('employeer.layout.message')

    <div class="row">
        <div class="col-md-12">

            <!-- Main Card -->
            <div class="card shadow-sm border-0 custom-card" style="border-left: 4px solid #FF902F;">
                <div class="card-header border-bottom-0 py-3" style="background: #FFFBF7;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-pen-to-square" style="color: #FF902F;"></i>
                        <h4 class="card-title mb-0" style="color: #1A2940; font-weight: 600;">Review & Approve Leave</h4>
                    </div>
                </div>

                <?php
                $reg = Session::get('emid');
                $job_details = DB::table('employee')
                    ->where('emp_code', '=', $LeaveApply[0]->employee_id)
                    ->where('emid', '=', $reg)
                    ->orderBy('id', 'DESC')
                    ->first();
                ?>

                <div class="card-body" style="background: #FFFFFF;">
                    <form action="{{ url('leave-approver/leave-approved-right') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!-- Hidden Fields -->
                        <input type="hidden" name="apply_id" value="{{ $LeaveApply[0]->id }}">
                        <input type="hidden" name="employee_id" value="{{ $LeaveApply[0]->employee_id }}">
                        <input type="hidden" name="no_of_leave" value="{{ $LeaveApply[0]->no_of_leave }}">
                        <input type="hidden" name="leave_type" value="{{ $LeaveApply[0]->leave_type }}">
                        <input type="hidden" name="month_yr" value="{{ date('Y', strtotime($LeaveApply[0]->from_date)) }}">
                        <input type="hidden" id="current_status" value="{{ $LeaveApply[0]->status }}">

                        <!-- Employee & Leave Info Grid -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="label">Employment Type</span>
                                    <span class="value">{{ $job_details->emp_status ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="label">Employee Code</span>
                                    <span class="value">{{ $LeaveApply[0]->employee_id }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="label">Employee Name</span>
                                    <span class="value">{{ $job_details->emp_fname ?? '' }} {{ $job_details->emp_mname ?? '' }} {{ $job_details->emp_lname ?? '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box" style="border-left-color: #d63384;">
                                    <span class="label">Leave Type</span>
                                    <span class="value">{{ $LeaveApply[0]->leave_type_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="label">Leave Status</span>
                                    <span class="value">
                                        <span class="badge p-2 px-3 rounded-pill" style="
                                            @if($LeaveApply[0]->status == 'APPROVED') background: #28A745; color: #fff;
                                            @elseif($LeaveApply[0]->status == 'REJECTED') background: #dc3545; color: #fff;
                                            @elseif($LeaveApply[0]->status == 'CANCEL') background: #dc3545; color: #fff;
                                            @elseif($LeaveApply[0]->status == 'NOT APPROVED') background: #FF902F; color: #fff;
                                            @else background: #7A8BA0; color: #fff;
                                            @endif
                                            font-weight: 600;">
                                            @if($LeaveApply[0]->status == 'APPROVED')
                                                <i class="fas fa-check-circle me-1"></i>
                                            @endif
                                            {{ $LeaveApply[0]->status }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box" style="border-left-color: #d63384;">
                                    <span class="label">No. of Leave Days</span>
                                    <span class="value">
                                        <span class="badge" style="background: #FFF0F6; color: #d63384; font-size: 1rem; padding: 4px 14px;">
                                            {{ $LeaveApply[0]->no_of_leave }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="label">From Date</span>
                                    <span class="value">{{ date('d/m/Y', strtotime($LeaveApply[0]->from_date)) }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="label">To Date</span>
                                    <span class="value">{{ date('d/m/Y', strtotime($LeaveApply[0]->to_date)) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Previous Leave History -->
                        <div class="mt-4 mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="fas fa-clock-rotate-left" style="color: #FF902F;"></i>
                                <h5 class="mb-0" style="color: #1A2940; font-weight: 600;">Previous Approved Leave History</h5>
                                <span class="badge rounded-pill" style="background: #FFF0E6; color: #FF902F;">{{ count($Prev_leave) }}</span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="leave-history-table" style="border-radius: 10px; overflow: hidden;">
                                    <thead style="background: #1A2940; color: #FFFFFF;">
                                        <tr>
                                            <th>#</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Application Date</th>
                                            <th>No. of Days</th>
                                            <th>Approved Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($Prev_leave) > 0)
                                            @foreach($Prev_leave as $lvapply)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($lvapply->from_date)->format('d/m/Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($lvapply->to_date)->format('d/m/Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($lvapply->date_of_apply)->format('d/m/Y') }}</td>
                                                    <td><span class="badge" style="background: #FFF0F6; color: #d63384;">{{ $lvapply->no_of_leave }}</span></td>
                                                    <td>{{ \Carbon\Carbon::parse($lvapply->updated_at)->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-inbox me-2" style="color: #7A8BA0;"></i> No previous approved leave records found.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Leave Request Decision -->
                        <div class="p-4 rounded-3 mt-4 decision-section">
                            <h5 class="mb-3" style="color: #1A2940; font-weight: 600;">
                                <i class="fas fa-check-circle me-2" style="color: #FF902F;"></i> Leave Decision
                            </h5>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="leave_status" class="form-label fw-semibold" style="color: #1A2940; font-weight: 600;">
                                            Request Status <span style="color: #dc3545;">*</span>
                                        </label>
                                        <select id="leave_status" name="leave_check" class="form-select" onchange="remarkStatus();" required style="border-color: #D1D9E6; border-radius: 10px;">
                                            <option value="">Select</option>
                                            <option value="NOT APPROVED" {{ $LeaveApply[0]->status == 'NOT APPROVED' ? 'selected' : '' }}>Not Approved</option>
                                            <option value="APPROVED" {{ $LeaveApply[0]->status == 'APPROVED' ? 'selected' : '' }}>Approved</option>
                                            <option value="REJECTED" {{ $LeaveApply[0]->status == 'REJECTED' ? 'selected' : '' }}>Rejected</option>
                                            <option value="CANCEL" {{ $LeaveApply[0]->status == 'CANCEL' ? 'selected' : '' }}>Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="status_remarks" class="form-label fw-semibold" style="color: #1A2940; font-weight: 600;">Remarks (Optional)</label>
                                        <input id="status_remarks" type="text" name="status_remarks" value="{{ $LeaveApply[0]->status_remarks ?? '' }}" class="form-control" placeholder="Add any additional remarks..." style="border-color: #D1D9E6; border-radius: 10px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn w-100 py-2" type="submit" style="background: #FF902F; color: #FFFFFF; border: none; border-radius: 10px; font-weight: 600; transition: 0.2s;">
                                        <i class="fas fa-paper-plane me-2"></i> Apply
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Pink Action Button -->
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-primary px-4" onclick="window.history.back();">
                                <i class="fas fa-arrow-left me-2"></i> Back to List
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }

    function remarkStatus() {
        const status = document.getElementById('leave_status').value;
        const remarkField = document.getElementById('status_remarks');
        if (status === 'APPROVED' || status === 'REJECTED' || status === 'CANCEL') {
            remarkField.focus();
        }
    }
</script>
@endsection