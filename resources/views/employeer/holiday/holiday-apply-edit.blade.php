@extends('employeer.include.app')
@section('title', 'Holiday Apply')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('orgaization/holiday-dashboard')}}">Holiday Dashboard</a></li>
               <li class="breadcrumb-item active">Holiday Apply</li>
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i>  Holiday Apply</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="{{ route('holiday.applications.update', $application->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="holiday_type2_id">Holiday Type</label>
                                            <select name="holiday_type2_id" id="holiday_type2_id" class="select" required>
                                                <option value="">Select Holiday Type</option>
                                                @foreach($holidayTypes as $type)
                                                    <option value="{{ $type->id }}" {{ $application->holiday_type2_id == $type->id ? 'selected' : '' }}>
                                                        {{ $type->holiday_type_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_id">Employee</label>
                                            <select name="employee_id" id="employee_id" class="select" required>
                                                <option value="">Select Employee</option>
                                                @foreach($activeEmployees as $employee)
                                                    <option value="{{ $employee->employee_id }}" {{ $application->employee_id == $employee->employee_id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Leave Type</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="holiday_types" id="day_wise" 
                                                       value="days" {{ $application->holiday_types == 'days' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_wise">Day Wise</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="holiday_types" id="hourly_wise" 
                                                       value="hour" {{ $application->holiday_types == 'hour' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hourly_wise">Hourly Wise</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="form_date">Date</label>
                                            <input type="date" class="form-control" id="form_date" name="form_date" 
                                                   value="{{ \Carbon\Carbon::parse($application->form_date)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group day-field" style="{{ $application->holiday_types == 'days' ? 'display:block' : 'display:none' }}">
                                            <label for="no_of_days">Number of Days</label>
                                            <input type="number" class="form-control" id="no_of_days" name="no_of_days" 
                                                   min="1" step="1" value="{{ $application->no_of_days }}">
                                        </div>
                                        
                                        <div class="hour-field" style="{{ $application->holiday_types == 'hour' ? 'display:block' : 'display:none' }}">
                                            <div class="form-group">
                                                <label for="hour">Hours</label>
                                                <input type="number" class="form-control" id="hour" name="hour" 
                                                       min="1" step="1" value="{{ $application->hour }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('holiday.applications.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>                       
                        </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get DOM elements
        const dayRadio = document.getElementById('day_wise');
        const hourRadio = document.getElementById('hourly_wise');
        const dayField = document.querySelector('.day-field');
        const hourField = document.querySelector('.hour-field');
        const daysInput = document.getElementById('no_of_days');
        const hoursInput = document.getElementById('hour');
    
        // Function to toggle fields visibility
        function toggleFields() {
            if (dayRadio.checked) {
                // Show day field, hide hour field
                dayField.style.display = 'block';
                hourField.style.display = 'none';
                
                // Set required attributes
                daysInput.setAttribute('required', 'required');
                hoursInput.removeAttribute('required');
                
                // Clear hour value when switching to days
                hoursInput.value = '';
            } else {
                // Show hour field, hide day field
                dayField.style.display = 'none';
                hourField.style.display = 'block';
                
                // Set required attributes
                hoursInput.setAttribute('required', 'required');
                daysInput.removeAttribute('required');
                
                // Clear day value when switching to hours
                daysInput.value = '';
            }
        }
    
        // Add event listeners
        dayRadio.addEventListener('change', toggleFields);
        hourRadio.addEventListener('change', toggleFields);
        
        // Initialize on page load
        toggleFields();
    
        // Ensure only whole numbers are entered
        function validateIntegerInput(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value === '0') this.value = '1';
            });
        }
    
        validateIntegerInput(daysInput);
        validateIntegerInput(hoursInput);
    });
    </script>
@endsection