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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

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
            {{-- <div class="page-header">

            </div> --}}
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>Billing Rule</h3>
                                        </div>
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
                                        <div class="card-body">
                                            <form action="{{url('superadmin/bill/rule/store')}}" method="POST" class="needs-validation" novalidate>
                                                @csrf()
                                                <div class="card">
                                                    <div class="card-header text-white">
                                                        <h5 class="mb-0">Billing Rule Configuration</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="billing_type" class="form-label fw-bold">Billing For</label>
                                                                    <select class="form-control select2" id="billing_type" name="billing_type" required onchange="getBillingEntities(this.value);">
                                                                        <option value="">Select Type</option>
                                                                        <option value="employer">Organisation</option>
                                                                        <option value="sub-admin">Subadmin</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">Please select billing type</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="entity_id" class="form-label fw-bold">Entity</label>
                                                                    <select class="form-control select2" id="entity_id" name="entity_id" required onchange="getUserDetails(this.value);">
                                                                        <option value="">Select Entity</option>
                                                                        <!-- Options will be dynamically loaded via AJAX -->
                                                                    </select>
                                                                    <div class="invalid-feedback">Please select an entity</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="billing_for" class="form-label fw-bold">Billing Type</label>
                                                                    <select class="form-control select2" id="billing_for" name="billing_for" required onchange="toggleBillingSections(this.value);">
                                                                        <option value="">Select Billing Type</option>
                                                                        <option value="Organisation Subscription">Organisation Subscription</option>
                                                                        <option value="Number Of Employee">Number Of Employee</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">Please select billing category</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                            
                                                        <!-- Organisation Subscription Section -->
                                                        <div class="row mb-3" id="for_org_subscription" style="display: none;">
                                                            <div class="col-md-12">
                                                               
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="min_organizations" class="form-label">Minimum Organization</label>
                                                                    <input type="number" name="min_organizations" id="min_organizations" class="form-control" step="0.01" placeholder="Enter minimum">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" id="max_org">
                                                                <div class="form-group">
                                                                    <label for="max_organizations" class="form-label">Max Organizations</label>
                                                                    <input type="number" name="max_organizations" id="max_organizations" class="form-control" placeholder="Enter maximum">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="employee_charge" class="form-label">Organization Charge</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" name="organization_charge" id="organization_charge" class="form-control" step="0.01" placeholder="0.00">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                            
                                                        <!-- Number of Employees Section -->
                                                        <div class="row mb-3" id="for_num_of_emp" style="display: none;">
                                                            <div class="col-md-12">
                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="min_employees" class="form-label">Min Employees</label>
                                                                    <input type="number" name="min_employees" id="min_employees" class="form-control" placeholder="Enter minimum">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="max_employees" class="form-label">Max Employees</label>
                                                                    <input type="number" name="max_employees" id="max_employees" class="form-control" placeholder="Enter maximum">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="employee_charge" class="form-label">Employee Charge</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" name="employee_charge" id="employee_charge" class="form-control" step="0.01" placeholder="0.00">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                            
                                                        <!-- Payment Date Range -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                             
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="billing_mode" class="form-label fw-bold">Billing Mode</label>
                                                                    <select class="form-control select2" id="billing_mode" name="billing_mode" >
                                                                        <option value="">Select Billing Mode</option>
                                                                        <option value="Monthly">Monthly</option>
                                                                        <option value="Quarterly">Quarterly</option>
                                                                        <option value="Half_yearly">Half Yearly</option>
                                                                        <option value="Annually">Annually</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="payment_date_from" class="form-label">Payment Day From</label>
                                                                    <input type="date" name="payment_date_from" id="payment_date_from" class="form-control" step="1" min="1" max="31" placeholder="Day (1-31)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="payment_date_to" class="form-label">Payment Day To</label>
                                                                    <input type="date" name="payment_date_to" id="payment_date_to" class="form-control" step="1" min="1" max="31" placeholder="Day (1-31)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="card-footer bg-light">
                                                        <button type="submit" class="btn btn-primary px-4">
                                                            <i class="fas fa-save me-2"></i> Save Rule
                                                        </button>
                                                        {{-- <button type="reset" class="btn btn-outline-secondary ms-2">
                                                            <i class="fas fa-undo me-2"></i> Reset
                                                        </button> --}}
                                                    </div>
                                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                            entityDropdown.append('<option value="' + entity.employee_id + '">' + entity.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        // function getUserDetails(userId) {
        //     if (userId != '') {
        //         let billingMonth = $('#billing_month').val();
        //         let billingType = $('#billing_type').val();
        //         $.ajax({
        //             url: "{{ route('get.user.details') }}", // The route to call
        //             type: 'GET',
        //             data: { user_id: userId,
        //                 billingMonth: billingMonth,
        //                 billingType: billingType
        //              },
        //             success: function(data) {
        //                 // Populate the form fields with the data returned
        //                 $('#amount').val(data.amount);
        //                 $('#total_employee').val(data.total_employee);
        //                 console.log(data);
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(error);
        //             }
        //         });
        //     }
        // }
    </script>
    {{-- <script>
        function getBillingEntities(value) {
            const maxOrgDiv = document.getElementById('max_org');
            if (value === 'employer') {
                maxOrgDiv.style.display = 'none';
            } else {
                maxOrgDiv.style.display = 'block';
            }
        }
    </script> --}}

    <script>
        
        // Function to toggle between billing sections
        function toggleBillingSections(selectedValue) {
            const orgSubscriptionDiv = document.getElementById('for_org_subscription');
            const numOfEmpDiv = document.getElementById('for_num_of_emp');
            
            if (selectedValue === 'Organisation Subscription') {
                orgSubscriptionDiv.style.display = 'flex';
                numOfEmpDiv.style.display = 'none';
                
                // Clear values in the hidden section
                document.getElementById('min_employees').value = '';
                document.getElementById('max_employees').value = '';
                document.getElementById('employee_charge').value = '';
            } 
            else if (selectedValue === 'Number Of Employee') {
                orgSubscriptionDiv.style.display = 'none';
                numOfEmpDiv.style.display = 'flex';
                
                // Clear values in the hidden section
                document.getElementById('min_organization').value = '';
                document.getElementById('max_organizations').value = '';
                document.getElementById('employee_charge').value = '';
            }
            else {
                // If nothing selected, hide both
                orgSubscriptionDiv.style.display = 'none';
                numOfEmpDiv.style.display = 'none';
            }
        }
        
        // Initialize the form on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state based on selected value (if any)
            const billingForSelect = document.getElementById('billing_for');
            if (billingForSelect.value) {
                toggleBillingSections(billingForSelect.value);
            }
            
            // Initialize other functions (select2, validation) as before
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });
            
            // Form validation code remains the same
        });
        </script>
 

</body>

</html>