@foreach($organization as $org)
    {{-- {{$org->com_name}} --}}
@endforeach

@extends('sub-admin.include.app')
@section('title', ' Billing Rule')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title"> Billing Rule</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
               {{-- <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li> --}}
               <li class="breadcrumb-item active"> Billing Rule</li>
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
                <h3>Billing Rule</h3>
            </div>
            <div class="card-body">
                <form action="{{url('sub-admin/billing-rule')}}" method="POST">
                    @csrf()
                    <div class="row">
                            <input type="hidden" name="type" value="employer" >
                            <input type="hidden" name="org_code" value="{{ $code->org_code }}" >
                            <input type="hidden" name="billing_for" value="Number Of Employee" >
                        <div class="col-md-4">
                            <label for="entity_id" class="form-label">Entity ID</label>
                            <select class="form-control input-border-bottom" id="entity_id" name="entity_id" required="" style="margin-top: 10px;" onchange="getUserDetails(this.value);">
                                <option value="">Select</option>
                                @foreach($organization as $org)
                                <option value="{{$org->reg}}">{{$org->com_name}}</option>
                                    {{$org->com_name}}
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="min_employees" class="form-label">Min Employees</label>
                            <input type="number" name="min_employees" id="min_employees" class="form-control" style="margin-top: 10px;">
                        </div>
                        <div class="col-md-4">
                            <label for="max_employees" class="form-label">Max Employees</label>
                            <input type="number" name="max_employees" id="max_employees" class="form-control" style="margin-top: 10px;">
                        </div>
                        <div class="col-md-4">
                            <label for="employee_charge" class="form-label">Employee Charge</label>
                            <input type="number" name="employee_charge" id="employee_charge" class="form-control" step="0.01" style="margin-top: 10px;">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="billing_mode" class="form-label">Billing Mode</label>
                                <select class="select" id="billing_mode" name="billing_mode" >
                                    <option value="">Select Billing Mode</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Half_yearly">Half Yearly</option>
                                    <option value="Annually">Annually</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="payment_date_from">From Date</label>
                            <input type="date" class="form-control @error('payment_date_from') is-invalid @enderror" 
                                   id="payment_date_from" name="payment_date_from" 
                                   value="{{ old('payment_date_from', $request->payment_date_from ?? '') }}" required>
                            @error('payment_date_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="payment_date_to">To Date</label>
                            <input type="date" class="form-control @error('payment_date_to') is-invalid @enderror" 
                                   id="payment_date_to" name="payment_date_to" 
                                   value="{{ old('payment_date_to', $request->payment_date_to ?? '') }}" required>
                            @error('payment_date_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                   
                    </br>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')

@endsection