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
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/favicon.png') }}"> --}}
		
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
                                <h3 class="text-uppercase" style="text-align: justify;">Skilled Workers Cloud Ltd.</h3>
                                <ul class="list-unstyled">
                                    <li style="text-align: justify;"><span>G21,Unit 3,Triangle Centre</span></li>
                                    <li style="text-align: justify;"><span>399,Uxbridge Road</span></li>
                                    <li style="text-align: justify;"><span>UB1 3EJ,United Kingdom</span></li>
                                    <li style="text-align: justify;">Mobile: <span>07467284718</span></li>
                                    <li style="text-align: justify;">Email: <span>info@skilledworkerscloud.co.uk</span></li>
                                    <li style="text-align: justify;">Website: <span><a href="https://skilledworkerscloud.co.uk/">https://skilledworkerscloud.co.uk/</a></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                            <h5>Invoice To: {{ strtoupper($com_name) }}</h5>
                            <ul class="list-unstyled">
                                <li><span>{{ strtoupper($f_name) }} {{ strtoupper($l_name) }}</span></li>
                                <li>{{strtoupper($address)}}</li>
                                <li>{{strtoupper($city)}}</li>
                                <li>{{ strtoupper("$road $zip") }}</li>
                                <li>{{strtoupper($p_no)}}</li>
                                <li><a href="#">{{$email}}</a></li>
                              
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                            <span class="text-muted">Invoice No: {{$invoice_no}}</span>
                            <ul class="list-unstyled invoice-payment-details">
                                <li>Invoice Date: <span>{{ isset($invoice_date) ? \Carbon\Carbon::parse($invoice_date)->format('d/m/Y') : 'NA' }}</span></li> 
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="d-none d-sm-table-cell">Item Name</th>
                                    <th >Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Unit Price Excluding VAT</th>
                                    <th>Discount</th>
                                    <th class="text-end">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell">{{$item}}</td>
                                    <td></td>
                                    {{-- <td>@php $perEmployee_charge = $bill->amount/$bill->total_employee; echo $perEmployee_charge; @endphp</td> --}}
                                    <td></td>
                                    <td>{{$amount}}</td>
                                    <td>{{ $discount_amount ?? '0.00' }}</td>
                                    {{-- <td class="text-end">{{$bill->total_amount}}</td> --}}
                                    <td class="text-end">
                                        @php
                                            $subtotal = $discount_amount ? ($amount - $discount_amount) : $amount;
                                            echo number_format($subtotal, 2);
                                        @endphp
                                    </td>
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
                                                    <td class="text-center">{{$payment_mode}}</td>
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
                                            @php
                                                $vat_amount = $vat ? ($subtotal * $vat / 100) : 0;
                                                $grand_total = $total_amount ?: ($subtotal + $vat_amount);
                                            @endphp
                                            <tbody>
                                                @if($vat)
                                                <tr>
                                                    <th>Vat ({{$vat}} %):</th>
                                                    <td></td>
                                                    <td class="text-end">
                                                        {{ number_format($vat_amount, 2) }}  
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <th>Subtotal:</th>
                                                    <td></td>
                                                    <td class="text-end">
                                                        {{ number_format($subtotal, 2) }}
                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    <th>Total Paid:</th>
                                                    <td></td>
                                                    <td class="text-end text-primary">
                                                        <h5>
                                                            {{ number_format($grand_total, 2) }}
                                                        </h5>
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <th>Due: <span class="text-regular"></span></th>
                                                    <td></td>
                                                    <td class="text-end"> {{ $bill->payment_status == 0 ? 'Due' : 'Paid' }}</td>
                                                </tr> --}}
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
