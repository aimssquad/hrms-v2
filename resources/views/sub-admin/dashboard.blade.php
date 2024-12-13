@extends('sub-admin.include.app')

@section('title', 'Sub Admin Dashboard')

@section('content')
@php
    $arrrole = Session::get('empsu_role');
    $userType = Session::get('usersu_type');
    $emp_email = Session::get('empsu_email');
    $data = DB::table('sub_admin_registrations')->where('email', $emp_email)->where('status', 'active')->first();
    if ($data) {
        $org_code = $data->org_code;
        
    }
@endphp

    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->  
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Sub Admin Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sub Admin Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget overflow-visible">
                    <a href="#">
                        <div class="card-body modern-card">
                            <div class="dash-widget-info">
                                <span>Total Amount</span>
                                <h3><i class="fa fa-pound-sign"></i> {{$total_amount ?? 0}}</h3>
                            </div>
                            <div class="modern_icon_wrapper">
                                <i class="fa-solid fa-cubes modern-icon"></i>
                            </div>
                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                <span style="font-size: 13px">View</span>
                                <i class="fa-solid fa-arrow-right" style="font-size: 13px"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget overflow-visible">
                    <a href="#">
                        <div class="card-body modern-card">
                            <div class="dash-widget-info">
                                <span>Pending Amount</span>
                                <h3><i class="fa fa-pound-sign"></i> {{$pending_amount ?? 0}}</h3>
                            </div>
                            <div class="modern_icon_wrapper">
                                <i class="fa-solid fa-dollar-sign modern-icon"></i>
                            </div>
                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                <span style="font-size: 13px;">View</span>
                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget overflow-visible">
                    <a href="#">
                        <div class="card-body modern-card">
                            <div class="dash-widget-info">
                                <span>Received Amount</span>
                                <h3><i class="fa fa-pound-sign"></i> {{$receving_amount ?? 0}}</h3>
                            </div>
                            <div class="modern_icon_wrapper">
                                <i class="fa-regular fa-gem modern-icon"></i>
                            </div>
                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                <span style="font-size: 13px;">View</span>
                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget overflow-visible">
                    <a href="{{url('billing/list')}}">
                        <div class="card-body modern-card">
                            <div class="dash-widget-info">
                                <span>Monthly Collection</span>
                                <h3>{{$monthly_collection ?? 0}}</h3>
                            </div>
                            <div class="modern_icon_wrapper">
                                <i class="fa-regular fa-gem modern-icon"></i>
                            </div>
                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                <span style="font-size: 13px;">View</span>
                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-12">
                <div class="bg-white p-4 rounded-3">
                    <h3 class="fs-6">Copy URL </h3>
                    <div class="row">
                        @if($userType == 'sub-admin')
                            <div class="col-12">
                                <div class="url-container">
                                    <div class="url-box">
                                        <i class="fas fa-link"></i>
                                        <span id="registrationUrl">{{ url('register/' . $org_code) }}</span>
                                        <button class="copy-btn" id="copyButton" onclick="copyToClipboard()">
                                        <i class="fas fa-clipboard"></i>
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input type="text" id="tempInput" style="position: absolute; left: -9999px;">
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->
@endsection
@section('script')
    <script>
        function copyToClipboard() {
            var urlText = document.getElementById('registrationUrl').innerText;
            var tempInput = document.getElementById('tempInput');
            tempInput.value = urlText;
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); 
            document.execCommand('copy');

            var copyButton = document.getElementById('copyButton');
            copyButton.classList.remove('text-warning');
            copyButton.classList.add('bg-success');

            let copyurl = document.getElementsByClassName('url-box')[0];
            copyurl.classList.add('text-success');
        }


        // function copyToClipboard() {
        //     var copyText = document.getElementById("registrationUrl").innerText;
        //     var tempInput = document.getElementById("tempInput");
        //     tempInput.value = copyText;
        //     tempInput.select();
        //     document.execCommand("copy");
        // }

    </script>
@endsection
