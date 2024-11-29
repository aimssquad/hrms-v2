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
                        <div class="container mt-5">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>Edit Billing Rule</h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('billing-rule.update', $rule->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="POST">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="type" class="form-label">Billing Type</label>
                                                        <select class="form-control input-border-bottom" id="billing_type" name="type" required onchange="getBillingEntities(this.value);">
                                                            <option value="">&nbsp;</option>
                                                            <option value="employer" {{ $rule->type == 'employer' ? 'selected' : '' }}>Organisation</option>
                                                            <option value="sub-admin" {{ $rule->type == 'sub-admin' ? 'selected' : '' }}>Subadmin</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="entity_id" class="form-label">Entity ID</label>
                                                        <select class="form-control input-border-bottom" id="entity_id" name="entity_id" required >
                                                            <option value="{{ $rule->entity_id }}">{{ $rule->entity_id }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="employee_charge" class="form-label">Employee Charge</label>
                                                        <input type="number" name="employee_charge" id="employee_charge" class="form-control" step="0.01" value="{{ $rule->employee_charge }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="max_organizations" class="form-label">Max Organizations</label>
                                                        <input type="number" name="max_organizations" id="max_organizations" class="form-control" value="{{ $rule->max_organizations }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="min_employees" class="form-label">Min Employees</label>
                                                        <input type="number" name="min_employees" id="min_employees" class="form-control" value="{{ $rule->min_employees }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="max_employees" class="form-label">Max Employees</label>
                                                        <input type="number" name="max_employees" id="max_employees" class="form-control" value="{{ $rule->max_employees }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="payment_date_range" class="form-label">Payment Date Range</label>
                                                        <input type="text" name="payment_date_range" id="payment_date_range" class="form-control" maxlength="50" value="{{ $rule->payment_date_range }}">
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
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
    <script type="text/javascript">
        function getBillingEntities(billingType) {
            if (billingType != '') {
                $.ajax({
                    url: "{{ route('get.entities') }}",
                    type: 'GET',
                    data: { billing_type: billingType },
                    success: function(data) {
                        let entityDropdown = $('#entity_id');
                        entityDropdown.empty();

                        $.each(data, function(index, entity) {
                            entityDropdown.append('<option value="' + entity.employee_id + '">' + entity.name + '</option>');
                        });
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