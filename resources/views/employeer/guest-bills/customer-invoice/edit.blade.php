@extends('employeer.include.app')
@section('title', 'Edit Customer Invoice')
@section('content')
<div class="content container-fluid">
   <div class="page-header">
      <div class="row">
         <div class="col-sm-12">
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Edit Customer Invoice')}}</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
               <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Edit Customer Invoice')}} </li>
            </ul>
         </div>
      </div>
   </div>
   @include('employeer.layout.message')
   <div class="card">
        <div class="card-header">
            <h4>
                <i class="fa fa-user" style="color:rgb(253,124,3)"></i>
                Edit New Customer Invoice
            </h4>
        </div>
      <div class="card-body">
         <form method="POST"
            action="{{ route('org.customer.invoice.update', base64_encode($invoice->id)) }}">
            @csrf
            @method('PUT')
            <div class="row">
               {{-- CUSTOMER --}}
               <div class="col-md-3">
                  <label class="col-form-label">Customer</label>
                  <select class="select" name="guest_id">
                  @foreach($guests as $g)
                  <option value="{{ $g->id }}"
                  {{ $invoice->guest_id == $g->id ? 'selected' : '' }}>
                  {{ $g->name }} - {{ $g->company_name }}
                  </option>
                  @endforeach
                  </select>
               </div>
               {{-- COUNTRY --}}
               <div class="col-md-3">
                  <label class="col-form-label">Country</label>
                  <select class="select" name="country" id="countrySelect">
                  <option value="India"   {{ $invoice->country=='India'?'selected':'' }}>India</option>
                  <option value="England" {{ $invoice->country=='England'?'selected':'' }}>England</option>
                  <option value="USA"     {{ $invoice->country=='USA'?'selected':'' }}>USA</option>
                  </select>
               </div>
               {{-- CURRENCY --}}
               <div class="col-md-3">
                  <label class="col-form-label">Currency</label>
                  <input type="text"
                    name="currency"
                     id="currencyInput"
                     class="form-control"
                     value="{{ $invoice->currency }}"
                     readonly>
               </div>
               {{-- DATE --}}
               <div class="col-md-3">
                  <label class="col-form-label">Invoice Date</label>
                  <input type="date"
                     name="date" id="paymentDate"
                     class="form-control"
                     value="{{ $invoice->invoice_date }}">
               </div>

                <div class="col-md-3">
                  <label class="col-form-label">Email Send Date</label>
                  <input type="date" name="invoice_send" id="invoice_send" class="form-control"  value="{{ $invoice->invoice_send }}"
                  placeholder="Which date to want send email every day">
               </div>
            </div>
            <hr>
            {{-- ================= SERVICES ================= --}}
            <div id="service-wrapper">
               @foreach($invoice->items as $k => $item)
               <div class="row service-row pb-3">
                  <div class="col-md-6">
                     <label>Service</label>
                     <textarea class="form-control"
                        name="service_name[]"
                        rows="2">{{ $item->service_name }}</textarea>
                  </div>
                  <div class="col-md-3">
                     <label>Qty</label>
                     <input type="number"
                        name="quantity[]"
                        class="form-control"
                        value="{{ $item->quantity }}">
                  </div>
                  <div class="col-md-3">
                     <label>Unit Price</label>
                     <input type="number"
                        name="unit_price[]"
                        class="form-control"
                        value="{{ $item->unit_price }}">
                  </div>
                  {{-- DISCOUNT TYPE --}}
                  <div class="col-md-2">
                     <label>Discount Type</label>
                     <div class="form-check">
                        <input type="checkbox"
                        class="form-check-input discount-type"
                        {{ $item->discount_type=='percentage_discount'?'checked':'' }}>
                        <small>Percentage</small>
                     </div>
                  </div>
                  {{-- DISCOUNT --}}
                  <div class="col-md-2">
                     <label class="discount-label">
                     {{ $item->discount_type=='percentage_discount'
                     ? 'Percentage Discount'
                     : 'Flat Discount' }}
                     </label>
                     <input type="number"
                        name="discount[]"
                        class="form-control"
                        value="{{ $item->discount }}">
                     <input type="hidden"
                        name="discount_type[]"
                        value="{{ $item->discount_type }}">
                  </div>
                  {{-- TAX % --}}
                  <div class="col-md-2">
                     <label>Tax %</label>
                     <input type="number"
                        name="tax_percent[]"
                        class="form-control"
                        value="{{ $item->tax_percent }}">
                  </div>
                  {{-- TAX TYPE --}}
                  <div class="col-md-2">
                     <label>Tax Type</label>
                     <select name="tax_type[]" class="form-control">
                     <option value="exclusive"
                     {{ $item->tax_type=='exclusive'?'selected':'' }}>
                     Exclusive
                     </option>
                     <option value="inclusive"
                     {{ $item->tax_type=='inclusive'?'selected':'' }}>
                     Inclusive
                     </option>
                     </select>
                  </div>
                  {{-- SUBTOTAL --}}
                  <div class="col-md-2">
                     <label>Subtotal</label>
                     <input type="number"
                        name="sub_total[]"
                        class="form-control"
                        value="{{ $item->sub_total }}"
                        readonly>
                  </div>
                  {{-- BUTTON --}}
                  <div class="col-md-1 d-flex align-items-end">
                     @if($k==0)
                     <button type="button" class="btn btn-success add-row">
                     <i class="fa fa-plus"></i>
                     </button>
                     @else
                     <button type="button" class="btn btn-danger remove-row">
                     <i class="fa fa-minus"></i>
                     </button>
                     @endif
                  </div>
               </div>
               @endforeach
            </div>
            {{-- TOTALS --}}
            <div class="row mt-3">
               <div class="col-md-3 offset-md-6">
                  <label>Total Tax</label>
                  <input type="text"
                     id="totalTax"
                     class="form-control"
                     value="{{ number_format($invoice->total_tax,2) }}"
                     readonly>
               </div>
               <div class="col-md-3">
                  <label>Grand Total</label>
                  <input type="text"
                     id="grandTotal"
                     class="form-control"
                     value="{{ number_format($invoice->grand_total,2) }}"
                     readonly>
               </div>
            </div>
            <div class="mt-4">
               <button class="btn btn-primary">Update Invoice</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
{{-- ================= JS ================= --}}
@section('script')
<script>
   $('#guestSelect').on('change', function () {
       if ($(this).val() === 'add_new') {
           $(this).val('');
           $('#addCustomerModal').modal('show'); // ✅ BS4 WAY
       }
   });
   
   $('#cancel').on('click', function () {
       $('#addCustomerModal').modal('hide'); 
       $('#addCustomerForm')[0].reset();
   });
   
