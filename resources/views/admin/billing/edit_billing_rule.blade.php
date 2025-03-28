<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH - Edit Billing Rule</title>
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
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .card-header {
        background: linear-gradient(87deg, #5ac3f3 0, #2dcecc 100%) !important;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .input-group-text {
        background-color: #e9ecef;
    }
    .section-title {
        color: #2dce89;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title mb-0">Edit Billing Rule</h4>
                                        <div class="ml-auto">
                                            {{-- <a href="{{ route('billing-rule.index') }}" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-arrow-left mr-1"></i> Back to List
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('billing-rule.update', $rule->id) }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        {{-- @method('PUT') --}}
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="billing_type" class="form-label">Billing For</label>
                                                    <select class="form-control " id="billing_type" name="type" required onchange="getBillingEntities(this.value);">
                                                        <option value="">Select Type</option>
                                                        <option value="employer" {{ $rule->type == 'employer' ? 'selected' : '' }}>Organisation</option>
                                                        <option value="sub-admin" {{ $rule->type == 'sub-admin' ? 'selected' : '' }}>Subadmin</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select billing type</div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="entity_id" class="form-label">Entity</label>
                                                    <select class="form-control select2" id="entity_id" name="entity_id" required>
                                                        <option value="{{ $rule->entity_id }}">{{ $rule->entity_name ?? $rule->entity_id }}</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select an entity</div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="billing_for" class="form-label">Billing Type</label>
                                                    <select class="form-control" id="billing_for" name="billing_for" required onchange="toggleBillingSections(this.value);">
                                                        <option value="">Select Billing Type</option>
                                                        <option value="Organisation Subscription" {{ $rule->billing_for == 'Organisation Subscription' ? 'selected' : '' }}>Organisation Subscription</option>
                                                        <option value="Number Of Employee" {{ $rule->billing_for == 'Number Of Employee' ? 'selected' : '' }}>Number Of Employee</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select billing category</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Organisation Subscription Section -->
                                        <div class="row mb-3" id="for_org_subscription" style="display: {{ $rule->billing_for == 'Organisation Subscription' ? 'flex' : 'none' }};">
                                            <div class="col-md-12">
                                                <h6 class="section-title">Organisation Subscription Settings</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="min_organizations" class="form-label">Minimum Organization</label>
                                                    <input type="number" name="min_organizations" id="min_organizations" class="form-control" step="0.01" value="{{ $rule->min_organizations }}" placeholder="Enter minimum">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="max_organizations" class="form-label">Max Organizations</label>
                                                    <input type="number" name="max_organizations" id="max_organizations" class="form-control" value="{{ $rule->max_organizations }}" placeholder="Enter maximum">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="organization_charge" class="form-label">Organization Charge</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" name="organization_charge" id="organization_charge" class="form-control" step="0.01" value="{{ $rule->organization_charge }}" placeholder="0.00">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Number of Employees Section -->
                                        <div class="row mb-3" id="for_num_of_emp" style="display: {{ $rule->billing_for == 'Number Of Employee' ? 'flex' : 'none' }};">
                                            <div class="col-md-12">
                                                <h6 class="section-title">Employee-Based Settings</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="min_employees" class="form-label">Min Employees</label>
                                                    <input type="number" name="min_employees" id="min_employees" class="form-control" value="{{ $rule->min_employees }}" placeholder="Enter minimum">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="max_employees" class="form-label">Max Employees</label>
                                                    <input type="number" name="max_employees" id="max_employees" class="form-control" value="{{ $rule->max_employees }}" placeholder="Enter maximum">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="employee_charge" class="form-label">Employee Charge</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" name="employee_charge" id="employee_charge" class="form-control" step="0.01" value="{{ $rule->employee_charge }}" placeholder="0.00">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Date Range -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <h6 class="section-title">Payment Schedule</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="billing_mode" class="form-label fw-bold">Billing Mode</label>
                                                    <select class="form-control" id="billing_mode" name="billing_mode" >
                                                        <option value="">Select Billing Mode</option>
                                                        <option value="monthly" {{ $rule->billing_mode == 'monthly' ? 'selected' : '' }}>monthly</option>
                                                        <option value="quarterly" {{ $rule->billing_mode == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                        <option value="half_yearly" {{ $rule->billing_mode == 'half_yearly' ? 'selected' : '' }}>Half Yearly</option>
                                                        <option value="yearly" {{ $rule->billing_mode == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payment_date_from" class="form-label">Payment Date From</label>
                                                    <input type="date" name="payment_date_from" id="payment_date_from" class="form-control" value="{{ $rule->payment_date_from }}" placeholder="e.g. 1-15 (days of month)">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payment_date_to" class="form-label">Payment Date To</label>
                                                    <input type="date" name="payment_date_to" id="payment_date_to" class="form-control" value="{{ $rule->payment_date_to }}" placeholder="e.g. 1-15 (days of month)">
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payment_date_range" class="form-label">Payment Date Range</label>
                                                    <input type="text" name="payment_date_range" id="payment_date_range" class="form-control" value="{{ $rule->payment_date_range }}" placeholder="e.g. 1-15 (days of month)">
                                                </div>
                                            </div> --}}
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="fas fa-save mr-2"></i> Update Rule
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary ml-2">
                                                    <i class="fas fa-undo mr-2"></i> Reset
                                                </button>
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

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
    <script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    // Initialize Select2
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Initialize form sections based on current selection
        const currentBillingType = $('#billing_for').val();
        if (currentBillingType) {
            toggleBillingSections(currentBillingType);
        }

        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })();
    });

    // Function to toggle between billing sections
    function toggleBillingSections(selectedValue) {
        const orgSubscriptionDiv = document.getElementById('for_org_subscription');
        const numOfEmpDiv = document.getElementById('for_num_of_emp');
        
        if (selectedValue === 'Organisation Subscription') {
            orgSubscriptionDiv.style.display = 'flex';
            numOfEmpDiv.style.display = 'none';
        } 
        else if (selectedValue === 'Number Of Employee') {
            orgSubscriptionDiv.style.display = 'none';
            numOfEmpDiv.style.display = 'flex';
        }
        else {
            // If nothing selected, hide both
            orgSubscriptionDiv.style.display = 'none';
            numOfEmpDiv.style.display = 'none';
        }
    }

    // Function to get billing entities (unchanged from your original)
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