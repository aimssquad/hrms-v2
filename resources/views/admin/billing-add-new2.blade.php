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
                                    <h4 class="card-title"><i class="far fa-newspaper"></i> New Billing</h4>
                                    @if(Session::has('message'))
                                    <div class="alert alert-success" style="text-align:center;"><span
                                            class="glyphicon glyphicon-ok"></span><em>
                                            {{ Session::get('message') }}</em></div>
                                    @endif
                                    @if(Session::has('error'))
                                    <div class="alert alert-danger" style="text-align:center;"><span
                                            class="glyphicon glyphicon-ok"></span><em> {{ Session::get('error') }}</em>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form action="{{url('superadmin/bills/store')}}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="bill_for" class="placeholder">Billing For</label>
                                                    <select class="form-control input-border-bottom" id="bill_for" name="bill_for" required="" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="invoice for license applied">Invoice for license applied</option>
                                                        <option value="invoice for license granted">Invoice for license granted</option>
                                                        <option value="first invoice recruitment service">First invoice for recruitment service</option>
                                                        <option value="second invoice visa service">Second invoice for visa service</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="payment_mode" class="placeholder">Billing Month</label>
                                                    <select class="form-control input-border-bottom" id="billing_month" name="billing_month" style="margin-top: 22px;">
                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>
                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>
                                                        <option value="October">October</option>
                                                        <option value="November">November</option>
                                                        <option value="December">December</option>
                                                    </select>
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="billing_type" class="placeholder">Billing Type</label>
                                                    <select class="form-control input-border-bottom" id="billing_type" name="billing_type" required="" style="margin-top: 22px;" onchange="getBillingEntities(this.value);">
                                                        <option value="">&nbsp;</option>
                                                        <option value="employer">Organisation</option>
                                                        <option value="sub-admin">Subadmin</option>
                                                    </select>
                                                </div>
                                            </div>
                                    
                                            <!-- Dynamic Dropdown for Organisation or Sub-admin -->
                                            <div class="col-md-3" id="entity_dropdown">
                                                <div class="form-group">
                                                    <label for="entity_id" class="placeholder">Select Organisation/Subadmin</label>
                                                    <select class="form-control input-border-bottom" id="entity_id" name="entity_id" required="" style="margin-top: 22px;" onchange="getUserDetails(this.value);">
                                                        <option value="">&nbsp;</option>
                                                        <!-- Options will be dynamically loaded via AJAX -->
                                                    </select>
                                                </div>
                                            </div>
                                            

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="entity_id" >Amount</label>
                                                    <input type="text" class="form-control" id="amount"  name="amount">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="total-employee" >Total Employee</label>
                                                    <input type="text" class="form-control" id="total_employee" value="" name="total_employee">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="vat" >VAT</label>
                                                    <input type="text" class="form-control" id="vat" value="" name="vat">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="billing_type" class="placeholder">Payment Mode</label>
                                                    <select class="form-control input-border-bottom" id="payment_mode" name="payment_mode">
                                                        <option value="Online">Online</option>
                                                        <option value="Offline">Offline</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="vat" >Description</label>
                                                    <input type="text" class="form-control" id="description" value="" name="description">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-default btn-up">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
    <script type="text/javascript">
        function getBillingEntities(billingType) {
            if (billingType != '') {
                $.ajax({
                    url: "{{ route('get.entities') }}", // The route to call
                    type: 'GET',
                    data: { billing_type: billingType },
                    success: function(data) {
                        var entityDropdown = $('#entity_id'); // The dropdown for organization/sub-admin
                        entityDropdown.empty(); // Clear existing options

                        $.each(data, function(index, entity) {
                            entityDropdown.append('<option value="' + entity.id + '">' + entity.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        function getUserDetails(userId) {
            if (userId != '') {
                let billingMonth = $('#billing_month').val();
                let billingType = $('#billing_type').val();
                $.ajax({
                    url: "{{ route('get.user.details') }}", // The route to call
                    type: 'GET',
                    data: { user_id: userId,
                        billingMonth: billingMonth,
                        billingType: billingType
                     },
                    success: function(data) {
                        // Populate the form fields with the data returned
                        $('#amount').val(data.amount);
                        $('#total_employee').val(data.total_employee);
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
    </script>

</body>

</html>