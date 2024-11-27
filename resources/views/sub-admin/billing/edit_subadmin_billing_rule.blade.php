{{-- @foreach($organization as $org)
    {{$org->com_name}}
@endforeach --}}

@extends('sub-admin.include.app')
@section('title', ' Billing Rule')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title"> Edit Billing Rule</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
               {{-- <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li> --}}
               <li class="breadcrumb-item active"> Edit Billing Rule</li>
            </ul>
         </div>
         {{-- <div class="col-auto float-end ms-auto">
            <a href="{{ url('sub-admin/billing-rule') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add  Billing Rule</a>
         </div> --}}
      </div>
   </div>
   <!-- /Page Header -->
   @include('sub-admin.layout.message')
   
   <div class="row">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Billing Rule</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subadmin.billing-rule.update', $rule->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="POST">
                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <label for="type" class="form-label">Billing Type</label>
                                    <select class="form-control input-border-bottom" id="billing_type" name="type" required onchange="getBillingEntities(this.value);">
                                        <option value="">&nbsp;</option>
                                        <option value="employer" {{ $rule->type == 'employer' ? 'selected' : '' }}>Organisation</option>
                                        <option value="sub-admin" {{ $rule->type == 'sub-admin' ? 'selected' : '' }}>Subadmin</option>
                                    </select>
                                </div> --}}
                                @php 
                                    $copany_name = DB::table('registration')
                                        ->where('reg', $rule->entity_id)->first();
                                @endphp
                                <div class="col-md-4">
                                    <label for="entity_id" class="form-label">Entity ID</label>
                                    <input type="text" class="form-control" name="entity_id" value="{{ $rule->entity_id }}" hidden>
                                    <input type="text" class="form-control"  value="{{ $copany_name->com_name }}" readonly>
                                    {{-- <select class="form-control input-border-bottom" id="entity_id" name="entity_id" required >
                                        <option value="{{ $rule->entity_id }}">{{ $rule->entity_id }}</option>
                                    </select> --}}
                                </div>
                                <div class="col-md-4">
                                    <label for="employee_charge" class="form-label">Employee Charge</label>
                                    <input type="number" name="employee_charge" id="employee_charge" class="form-control" step="0.01" value="{{ $rule->employee_charge }}">
                                </div>
                                {{-- <div class="col-md-4">
                                    <label for="max_organizations" class="form-label">Max Organizations</label>
                                    <input type="number" name="max_organizations" id="max_organizations" class="form-control" value="{{ $rule->max_organizations }}">
                                </div> --}}
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
<!-- /Page Content -->
@endsection
@section('script')

@endsection