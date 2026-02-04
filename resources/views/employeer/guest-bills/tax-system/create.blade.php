@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Add Tax System'))
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Add Tax System')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Add Tax System')}} </li>
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
                    <h4 class="card-title"><i class="fa fa-gbp" style="color:rgb(253, 124, 3)"></i>  {{\App\Helpers\Helper::cachedTrans('Add New Tax System')}}</h4>
                </div>
                <div class="card-body">
                    <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                            <div class="col-12 col-lg-12 m-auto">
                                <form action="{{ url('organization/store-currency') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row form-group">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Tax System Name')}}</label>
                                                <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name"
                                                        value="" placeholder="GST, VAT, SALES_TAX">

                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Coubtry Code')}}</label>
                                                <input type="text"
                                                    class="form-control @error('country_code') is-invalid @enderror"
                                                    name="country_code"
                                                    value="">

                                                @error('country_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Status')}}</label>
                                                <select class="select" name="is_multi_stage" id="">
                                                    <option value="">-- Select --</option>
                                                    <option value="1">Active</option>  
                                                    <option value="0">Inactive</option>  
                                                </select>        

                                                    @error('is_multi_stage')
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
