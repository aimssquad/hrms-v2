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
                                <h4 class="card-title"><i class="far fa-newspaper"></i>Billing Rule<span><a href="{{ url('superadmin/billing-rule') }}" data-toggle="tooltip" data-placement="bottom" title="Generate Bill" style="padding: 8px 0;"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
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
                                            <th>Type</th>
                                            <th>Company Name</th>
                                            <th>Employee Charge</th>
                                            <th>Max Organization</th>
                                            <th>Min Employee</th>
                                            <th>Max Employee</th>
                                            <th>Payment Date Range</th>
                                            <th>Action</th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($billing_rule as $billing)
                                            @php 
                                                if($billing->type == 'sub-admin'){
                                                    $copany_name = DB::table('sub_admin_registrations')
                                                    ->where('reg', $billing->entity_id)->first();
                                                    //dd($copany_name->com_name);
                                                } elseif($billing->type == 'employeer') {
                                                    $copany_name = DB::table('registration')
                                                    ->where('reg', $billing->company_id)->first();
                                                }
                                            @endphp
                                         <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $billing->type ?? 'NA' }}</td>
                                            <td>{{ $copany_name->com_name ?? 'DEFULT' }}</td>
                                            <td>{{ $billing->employee_charge ?? 'NA' }}</td>
                                            <td>{{ $billing->max_organizations ?? 'NA' }}</td>
                                            <td>{{ $billing->min_employees ?? 'NA' }}</td>
                                            <td>{{ $billing->max_employees ?? 'NA' }}</td>
                                            <td>{{ $billing->payment_date_range ?? 'NA' }}</td>
                                            <td class="drp">
                                               <div class="dropdown">
                                                  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('billing-rule.edit', $billing->id) }}">
                                                        <i class="far fa-edit"></i>&nbsp; Edit
                                                    </a>
                                                     {{-- <a class="dropdown-item text-danger" href="{{ route('billing-rule.delete', $billing->id) }}" onclick="return confirm('Are you sure you want to delete this record?');">
                                                        <i class="fas fa-trash"></i>&nbsp; Delete
                                                    </a> --}}
                                                     <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal"><i class="fas fa-eye"></i>&nbsp; View Invoice</a> 
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