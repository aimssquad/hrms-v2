@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Edit Customer'))
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Edit Customer')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{route('org.customer.dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Edit Customer')}} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa fa-user" style="color:rgb(253, 124, 3)"></i>  {{\App\Helpers\Helper::cachedTrans('Edit Customer')}}</h4>
                </div>
                <div class="card-body">
                    <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                            <div class="col-12 col-lg-12 m-auto">
                                <form action="{{ route('org.customer.update', base64_encode($customer->id)) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <input type="text" name="emid" value="{{$customer->emid}}" hidden>

                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Name')}}</label>
                                                <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name"
                                                        value="{{$customer->name}}" required>

                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Company Name')}}</label>
                                                <input type="text"
                                                    class="form-control @error('company_name') is-invalid @enderror"
                                                    name="company_name"
                                                    value="{{$customer->company_name}}">

                                                @error('company_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Designation')}}</label>
                                                <input type="text"
                                                    class="form-control @error('designation') is-invalid @enderror"
                                                    name="designation"
                                                    value="{{$customer->designation}}">

                                                @error('designation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Email')}}</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" required
                                                    value="{{$customer->email}}">

                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Phone')}}</label>
                                                <input type="text"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" required
                                                    value="{{$customer->phone}}">

                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Address')}}</label>
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address" required
                                                    value="{{$customer->address}}">

                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('GST/ VAT/ SALE-TAX')}}</label>
                                                <input type="text"
                                                    class="form-control @error('tax_no') is-invalid @enderror"
                                                    name="tax_no" required
                                                    value="{{$customer->tax_no}}">

                                                @error('tax_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Status')}}</label>
                                                <select class="select" name="status" id="" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="1" {{ $customer->status == 1 ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="0" {{ $customer->status == 0 ? 'selected' : '' }}>
                                                        Inactive
                                                    </option> 
                                                </select>        

                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                            </div>
                                        </div>
                                
                                    
                                    </div>
                                    <br>   
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">{{\App\Helpers\Helper::cachedTrans('Submit')}}</button>
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
    </div>
    </div>
</div>
@endsection
