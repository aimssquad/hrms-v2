
@extends('employeer.include.app')

@section('title', 'Payment Details')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')


<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Payment Details</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li>
					<li class="breadcrumb-item active">Payment Details</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
    @include('employeer.layout.message')
    <div class="row">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header">
                  <h3>Payment</h3>
              </div>
              <div class="card-body">
                  <form action="{{ url('organization/payment/update/' . $bills->id) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="row form-group">
                          <!-- Billing For Dropdown -->

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="invoice_no" class="form-label">Invoice No</label>
                                <input type="text" class="form-control" id="invoice_no" name="invoice_no" value="{{$bills->invoice_no}}" readonly>
                            </div>
                        </div>
                          
                    
                          
                          <!-- Billing Month Dropdown -->
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="date" class="form-label">Invoice Date</label>
                                  <input type="date" class="form-control" id="date" name="date" value="{{ $bills->date ?? '' }}" readonly>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="entity_id" class="form-label">Total Amount</label>
                                  <input type="text" class="form-control" id="total_amount" name="total_amount" value="@if($bills->vat == null || $bills->discount_amount == null) {{$bills->amount}} @else {{$bills->total_amount}} @endif"readonly>
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
                                <label for="payment_dtl" class="form-label">Payment Details</label>
                                <input type="text" class="form-control" id="payment_dtl" name="payment_dtl" required>
                            </div>
                        </div>
                          
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="payment_description" class="form-label">Payment Description</label>
                                  <input type="text" class="form-control" id="payment_description" name="payment_description" required>
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
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
</script>

@endsection
