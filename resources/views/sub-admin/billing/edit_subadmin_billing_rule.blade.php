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
                            {{-- @method('PUT') <!-- Add this for proper update requests --> --}}
                        
                            <div class="row">
                                <!-- Hidden fields -->
                                <input type="hidden" name="billing_for" value="Number Of Employee">
                                <input type="hidden" name="type" value="employer">
                                <input type="hidden" name="entity_id" value="{{ $rule->entity_id }}">
                        
                                <!-- Company Name Display -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Company Name</label>
                                        @php 
                                            $company = DB::table('registration')
                                                ->where('reg', $rule->entity_id)
                                                ->first();
                                        @endphp
                                        <input type="text" class="form-control" value="{{ $company->com_name ?? 'N/A' }}" readonly>
                                    </div>
                                </div>
                        
                                <!-- Min/Max Employees -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="min_employees" class="form-label">Min Employees</label>
                                        <input type="number" name="min_employees" id="min_employees" 
                                               class="form-control @error('min_employees') is-invalid @enderror" 
                                               value="{{ old('min_employees', $rule->min_employees) }}" min="1" required>
                                        @error('min_employees')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="max_employees" class="form-label">Max Employees</label>
                                        <input type="number" name="max_employees" id="max_employees" 
                                               class="form-control @error('max_employees') is-invalid @enderror" 
                                               value="{{ old('max_employees', $rule->max_employees) }}" min="1" required>
                                        @error('max_employees')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                        
                                <!-- Employee Charge -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="employee_charge" class="form-label">Employee Charge</label>
                                        <input type="number" name="employee_charge" id="employee_charge" 
                                               class="form-control @error('employee_charge') is-invalid @enderror" 
                                               step="0.01" min="0" 
                                               value="{{ old('employee_charge', $rule->employee_charge) }}" required>
                                        @error('employee_charge')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                        
                                <!-- Billing Mode -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="billing_mode" class="form-label">Billing Mode</label>
                                        <select class="select @error('billing_mode') is-invalid @enderror" 
                                                id="billing_mode" name="billing_mode" required>
                                            <option value="">Select Billing Mode</option>
                                            @foreach(['Monthly', 'Quarterly', 'Half_yearly', 'Annually'] as $mode)
                                                <option value="{{ $mode }}" 
                                                    {{ old('billing_mode', $rule->billing_mode) == $mode ? 'selected' : '' }}>
                                                    {{ str_replace('_', ' ', $mode) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('billing_mode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                        
                                <!-- Date Range -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_date_from">From Date</label>
                                        <input type="date" class="form-control @error('payment_date_from') is-invalid @enderror" 
                                               id="payment_date_from" name="payment_date_from" 
                                               value="{{ old('payment_date_from', $rule->payment_date_from ? \Carbon\Carbon::parse($rule->payment_date_from)->format('Y-m-d') : '') }}" required>
                                        @error('payment_date_from')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_date_to">To Date</label>
                                        <input type="date" class="form-control @error('payment_date_to') is-invalid @enderror" 
                                               id="payment_date_to" name="payment_date_to" 
                                               value="{{ old('payment_date_to', $rule->payment_date_to ? \Carbon\Carbon::parse($rule->payment_date_to)->format('Y-m-d') : '') }}" required>
                                        @error('payment_date_to')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('subadmin.rulelist') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
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