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

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
    <style>
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    </style>
</head>

<body>
    <div class="wrapper">

        @include('admin.include.header')
        <!-- Sidebar -->

        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">

            </div>
            <div class="content">
                <div class="page-inner">
                    <div class="row">
                       <div class="col-md-12">
                          <div class="card custom-card">
                             <div class="card-header">
                                <h4 class="card-title"><i class="far fa-newspaper"></i>New Billing<span><a href="{{ url('superadmin/add-billing2') }}" data-toggle="tooltip" data-placement="bottom" title="Generate Bill" style="padding: 8px 0;"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
                                @if(Session::has('message'))
                                <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                                @endif
                             </div>
                             <div class="card-body">
                                <div class="table-responsive">
                                   <table id="basic-datatables" class="display table table-striped table-hover" >
                                      <thead>
                                         <tr>
                                            <th>Sl.No.</th>
                                            <th>Invoice.No.</th>
                                            <th>Billg For</th>
                                            <th>Billing Month</th>
                                            <th>Billing Type</th>
                                            <th>Entity Id</th>
                                            <th>Amount</th>
                                            <th>Total Employee</th>
                                            <th>Vat</th>
                                            <th>Total Amount</th>
                                            <th>Payment Mode</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($billing_list as $billing)
                                            {{-- @php
                                               DB::table('registration')->where('') 
                                            @endphp --}}
                                         <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$billing->invoice_no}}</td>
                                            <td>{{$billing->bill_for}}</td>
                                            <td>{{ \Carbon\Carbon::parse($billing->date)->format('d-m-Y') }}</td>
                                            <td>{{$billing->billing_type}}</td>
                                            <td>{{$billing->entity_id}}</td>
                                            <td>{{$billing->amount}}</td>
                                            <td>{{$billing->total_employee}}</td>
                                            <td>{{$billing->vat}}</td>
                                            <td>{{$billing->total_amount}}</td>
                                            <td>{{$billing->payment_mode}}</td>
                                            <td>{{$billing->description}}</td>
                                            <td class="drp">
                                               <div class="dropdown">
                                                  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                     <a class="dropdown-item" href="{{ route('superadmin.billing.edit', $billing->id) }}"><i class="far fa-edit"></i>&nbsp; Edit</a>
                                                     @if($billing->payment_status == 0)
                                                     <a class="dropdown-item text-danger" href="{{ route('billing.delete', $billing->id) }}" onclick="return confirm('Are you sure you want to delete this record?');">
                                                        <i class="fas fa-trash"></i>&nbsp; Delete
                                                    </a>
                                                     @endif
                                                     <a class="dropdown-item" href="{{ route('admin.billing.invoice', $billing->id) }}" ><i class="fas fa-eye"></i>&nbsp; View Invoice</a> 
                                                     <a class="dropdown-item" target="_blank" href="#" ><i class="fas fa-eye"></i>&nbsp; Download Invoice</a>
                                                     <a class="dropdown-item" href="#"><i class="fas fa-paper-plane"></i>&nbsp; Send Email</a>
                                                     <a class="dropdown-item" href=""><i class="fa fa-comments"></i>&nbsp; Remarks</a>
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