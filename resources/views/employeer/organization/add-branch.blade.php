@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Add Branch Location'))
@section('content')
<div class="content container-fluid pb-0">
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            {{-- <h3 class="page-title">Add Branch Location</h3> --}}
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Add Branch Location')}} </li>
            </ul>
        </div>
    </div>
</div>
@include('employeer.layout.message')
{{-- <div class="main-panel"> --}}
{{-- <div class="content">
   <div class="page-inner"> --}}
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="fa fa-map-marker" style="color:rgb(253, 124, 3)"></i> {{\App\Helpers\Helper::cachedTrans('Add New Branch Location')}} </h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="{{ isset($location) ? url('organization/update-location/'.$location->id) : url('organization/save-location') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(isset($location))
                                    @method('PUT')
                                @endif
                                
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Branch Name')}} </label>
                                            <input type="text" class="form-control" name="branch_name" 
                                                value="{{ old('branch_name', isset($location) ? $location->branch_name : '') }}" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label">Branch Attendance Process</label>
                                            <select name="attendance_process" id="" class="select">
                                                <option value="">Select Attendance Process</option>
                                                <option value="Location Attendance">Location Attendance</option>
                                                <option value="Biometric Attendance">Biometric Attendance</option>
                                                <option value="Others Attendance">Others Attendance</option>
                                            </select>  
                                            
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label"> {{\App\Helpers\Helper::cachedTrans('Branch Attendance Process')}} </label>
                                            <select name="attendance_process" class="select @error('attendance_process') is-invalid @enderror" required>
                                                <option value="">{{\App\Helpers\Helper::cachedTrans('Select')}} </option>
                                                <option value="Location Attendance" 
                                                    @if(old('attendance_process', isset($location->attendance_process) ? $location->attendance_process : '') == 'Location Attendance') selected @endif>
                                                    {{\App\Helpers\Helper::cachedTrans('Location Attendance')}} 
                                                </option>
                                                <option value="Biometric Attendance"
                                                    @if(old('attendance_process', isset($location->attendance_process) ? $location->attendance_process : '') == 'Biometric Attendance') selected @endif>
                                                    {{\App\Helpers\Helper::cachedTrans('Biometric Attendance')}} 
                                                </option>
                                                <option value="Others Attendance"
                                                    @if(old('attendance_process', isset($location->attendance_process) ? $location->attendance_process : '') == 'Others Attendance') selected @endif>
                                                    {{\App\Helpers\Helper::cachedTrans('Others Attendance')}} 
                                                </option>
                                            </select>
                                            @error('attendance_process')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Branch Address')}} </label>
                                            <input type="text" name="branch_location" class="form-control" 
                                                value="{{ old('branch_location', isset($location) ? $location->branch_location : '') }}" required>
                                        </div>
                                    </div>
                                  
                                    
                                    {{-- <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label">My Coordinate</label>
                                            <button type="button" id="get-location-btn" class="btn btn-primary btn-block pb-2 form-control">
                                                <i class="fas fa-location"></i>My Coordinate
                                            </button>
                                        </div>
                                    </div> --}}
                                    
                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label for="latitude" style="width:100%" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Latitude')}} </label>
                                            <input id="latitude" type="text" class="form-control input-border-bottom" name="latitude" 
                                                value="{{ old('latitude', isset($location) ? $location->latitude : ($Roledata->latitude ?? '0.00')) }}" >
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label for="longitude" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Longitude')}} </label>
                                            <input id="longitude" type="text" class="form-control input-border-bottom" name="longitude" 
                                                value="{{ old('longitude', isset($location) ? $location->longitude : ($Roledata->longitude ?? '0.00')) }}" >
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label for="radius" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Organization Radius (Meter)')}} </label>
                                            <input id="radius" type="text" class="form-control input-border-bottom" name="radius" 
                                                value="{{ old('radius', isset($location) ? $location->radius : ($Roledata->org_radious ?? '')) }}" >
                                        </div>
                                    </div>
                                </div>
                                
                                <br>   
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($location) ? \App\Helpers\Helper::cachedTrans('Update') : \App\Helpers\Helper::cachedTrans('Save') }}
                                        </button>
                                    </div>
                                </div> 
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   {{-- </div>
</div> --}}
@endsection
@section('script')
    {{-- <script>
        document.getElementById('get-location-btn').addEventListener('click', function() {
        const status = document.createElement('p');
        status.className = 'text-muted small mt-2';
        this.parentNode.appendChild(status);
        
        status.textContent = "Locating...";
        this.disabled = true;
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                    function(position) {
                    // Success
                    document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                    document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
                    status.textContent = "Location found!";
                    setTimeout(() => status.remove(), 2000);
                    },
                    function(error) {
                    // Error Handling
                    let errorMessage;
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                                errorMessage = "You denied the location request.";
                                break;
                        case error.POSITION_UNAVAILABLE:
                                errorMessage = "Location information unavailable.";
                                break;
                        case error.TIMEOUT:
                                errorMessage = "Location request timed out.";
                                break;
                        default:
                                errorMessage = "Unknown error occurred.";
                    }
                    status.textContent = "Error: " + errorMessage;
                    this.disabled = false;
                    }.bind(this),
                    {
                    enableHighAccuracy: true,  // GPS if available
                    timeout: 10000,           // 10 seconds max
                    maximumAge: 0             // Force fresh location
                    }
            );
        } else {
            status.textContent = "Geolocation is not supported by your browser.";
            this.disabled = false;
        }
        });
    </script> --}}
   
@endsection