</script>
<script>
   $(document).on('click', '.add-row', function () {
   
       let row = $(this).closest('.service-row').clone();
   
       // Clear values
       row.find('input').val('');
   
       // Change add button to remove button
       row.find('.add-row')
           .removeClass('btn-success add-row')
           .addClass('btn-danger remove-row')
           .html('<i class="fa fa-minus"></i>');
   
       $('#service-wrapper').append(row);
   });
   
   $(document).on('click', '.remove-row', function () {
       $(this).closest('.service-row').remove();
   });
</script>
<script>
   $(document).on('change', '.discount-type', function () {
   
       let row = $(this).closest('.service-row');
       let label = row.find('.discount-label');
       let typeInput = row.find('input[name="discount_type[]"]');
   
       if ($(this).is(':checked')) {
           label.text('Percentage Discount');
           typeInput.val('percentage_discount');
       } else {
           label.text('Flat Discount');
           typeInput.val('flat_discount');
       }
   });
</script>
<script>
   $('#countrySelect').on('change', function () {
   
       let country     = $(this).val();
       let taxWrapper  = $('#taxWrapper');
       let taxLabel    = $('#taxLabel');
       let taxInput    = taxWrapper.find('input');
       let currencyInp = $('#currencyInput');
   
       if (country === 'India') {
   
           taxLabel.text('GST Percentage');
           taxInput.attr('placeholder', '18');
           taxWrapper.removeClass('d-none');
   
           currencyInp.val('INR ₹');
   
       } 
       else if (country === 'England') {
   
           taxLabel.text('VAT Percentage');
           taxInput.attr('placeholder', '12');
           taxWrapper.removeClass('d-none');
   
           currencyInp.val('GBP £');
   
       } 
       else if (country === 'USA') {
   
           taxLabel.text('Sales Tax Percentage');
           taxInput.attr('placeholder', '13');
           taxWrapper.removeClass('d-none');
   
           currencyInp.val('USD $');
   
       } 
       else {
           taxWrapper.addClass('d-none');
           taxInput.val('');
           currencyInp.val('');
       }
   });
