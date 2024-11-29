<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />


    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ["{{ asset('assets/css/fonts.min.css')}}"]
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/favicon.png') }}">
		
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/material.css') }}">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
   
</head>

<body>
    <div class="wrapper">

        @include('admin.include.header')
        <!-- Sidebar -->

        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Invoice</h3>
                        {{-- <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ul> --}}
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white">CSV</button>
                            <button class="btn btn-white">PDF</button>
                            <button class="btn btn-white"><i class="fa-solid fa-print fa-lg"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>    
        <!-- /Page Header -->
        
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    <img src="{{ asset('img/logo.png') }}" class="inv-logo" alt="Logo">
                                    <ul class="list-unstyled">
                                        {{-- <li>{{ strtoupper($org_dtl->com_name) }}</li>
                                        <li>{{strtoupper($org_dtl->address2)}}</li> --}}
                                        
                                        {{-- <li>GST No:</li> --}}
                                    </ul>
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Skilled Workers Cloud Ltd.</h3>
                                        <ul class="list-unstyled">
                                            <li><span>{{strtoupper($org_dtl->address2)}}</span></li>
                                            {{-- <li>{{strtoupper($org_dtl->city)}} {{strtoupper($org_dtl->road)}} {{strtoupper($org_dtl->zip)}}</li> --}}
                                            {{-- <li>Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}</span></li> --}} 
                                            <li>Mobile: <span>07467284718</span></li>
                                            <li>Email: <span>info@skilledworkerscloud.co.uk</span></li>
                                            <li>Website: <span><a href="https://skilledworkerscloud.co.uk/">http://www.skilledworkerscloud.co.uk/</a></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                                    <h5>Bill To: {{ strtoupper($org_dtl->com_name) }}</h5>
                                    <br>
                                    <ul class="list-unstyled">
                                        {{-- <li><h5><strong>{{ strtoupper($org_dtl->com_name) }}</strong></h5></li> --}}
                                        <li><span>{{ strtoupper($org_dtl->f_name) }} {{ strtoupper($org_dtl->l_name) }}</span></li>
                                        <li>{{strtoupper($org_dtl->address)}}</li>
                                        <li>{{strtoupper($org_dtl->city)}}</li>
                                        <li>{{strtoupper($org_dtl->road)}} {{strtoupper($org_dtl->zip)}}</li>
                                        <li>{{strtoupper($org_dtl->p_no)}}</li>
                                        <li><a href="#">{{$org_dtl->email}}</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                                    <span class="text-muted">Invoice No: {{$bill->invoice_no}}</span>
                                    <ul class="list-unstyled invoice-payment-details">
                                        <li>Bill Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}</span></li> 
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="d-none d-sm-table-cell">Description</th>
                                            <th >Quantity</th>
                                            <th>Unit Price Excluding VAT</th>
                                            <th>Unit Price</th>
                                            <th>VAT</th>
                                            <th class="text-end">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="d-none d-sm-table-cell">{{$bill->description}}</td>
                                            <td>2</td>
                                            <td>{{$bill->amount}}</td>
                                            <td>@php $perEmployee_charge = $bill->amount/$bill->total_employee; echo $perEmployee_charge; @endphp</td>
                                            <td>{{$bill->vat}}</td>
                                            <td class="text-end">{{$bill->total_amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <div class="row invoice-payment">
                                    <div class="col-sm-7">
                                        <div class="m-b-20">
                                            <div class="table-responsive no-border">
                                                <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Payment Method :</th>
                                                            <td class="text-center">{{$bill->payment_mode}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="m-b-20">
                                            <div class="table-responsive no-border">
                                                <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Subtotal:</th>
                                                            <td></td>
                                                            <td class="text-end">{{$bill->amount}}</td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th>Tax: <span class="text-regular">({{$bill->vat}} %)</span></th>
                                                            <td>{{$bill->vat}}</td>
                                                            <td class="text-end">@php $vat = $bill->total_amount-$bill->amount; echo $vat; @endphp</td>
                                                        </tr> --}}
                                                        <tr>
                                                            <th>Total Paid:</th>
                                                            <td></td>
                                                            <td class="text-end text-primary"><h5>{{$bill->total_amount}}</h5></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Due: <span class="text-regular"></span></th>
                                                            <td></td>
                                                            <td class="text-end"> {{ $bill->payment_status == 0 ? 'Due' : 'Paid' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-info" style="text-align: center; margin-top: 20px;">
                                    {{-- <img src="{{ asset('storage/uploads/1730006517_swch_logo (2).png') }}" 
                                        alt="Logo" 
                                        style="height: 100px; width: auto; display: inline-block;"><span>Copyright 2024 Skilled Workers Cloud Ltd. All Rights Reserved</span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @include('admin.include.footer') --}}
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <!-- Atlantis JS -->
    <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  

</body>

</html>