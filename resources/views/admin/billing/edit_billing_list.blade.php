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
                                    <form action="{{ url('superadmin/bills/update/' . $bills->id) }}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row form-group">
                                            <!-- Billing For Dropdown -->
                                            <input type="text" name="invoice_no" value="{{$bills->invoice_no}}" hidden>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="bill_for" class="form-label">Billing For</label>
                                                    <select class="form-control input-border-bottom" id="bill_for" name="bill_for" required>
                                                        <option value="">&nbsp;</option>
                                                        <option value="invoice for license applied" {{ old('bill_for', $bills->bill_for) == 'invoice for license applied' ? 'selected' : '' }}>Invoice for license applied</option>
                                                        <option value="invoice for license granted" {{ old('bill_for', $bills->bill_for) == 'invoice for license granted' ? 'selected' : '' }}>Invoice for license granted</option>
                                                        <option value="first invoice recruitment service" {{ old('bill_for', $bills->bill_for) == 'first invoice recruitment service' ? 'selected' : '' }}>First invoice for recruitment service</option>
                                                        <option value="second invoice visa service" {{ old('bill_for', $bills->bill_for) == 'second invoice visa service' ? 'selected' : '' }}>Second invoice for visa service</option>
                                                        <option value="other" {{ old('bill_for', $bills->bill_for) == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Billing Month Dropdown -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="date">Invoice Date</label>
                                                    <input type="date" class="form-control" id="date" name="date" value="{{ $bills->date ?? '' }}">
                                                </div>
                                            </div>
                                            
                                           
                                          
                    
                                            <!-- Hidden Billing Type -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="billing_type" class="placeholder">Billing Type</label>
                                                    <input type="text" class="form-control" id="billing_type" name="billing_type" value="{{$bills->billing_type}}" readonly>
                                                </div>
                                            </div>
                                            
                                            <!-- Entity ID (Readonly) -->
                                            <div class="col-md-4" id="entity_dropdown">
                                                <div class="form-group">
                                                    <label for="entity_id" class="form-label">Organisation</label>
                                                    <input type="text" class="form-control" name="entity_id" value="{{$bills->entity_id}}" readonly>
                                                </div>
                                            </div>
                                            
                                            <!-- Amount (Readonly) -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="amount" class="form-label">Amount</label>
                                                    <input type="text" class="form-control" id="amount" name="amount" value="{{$bills->amount}}" readonly>
                                                </div>
                                            </div>
                                            
                                            <!-- Total Employees (Readonly) -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="total_employee" class="form-label">Total Employee</label>
                                                    <input type="text" class="form-control" id="total_employee" name="total_employee" value="{{$bills->total_employee}}" readonly>
                                                </div>
                                            </div>
                                            
                                            <!-- VAT -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="vat" class="form-label">VAT</label>
                                                    <input type="text" class="form-control" id="vat" name="vat" value="{{$bills->vat}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="vat" class="form-label">Discounted Amount</label>
                                                    <input type="text" step="0.01" class="form-control" id="discount_amount" value="{{$bills->discount_amount}}" name="discount_amount">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="entity_id" >Total Amount</label>
                                                    <input type="text" class="form-control" id="total_amount" name="total_amount" value="{{$bills->total_amount}}"readonly>
                                                </div>
                                            </div>
                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payment_mode" class="form-label">Payment Mode</label>
                                                    <select class="form-control input-border-bottom" id="payment_mode" name="payment_mode" required>
                                                        <option value="Online" {{ old('payment_mode', $bills->payment_mode) == 'Online' ? 'selected' : '' }}>Online</option>
                                                        <option value="Offline" {{ old('payment_mode', $bills->payment_mode) == 'Offline' ? 'selected' : '' }}>Offline</option>
                                                    </select>
                                                </div>
                                            </div>
                    
                                            <!-- Description -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="description" class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="description" name="description" value="{{$bills->description}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="vat" >Remarks</label>
                                                    <textarea class="form-control" id="remarks"  name="remarks">{{ $bills->remarks }}</textarea>
                                                </div>
                                            </div>
                    
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary btn-up">Submit</button>
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
                //alert(billingType);
                $.ajax({
                    url: "{{ route('get.entities') }}", // The route to call
                    type: 'GET',
                    data: { billing_type: billingType },
                    success: function(data) {
                        var entityDropdown = $('#entity_id'); // The dropdown for organization/sub-admin
                        entityDropdown.empty(); // Clear existing options
                        // if(billingType == 'sub-admin'){
                        //     alert(data);
                        // }
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

        function getUserDetails(userId) {
            if (userId != '') {
                let billingMonth = $('#billing_month').val();
                let billingType = $('#billing_type').val();
                //alert(userId);
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

<script type="text/javascript">
    $(document).ready(function () {
    // Trigger calculation on input in VAT, Amount, or Discount Amount fields
    $('#vat, #amount, #discount_amount').on('input', function () {
        calculateTotalAmount();
    });

    // Initial calculation on page load (in case values are pre-filled)
    calculateTotalAmount();

    // Function to calculate the total amount
    function calculateTotalAmount() {
        // Get values from the fields
        var amount = parseFloat($('#amount').val()) || 0; // Default to 0 if empty
        var vat = parseFloat($('#vat').val()) || 0;      // Default to 0 if empty
        var discount = parseFloat($('#discount_amount').val()) || 0; // Default to 0 if empty

        // Calculate VAT and apply discount
        var totalAmount = amount * (1 + vat / 100) - discount;

        // Ensure the total amount doesn't go below 0
        totalAmount = Math.max(totalAmount, 0);

        // Update the total amount field
        $('#total_amount').val(totalAmount.toFixed(2)); // Show two decimal places
    }
});
</script>

    

</body>

</html>