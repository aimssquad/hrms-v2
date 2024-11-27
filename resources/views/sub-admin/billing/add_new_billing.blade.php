@extends('sub-admin.include.app')
@section('title', ' Billing')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title"> New Billing</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
               {{-- <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li> --}}
               <li class="breadcrumb-item active"> New Billing</li>
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
                <h3>New Billing</h3>
            </div>
            <div class="card-body">
                <form action="{{url('sub-admin/bills/store')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row form-group">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bill_for" class="form-label">Invoice For</label>
                                <select class="select" id="bill_for" name="bill_for" required="" >
                                    <option value="">&nbsp;</option>
                                    <option value="invoice for license applied">Invoice for license applied</option>
                                    <option value="invoice for license granted">Invoice for license granted</option>
                                    <option value="first invoice recruitment service">First invoice for recruitment service</option>
                                    <option value="second invoice visa service">Second invoice for visa service</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date" >Invoice Date</label>
                                <input type="date" class="form-control" id="date"  name="date">
                            </div>
                        </div>
                        <!--<div class="col-md-4">-->
                        <!--    <div class="form-group">-->
                        <!--        <label for="payment_mode" class="form-label">Billing Month</label>-->
                        <!--        <select class="select" id="billing_month" name="billing_month" >-->
                        <!--            <option value="January">January</option>-->
                        <!--            <option value="February">February</option>-->
                        <!--            <option value="March">March</option>-->
                        <!--            <option value="April">April</option>-->
                        <!--            <option value="May">May</option>-->
                        <!--            <option value="June">June</option>-->
                        <!--            <option value="July">July</option>-->
                        <!--            <option value="August">August</option>-->
                        <!--            <option value="September">September</option>-->
                        <!--            <option value="October">October</option>-->
                        <!--            <option value="November">November</option>-->
                        <!--            <option value="December">December</option>-->
                        <!--        </select>-->
                        <!--    </div>-->
                        <!--</div>-->
                
                                <input type="text" name="billing_type" value="employer" class="form-control" hidden>
                             
                      
                        <!-- Dynamic Dropdown for Organisation or Sub-admin -->
                        <div class="col-md-4" id="entity_dropdown">
                            <div class="form-group">
                                <label for="entity_id" class="form-label">Select Organisation</label>
                                <select class="select" id="entity_id" name="entity_id" required=""  onchange="fetchEntityDetails(this.value);">
                                    <option value="">&nbsp;</option>
                                    @foreach($organization as $org)
                                    <option value="{{$org->reg}}">{{$org->com_name}}</option>
                                    @endforeach
                                    <!-- Options will be dynamically loaded via AJAX -->
                                </select>
                            </div>
                        </div>
                        

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="entity_id" >Amount</label>
                                <input type="text" step="0.01" class="form-control" id="amount"  name="amount" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total-employee" >Total Employee</label>
                                <input type="text" class="form-control" id="total_employee" value="" name="total_employee" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vat" class="form-label">VAT</label>
                                <input type="text" step="0.01" class="form-control" id="vat" value="" name="vat">
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="vat" class="form-label">Discounted Amount</label>
                                <input type="text" step="0.01" class="form-control" id="discount_amount" value="" name="discount_amount">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="entity_id" >Total Amount</label>
                                <input type="text" class="form-control" id="total_amount" name="total_amount" value=""readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="billing_type" class="form-label">Payment Mode</label>
                                <select class="select" id="payment_mode" name="payment_mode">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vat" >Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks"></textarea>
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
    function fetchEntityDetails(entityId) {
        if (!entityId) return; // Do nothing if no entity is selected.
        //alert(entityId);
        // Perform an AJAX request to fetch the data
        $.ajax({
            url: '{{ url("superadmin/get-entity-details") }}',
            type: 'GET',
            data: { entity_id: entityId },
            success: function(response) {
                // Update the form fields with the fetched data
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
    // $(document).ready(function() {
    //     // Event listener for when VAT or Amount is changed
    //     $('#vat, #amount,discount_amount').on('input', function() {
    //         // Get the values of amount and VAT
    //         var amount = parseFloat($('#amount').val()) || 0;
    //         var vat = parseFloat($('#vat').val()) || 0;
    //          var discount_amount = parseFloat($('#discount_amount').val()) || 0;
            
    //         // Calculate the total amount (Amount * (1 + VAT))
    //         var totalAmount = amount * (1 + vat / 100); // VAT is a percentage, so we divide by 100
    //         var tamount = totalAmount-discount_amount;
            
    //         // Update the total amount field
    //         $('#total_amount').val(tamount.toFixed(2)); // Show up to two decimal places
    //     });
    // });
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
@endsection