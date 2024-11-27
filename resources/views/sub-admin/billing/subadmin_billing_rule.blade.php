@foreach($organization as $org)
    {{$org->com_name}}
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
                            <input type="text" name="type" value="employer" hidden>
                            <input type="text" name="org_code" value="{{ $code->org_code }}" hidden>
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
                            <label for="employee_charge" class="form-label">Employee Charge</label>
                            <input type="number" name="employee_charge" id="employee_charge" class="form-control" step="0.01" style="margin-top: 10px;">
                        </div>
                        {{-- <div class="col-md-4" id="max_org">
                            <label for="max_organizations" class="form-label">Max Organizations</label>
                            <input type="number" name="max_organizations" id="max_organizations" class="form-control" style="margin-top: 10px;">
                        </div> --}}
                        <div class="col-md-4">
                            <label for="min_employees" class="form-label">Min Employees</label>
                            <input type="number" name="min_employees" id="min_employees" class="form-control" style="margin-top: 10px;">
                        </div>
                        <div class="col-md-4">
                            <label for="max_employees" class="form-label">Max Employees</label>
                            <input type="number" name="max_employees" id="max_employees" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="payment_date_range" class="form-label">Payment Date Range</label>
                            <input type="text" name="payment_date_range" id="payment_date_range" class="form-control" maxlength="50">
                            @error('payment_date_range')
                                <div class="text-danger">{{ $message }}</div>
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