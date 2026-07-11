@extends('employeer.include.app')
@section('title', isset($guest) ? 'Edit Client' : 'Add New Client')

@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                  @if(isset($_GET['id']))
                  <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Edit Client')}}</li>
                  @else
                  <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Add Client')}}</li>
                  @endif
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                    <h4 class="card-title">
                        {{ isset($guest) ? 'Edit Client' : 'Add New Client' }}
                    </h4>
                     
                  </div>
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                  @endif
                  @if(Session::has('error'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('error') }}</div>
                  @endif
                  <div class="card-body">
                     <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                                <form action="{{ route('organization.guest.save') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $guest->id ?? '' }}">

                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Client ID *') }}</label>
                                            <input type="text"
                                            class="form-control"
                                            name="guest_id"
                                            readonly
                                            value="{{ old(
                                                    'guest_id',
                                                    $guest->guest_id ?? $guest_id ?? ''
                                            ) }}">
                                                
                                            @error('guest_id')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div> 

                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Company Name *') }}</label>
                                            <input type="text" class="form-control" name="company_name"
                                                value="{{ old('company_name', $guest->company_name ?? '') }}">
                                                
                                            @error('company_name')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Name *') }}</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $guest->name ?? '') }}">
                                                
                                            @error('name')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Designation') }}</label>
                                            <input type="text" class="form-control" name="designation"
                                                value="{{ old('designation', $guest->designation ?? '') }}">
                                                
                                            @error('designation')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Email *') }}</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', $guest->email ?? '') }}">
                                                
                                            @error('email')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Contact No *') }}</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ old('phone', $guest->phone ?? '') }}">
                                                
                                            @error('phone')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-form-label">
                                                {{ \App\Helpers\Helper::cachedTrans('Status *') }}
                                            </label>

                                            <select name="status" class="form-control">
                                                <option value="">-- Select Status --</option>
                                                <option value="1"
                                                    {{ old('status', $guest->status ?? '') == '1' ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $guest->status ?? '') == '0' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>

                                            @error('status')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    </br>
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($guest) ? 'Update' : 'Submit' }}
                                    </button>
                                </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection