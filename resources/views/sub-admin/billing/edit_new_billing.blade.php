@extends('sub-admin.include.app')
@section('title', 'Edit Billing')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Edit Billing</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
               <li class="breadcrumb-item active">Edit Billing</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('sub-admin.layout.message')
   <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Edit Billing</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('sub-admin/bills/update/' . $bills->id) }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row form-group">
                        <!-- Billing For Dropdown -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bill_for" class="form-label">Billing For</label>
                                <select class="select" id="bill_for" name="bill_for" required>
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
                                <label for="billing_month" class="form-label">Billing Month</label>
                                <select class="select" id="billing_month" name="billing_month" required>
                                    <option value="January" {{ old('billing_month', $bills->billing_month) == 'January' ? 'selected' : '' }}>January</option>
                                    <option value="February" {{ old('billing_month', $bills->billing_month) == 'February' ? 'selected' : '' }}>February</option>
                                    <option value="March" {{ old('billing_month', $bills->billing_month) == 'March' ? 'selected' : '' }}>March</option>
                                    <option value="April" {{ old('billing_month', $bills->billing_month) == 'April' ? 'selected' : '' }}>April</option>
                                    <option value="May" {{ old('billing_month', $bills->billing_month) == 'May' ? 'selected' : '' }}>May</option>
                                    <option value="June" {{ old('billing_month', $bills->billing_month) == 'June' ? 'selected' : '' }}>June</option>
                                    <option value="July" {{ old('billing_month', $bills->billing_month) == 'July' ? 'selected' : '' }}>July</option>
                                    <option value="August" {{ old('billing_month', $bills->billing_month) == 'August' ? 'selected' : '' }}>August</option>
                                    <option value="September" {{ old('billing_month', $bills->billing_month) == 'September' ? 'selected' : '' }}>September</option>
                                    <option value="October" {{ old('billing_month', $bills->billing_month) == 'October' ? 'selected' : '' }}>October</option>
                                    <option value="November" {{ old('billing_month', $bills->billing_month) == 'November' ? 'selected' : '' }}>November</option>
                                    <option value="December" {{ old('billing_month', $bills->billing_month) == 'December' ? 'selected' : '' }}>December</option>
                                </select>
                            </div>
                        </div>
                        
                       
                      

                        <!-- Hidden Billing Type -->
                        <input type="text" name="billing_type" value="employer" class="form-control" hidden>
                        
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
                                <label for="entity_id" >Total Amount</label>
                                <input type="text" class="form-control" id="total_amount" value="{{$bills->total_amount}}"readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="payment_mode" class="form-label">Payment Mode</label>
                                <select class="select" id="payment_mode" name="payment_mode" required>
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
                                <label for="description" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" value="{{$bills->remarks}}">
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
<!-- /Page Content -->
@endsection

@section('script')
<script type="text/javascript">
    // Fetch entity details using AJAX
    function fetchEntityDetails(entityId) {
        if (!entityId) return; // Do nothing if no entity is selected.
        
        $.ajax({
            url: '{{ url("superadmin/get-entity-details") }}',
            type: 'GET',
            data: { entity_id: entityId },
            success: function(response) {
                $('#amount').val(response.amount || '');
                $('#total_employee').val(response.total_employee || '');
            },
            error: function(xhr) {
                console.error("Error fetching entity details:", xhr);
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // Event listener for when VAT or Amount is changed
        $('#vat, #amount').on('input', function() {
            // Get the values of amount and VAT
            var amount = parseFloat($('#amount').val()) || 0;
            var vat = parseFloat($('#vat').val()) || 0;
            
            // Calculate the total amount (Amount * (1 + VAT))
            var totalAmount = amount * (1 + vat / 100); // VAT is a percentage, so we divide by 100
            
            // Update the total amount field
            $('#total_amount').val(totalAmount.toFixed(2)); // Show up to two decimal places
        });
    });
</script>
@endsection