</script>
{{-- ================= --}}
{{-- <script>
   function calculateRow(row) {
   
       let qty         = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
       let unitPrice   = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
       let discountVal = parseFloat(row.find('input[name="discount[]"]').val()) || 0;
       let discountType= row.find('input[name="discount_type[]"]').val();
   
       let total = qty * unitPrice;
       let discountAmount = 0;
   
       if (discountType === 'percentage_discount') {
           discountAmount = (total * discountVal) / 100;
       } else {
           discountAmount = discountVal;
       }
   
       let subtotal = total - discountAmount;
       if (subtotal < 0) subtotal = 0;
   
       row.find('input[name="sub_total[]"]').val(subtotal.toFixed(2));
   
       calculateInvoiceTotals();
   }
   
   function calculateInvoiceTotals() {
   
       let taxPercent = parseFloat($('input[name="tax"]').val()) || 0;
       let totalTax   = 0;
       let grandTotal = 0;
   
       $('input[name="sub_total[]"]').each(function () {
   
           let subtotal = parseFloat($(this).val()) || 0;
           let taxAmt = (subtotal * taxPercent) / 100;
   
           totalTax += taxAmt;
           grandTotal += subtotal + taxAmt;
       });
   
       $('#totalTax').val(totalTax.toFixed(2));
       $('#grandTotal').val(grandTotal.toFixed(2));
   }
   
   /* Live recalculation */
   $(document).on(
       'input change',
       'input[name="quantity[]"], input[name="unit_price[]"], input[name="discount[]"], input[name="tax"], .discount-type',
       function () {
           let row = $(this).closest('.service-row');
           calculateRow(row);
       }
   );
   
   /* Discount type toggle */
   $(document).on('change', '.discount-type', function () {
   
       let row = $(this).closest('.service-row');
       let label = row.find('.discount-label');
       let typeInput = row.find('input[name="discount_type[]"]');
   
       if ($(this).is(':checked')) {
           label.text('Percentage Discount');
           typeInput.val('percentage_discount');
       } else {
           label.text('Flat Discount');
           typeInput.val('flat_discount');
       }
   
       calculateRow(row);
   });
</script> --}}
<script>
   function calculateRow(row) {
   
       let qty         = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
       let unitPrice  = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
       let discount   = parseFloat(row.find('input[name="discount[]"]').val()) || 0;
       let discType   = row.find('input[name="discount_type[]"]').val();
       let taxPct     = parseFloat(row.find('input[name="tax_percent[]"]').val()) || 0;
       let taxType    = row.find('select[name="tax_type[]"]').val();
   
       /* 1️⃣ BASE AMOUNT */
       let baseAmount = qty * unitPrice;
   
       /* 2️⃣ DISCOUNT */
       let discountAmount = 0;
   
       if (discount > 0) {
           if (discType === 'percentage_discount') {
               discountAmount = (baseAmount * discount) / 100;
           } else {
               discountAmount = discount;
           }
       }
   
       let amountAfterDiscount = baseAmount - discountAmount;
       if (amountAfterDiscount < 0) amountAfterDiscount = 0;
   
       /* 3️⃣ TAX */
       let taxAmount = 0;
       let subtotal  = 0;
   
       if (taxPct > 0) {
   
           if (taxType === 'inclusive') {
               taxAmount = amountAfterDiscount - (amountAfterDiscount / (1 + taxPct / 100));
               subtotal  = amountAfterDiscount;
           } 
           else {
               taxAmount = (amountAfterDiscount * taxPct) / 100;
               subtotal  = amountAfterDiscount + taxAmount;
           }
   
       } else {
           subtotal = amountAfterDiscount;
       }
   
       row.find('input[name="sub_total[]"]').val(subtotal.toFixed(2));
   
       calculateInvoiceTotals();
   }
   
   function calculateInvoiceTotals() {
   
       let totalTax = 0;
       let grandTotal = 0;
   
       $('.service-row').each(function () {
   
           let row = $(this);
   
           let qty       = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
           let unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
           let discount  = parseFloat(row.find('input[name="discount[]"]').val()) || 0;
           let discType  = row.find('input[name="discount_type[]"]').val();
           let taxPct    = parseFloat(row.find('input[name="tax_percent[]"]').val()) || 0;
           let taxType   = row.find('select[name="tax_type[]"]').val();
   
           let base = qty * unitPrice;
   
           let discountAmount = 0;
           if (discount > 0) {
               discountAmount = (discType === 'percentage_discount')
                   ? (base * discount) / 100
                   : discount;
           }
   
           let discounted = base - discountAmount;
           if (discounted < 0) discounted = 0;
   
           let tax = 0;
   
           if (taxPct > 0) {
               if (taxType === 'inclusive') {
                   tax = discounted - (discounted / (1 + taxPct / 100));
               } else {
                   tax = (discounted * taxPct) / 100;
               }
           }
   
           totalTax += tax;
           grandTotal += discounted + (taxType === 'exclusive' ? tax : 0);
       });
   
       $('#totalTax').val(totalTax.toFixed(2));
       $('#grandTotal').val(grandTotal.toFixed(2));
   }
   
   /* LIVE RECALC */
   $(document).on(
       'input change',
       `
       input[name="quantity[]"],
       input[name="unit_price[]"],
       input[name="discount[]"],
       input[name="tax_percent[]"],
       select[name="tax_type[]"],
       .discount-type
       `,
       function () {
           calculateRow($(this).closest('.service-row'));
       }
   );
   
   /* DISCOUNT TYPE TOGGLE */
   $(document).on('change', '.discount-type', function () {
   
       let row = $(this).closest('.service-row');
       let label = row.find('.discount-label');
       let typeInput = row.find('input[name="discount_type[]"]');
   
       if ($(this).is(':checked')) {
           label.text('Percentage Discount');
           typeInput.val('percentage_discount');
       } else {
           label.text('Flat Discount');
           typeInput.val('flat_discount');
       }
   
       calculateRow(row);
   });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentDateInput = document.getElementById('paymentDate');
        const emailSendDateInput = document.getElementById('invoice_send');

        function validateDates() {
            const paymentDate = paymentDateInput.value;
            const emailSendDate = emailSendDateInput.value;

            if (paymentDate && emailSendDate) {
                if (emailSendDate >= paymentDate) {
                    alert('Email Send Date must be BEFORE the Payment Date.');
                    emailSendDateInput.value = '';
                    emailSendDateInput.focus();
                }
            }
        }

        paymentDateInput.addEventListener('change', validateDates);
        emailSendDateInput.addEventListener('change', validateDates);
    });
</script>
@endsection