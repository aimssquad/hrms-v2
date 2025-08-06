@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Organization Profile'))

@section('content')

<!-- Page Content -->
<div class="content container-fluid pb-0">
				
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> {{\App\Helpers\Helper::cachedTrans('Organization Profile')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Profile')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    @include('employeer.layout.message')
    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                @if($companies_rs->logo !="")
                                    <a href="#"><img src="{{ asset('storage/app/public/' . $companies_rs->logo) }}" alt="User Image"></a>
                                @else
                                    <a href="#"><img src="{{asset('assets/img/user.png')}}" alt="User "></a>
                                @endif
                                
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->com_name))}}</h3>
                                        <h6 class="text">{{\App\Helpers\Helper::cachedTrans('Status')}} - <span class="badge bg-inverse-success"> {{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->status))}}</span></h6>
                                        <h6 class="text">{{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->f_name ?? ''))}} {{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->l_name ?? ''))}}</h6>
                                        <div class="staff-id">{{\App\Helpers\Helper::cachedTrans('Orgnaization ID')}} : {{\App\Helpers\Helper::cachedTrans($companies_rs->reg)}}</div>
                                        <div class="staff-id">{{\App\Helpers\Helper::cachedTrans('Registration No')}} : {{\App\Helpers\Helper::cachedTrans($companies_rs->com_reg)}}</div>
                                        <div class="staff-id">{{\App\Helpers\Helper::cachedTrans('Type of Organisation')}} : {{\App\Helpers\Helper::cachedTrans($companies_rs->com_type)}}</div>
                                        <div class="staff-id">{{\App\Helpers\Helper::cachedTrans('Name of Sector')}} : {{\App\Helpers\Helper::cachedTrans($companies_rs->com_nat)}}</div>
                                        <div class="staff-id">{{\App\Helpers\Helper::cachedTrans('Trading Name')}} : {{\App\Helpers\Helper::cachedTrans($companies_rs->trad_name)}}</div>
                                        <div class="staff-id">{{\App\Helpers\Helper::cachedTrans('Trading Period')}} : {{\App\Helpers\Helper::cachedTrans($companies_rs->com_year)}}</div>
                                        <div class="small doj">{{\App\Helpers\Helper::cachedTrans('Date of Create')}} : {{\App\Helpers\Helper::cachedTrans(\Carbon\Carbon::parse($companies_rs->created_at)->format('j M Y'))}}</div>
                                        <div class="staff-msg">
                                            <a class="btn btn-custom" href="{{url('org-company-profile/pdf')}}?c_id={{base64_encode($companies_rs->id)}}"> {{\App\Helpers\Helper::cachedTrans('Download PDF')}}</a>
                                            <a class="btn btn-custom" href="{{url('org-company-profile/edit-company')}}?c_id={{base64_encode($companies_rs->id)}}"><i class="fa-solid fa-pencil"></i>Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">{{\App\Helpers\Helper::cachedTrans('Phone')}}:</div>
                                            <div class="text"><a href="#">{{\App\Helpers\Helper::cachedTrans( $companies_rs->p_no ?? '' )}}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">{{\App\Helpers\Helper::cachedTrans('Organization Email ID')}}:</div>
                                            <div class="text"><a href="#">{{\App\Helpers\Helper::cachedTrans($Roledata->organ_email ?? '' )}} </a></div>
                                        </li>
                                        <li>
                                            <div class="title">{{\App\Helpers\Helper::cachedTrans('Login Email ID')}}:</div>
                                            <div class="text"><a href="#">{{\App\Helpers\Helper::cachedTrans($companies_rs->email ?? '' )}} </a></div>
                                        </li>
                                        
                                        <li>
                                            <div class="title">{{\App\Helpers\Helper::cachedTrans('Password')}}:</div>
                                            <div class="text">{{$companies_rs->pass ?? '' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">{{\App\Helpers\Helper::cachedTrans('Address')}}:</div>
                                            <div class="text">{{\App\Helpers\Helper::cachedTrans($companies_rs->address ?? '')}} {{\App\Helpers\Helper::cachedTrans($companies_rs->address2 ?? '' )}} {{\App\Helpers\Helper::cachedTrans($companies_rs->road ?? '')}}  {{\App\Helpers\Helper::cachedTrans($companies_rs->city ?? '')}} {{\App\Helpers\Helper::cachedTrans($companies_rs->zip ?? '')}} </div>
                                        </li>
                                        <!--<li>-->
                                        <!--    <div class="title">Fax:</div>-->
                                        <!--    <div class="text">{{ $companies_rs->fax ?? '' }}</div>-->
                                        <!--</li>-->
                                        <li>
                                            <div class="title">{{\App\Helpers\Helper::cachedTrans('Website')}}:</div>
                                            <div class="text"><a href="{{ $companies_rs->website ?? '' }}" target="_blank">{{ $companies_rs->website ?? '' }}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">{{\App\Helpers\Helper::cachedTrans('Landline')}}:</div>
                                            <div class="text">{{ $companies_rs->land ?? '' }}</div>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card tab-box">
        <div class="row user-tabs">
            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a href="#emp_profile" data-bs-toggle="tab" class="nav-link active">{{\App\Helpers\Helper::cachedTrans('Profile')}}</a></li>
           
                    <li class="nav-item"><a href="#emp_assets" data-bs-toggle="tab" class="nav-link">{{\App\Helpers\Helper::cachedTrans('Employee (RTI)')}}</a></li>
                             <li class="nav-item"><a href="#bank_statutory" data-bs-toggle="tab" class="nav-link">{{\App\Helpers\Helper::cachedTrans('Trading Hours')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="tab-content">
    
        <!-- Profile Info Tab -->
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">{{\App\Helpers\Helper::cachedTrans('Authorised Person Details')}}  </h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Name')}}.</div>
                                    <div class="text">{{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->f_name ?? ''))}}  {{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->l_name ?? ''))}} </div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Designation')}}.</div>
                                    <div class="text">{{\App\Helpers\Helper::cachedTrans($companies_rs->desig)}}</div>
                                    {{-- {{ !empty($companies_rs->desig) ? $companies_rs->desig : 'N/A' }} --}}
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Phone No')}}.</div>
                                    <div class="text"><a href="#">{{ !empty($companies_rs->con_num) ? $companies_rs->con_num : 'N/A' }}</a></div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Email Id')}}.</div>
                                    <div class="text">{{ !empty($companies_rs->authemail) ? $companies_rs->authemail : 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Do you have a history of Criminal conviction/Bankruptcy?')}}</div>
                                    <div class="text">{{\App\Helpers\Helper::cachedTrans($companies_rs->bank_status)}}</div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Proof Of Id')}}.</div>
                                    <div class="text"><a href="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}" target="_blank"><img src="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}" height="50px" width="50px"/></a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">{{\App\Helpers\Helper::cachedTrans('Key Contact')}} </h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Name')}}.</div>
                                    <div class="text">{{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->key_f_name ?? ''))}} {{\App\Helpers\Helper::cachedTrans(ucfirst($companies_rs->key_l_name ?? ''))}}</div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Designation')}}.</div>
                                    <div class="text">{{\App\Helpers\Helper::cachedTrans($companies_rs->key_designation)}} </div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Phone No')}}.</div>
                                    <div class="text"><a href="#"> {{ !empty($companies_rs->key_phone) ? $companies_rs->key_phone : 'N/A' }}</a></div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Email Id')}}.</div>
                                    <div class="text"> {{ !empty($companies_rs->key_email) ? $companies_rs->key_email : 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Do you have a history of Criminal conviction/Bankruptcy?')}}</div>
                                    <div class="text">{{\App\Helpers\Helper::cachedTrans($companies_rs->key_bank_status)}}</div>
                                </li>
                                <li>
                                    <div class="title">{{\App\Helpers\Helper::cachedTrans('Proof Of Id')}}</div>
                                    <div class="text"><a href="{{ asset('storage/app/public/' . $companies_rs->key_proof) }}" target="_blank"><img src="{{ asset('storage/app/public/' . $companies_rs->key_proof) }}" height="50px" width="50px"/></a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">{{\App\Helpers\Helper::cachedTrans('Level 1 User')}} </h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap" id="level1">
                                    <thead>
                                        <tr>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Name')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Designation')}} </th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Phone No')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Email Id')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Do you have a history of Criminal conviction/Bankruptcy?')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Proof Of Id')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{\App\Helpers\Helper::cachedTrans($companies_rs->level_f_name)}} </td>
                                            <td>{{\App\Helpers\Helper::cachedTrans($companies_rs->level_designation )}} </td>
                                            <td>{{ !empty($companies_rs->level_phone) ? $companies_rs->level_phone : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level_email) ? $companies_rs->level_email : 'N/A' }}</td>
                                            <td>{{\App\Helpers\Helper::cachedTrans($companies_rs->level_bank_status)}} </td>
                                            <td>    
                                                @if (!empty($companies_rs->level_proof))
                                                    <a href="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}" target="_blank">
                                                        <img src="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}" height="50px" width="50px"/>
                                                    </a>
                                                @else
                                                    {{\App\Helpers\Helper::cachedTrans('No Proof Available')}}
                                                @endif    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">{{\App\Helpers\Helper::cachedTrans('Level 2 User')}}  </h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap" id="level2">
                                    <thead>
                                        <tr>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Name')}} </th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Designation')}}  </th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Phone No')}} </th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Email Id')}} </th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Do you have a history of Criminal conviction/Bankruptcy?')}} </th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Proof Of Id')}} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{\App\Helpers\Helper::cachedTrans($companies_rs->level2_f_name)}} </td>
                                            <td>{{\App\Helpers\Helper::cachedTrans($companies_rs->level2_designation)}} </td>
                                            <td>{{ !empty($companies_rs->level2_phone) ? $companies_rs->level2_phone : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level2_email) ? $companies_rs->level2_email : 'N/A' }}</td>
                                            <td>{{\App\Helpers\Helper::cachedTrans($companies_rs->level2_bank_status)}} </td>
                                            <td>	
                                                @if (!empty($companies_rs->level2_proof))
                                                    <a href="{{ asset('storage/app/public/' . $companies_rs->level2_proof) }}" target="_blank">
                                                        <img src="{{ asset('storage/app/public/' . $companies_rs->level2_proof) }}" height="50px" width="50px"/>
                                                    </a>
                                                @else
                                                    {{\App\Helpers\Helper::cachedTrans('No Proof Available')}} 
                                                @endif	
                                            </td>                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Info Tab -->
        
        
        <!-- Bank Statutory Tab -->
        <div class="tab-pane fade" id="bank_statutory">
            <div class="card">
                <div class="card-body">
                    <table class="table table-new custom-table mb-0 " >
                        <thead>
                            <tr>
                                <th class="text-left font-weight-bold">{{\App\Helpers\Helper::cachedTrans('Days')}} </th>
                                <th class="text-center font-weight-bold">{{\App\Helpers\Helper::cachedTrans('Status')}} </th>
                                <th class="text-center font-weight-bold">{{\App\Helpers\Helper::cachedTrans('Opening Time')}} </th>
                                <th class="text-center font-weight-bold">{{\App\Helpers\Helper::cachedTrans('Closing Time')}} </th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #fff; color: #333;">
                            <!-- Monday -->
                            <tr>
                                <td class="text-left">{{\App\Helpers\Helper::cachedTrans('Monday')}}</td>
                                <td class="text-center">{{\App\Helpers\Helper::cachedTrans($Roledata->mon_status)}}</td>
                                {{-- {{ $Roledata ? $Roledata->mon_status : 'N/A' }} --}}
                                <td class="text-center">{{ $Roledata ? $Roledata->mon_time : 'N/A' }}</td>
                                <td class="text-center">{{ $Roledata ? $Roledata->mon_close : 'N/A' }}</td>
                            </tr>
                            
                            <!-- Tuesday -->
                            <tr>
                                <td class="text-left">{{\App\Helpers\Helper::cachedTrans('Tuesday')}}</td>
                                <td class="text-center">{{\App\Helpers\Helper::cachedTrans($Roledata->tue_status)}}</td>
                                {{-- <td class="text-center">{{ $Roledata ? $Roledata->tue_status : 'N/A' }}</td> --}}
                                <td class="text-center">{{ $Roledata ? $Roledata->tue_time : 'N/A' }}</td>
                                <td class="text-center">{{ $Roledata ? $Roledata->tue_close : 'N/A' }}</td>
                            </tr>
                            
                            <!-- Wednesday -->
                            <tr>
                                <td class="text-left">{{\App\Helpers\Helper::cachedTrans('Wednesday')}}</td>
                                <td class="text-center">{{\App\Helpers\Helper::cachedTrans($Roledata->wed_status)}}</td>
                                {{-- <td class="text-center">{{ $Roledata ? $Roledata->wed_status : 'N/A' }}</td> --}}
                                <td class="text-center">{{ $Roledata ? $Roledata->wed_time : 'N/A' }}</td>
                                <td class="text-center">{{ $Roledata ? $Roledata->wed_close : 'N/A' }}</td>
                            </tr>
                            
                            <!-- Thursday -->
                            <tr>
                                <td class="text-left">{{\App\Helpers\Helper::cachedTrans('Thursday')}}</td>
                                <td class="text-center">{{\App\Helpers\Helper::cachedTrans($Roledata->thu_status)}}</td>
                                {{-- <td class="text-center">{{ $Roledata ? $Roledata->thu_status : 'N/A' }}</td> --}}
                                <td class="text-center">{{ $Roledata ? $Roledata->thu_time : 'N/A' }}</td>
                                <td class="text-center">{{ $Roledata ? $Roledata->thu_close : 'N/A' }}</td>
                            </tr>
                            
                            <!-- Friday -->
                            <tr>
                                <td class="text-left">{{\App\Helpers\Helper::cachedTrans('Friday')}}</td>
                                <td class="text-center">{{\App\Helpers\Helper::cachedTrans($Roledata->fri_status)}}</td>
                                {{-- <td class="text-center">{{ $Roledata ? $Roledata->fri_status : 'N/A' }}</td> --}}
                                <td class="text-center">{{ $Roledata ? $Roledata->fri_time : 'N/A' }}</td>
                                <td class="text-center">{{ $Roledata ? $Roledata->fri_close : 'N/A' }}</td>
                            </tr>
                            
                            <!-- Saturday -->
                            <tr>
                                <td class="text-left">{{\App\Helpers\Helper::cachedTrans('Saturday')}}</td>
                                <td class="text-center">{{\App\Helpers\Helper::cachedTrans($Roledata->sat_status)}}</td>
                                {{-- <td class="text-center">{{ $Roledata ? $Roledata->sat_status : 'N/A' }}</td> --}}
                                <td class="text-center">{{ $Roledata ? $Roledata->sat_time : 'N/A' }}</td>
                                <td class="text-center">{{ $Roledata ? $Roledata->sat_close : 'N/A' }}</td>
                            </tr>
                            
                            <!-- Sunday -->
                            <tr>
                                <td class="text-left">{{\App\Helpers\Helper::cachedTrans('Sunday')}}</td>
                                <td class="text-center">{{\App\Helpers\Helper::cachedTrans($Roledata->sun_status)}}</td>
                                {{-- <td class="text-center">{{ $Roledata ? $Roledata->sun_status : 'N/A' }}</td> --}}
                                <td class="text-center">{{ $Roledata ? $Roledata->sun_time : 'N/A' }}</td>
                                <td class="text-center">{{ $Roledata ? $Roledata->sun_close : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <!-- /Bank Statutory Tab -->
        
        <!-- Assets -->
        <div class="tab-pane fade" id="emp_assets">
            <div class="table-responsive table-newdatatable">
                <table class="table table-new custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Employee Name')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Department')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Job Type')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Job Title')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Immigration Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $employee_or_rs = DB::table('company_employee')->where('emid','=',$companies_rs->reg)->get();
                            //dd($employee_or_rs);
                            $countwmploor= count($employee_or_rs);
                        @endphp
                        @if ($countwmploor!=0)
                            @foreach($employee_or_rs as $empuprotgans)
                                @if ($empuprotgans->name!='')								
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{\App\Helpers\Helper::cachedTrans($empuprotgans->name)}} </td>
                                        <td>{{\App\Helpers\Helper::cachedTrans($empuprotgans->department )}} </td>
                                        <td>{{\App\Helpers\Helper::cachedTrans($empuprotgans->job_type)}} </td>
                                        <td>{{\App\Helpers\Helper::cachedTrans($empuprotgans->designation)}} </td>
                                        <td>{{\App\Helpers\Helper::cachedTrans($empuprotgans->immigration)}} </td>
                                    </tr>
                                @endif
                            @endforeach   
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /Assets -->
        
    </div>
</div>
<!-- /Page Content -->

<!-- Profile Modal -->
<div id="profile_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <img class="inline-block" src="{{ asset('frontend/assets/img/profiles/avatar-02.jpg')}}" alt="User Image">
                                <div class="fileupload btn">
                                    <span class="btn-text">edit</span>
                                    <input class="upload" type="file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">First Name</label>
                                        <input type="text" class="form-control" value="John">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Last Name</label>
                                        <input type="text" class="form-control" value="Doe">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Birth Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" value="05/06/1985">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Gender</label>
                                        <select class="select form-control">
                                            <option value="male selected">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Address</label>
                                <input type="text" class="form-control" value="4487 Snowbird Lane">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">State</label>
                                <input type="text" class="form-control" value="New York">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Country</label>
                                <input type="text" class="form-control" value="United States">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Pin Code</label>
                                <input type="text" class="form-control" value="10523">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Phone Number</label>
                                <input type="text" class="form-control" value="631-889-3206">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>Select Department</option>
                                    <option>Web Development</option>
                                    <option>IT Management</option>
                                    <option>Marketing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>Select Designation</option>
                                    <option>Web Designer</option>
                                    <option>Web Developer</option>
                                    <option>Android Developer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Reports To <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>-</option>
                                    <option>Wilmer Deluna</option>
                                    <option>Lesley Grauer</option>
                                    <option>Jeffery Lalor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Profile Modal -->

<!-- Personal Info Modal -->
<div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Passport No</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Passport Expiry Date</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Tel</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Nationality <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Religion</label>
                                <div class="cal-icon">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Marital status <span class="text-danger">*</span></label>
                                <select class="select form-control">
                                    <option>-</option>
                                    <option>Single</option>
                                    <option>Married</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Employment of spouse</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">No. of children </label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Personal Info Modal -->

<!-- Family Info Modal -->
<div id="family_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Family Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-scroll">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Family Member <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Date of birth <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Date of birth <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-plus-circle"></i> Add More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Family Info Modal -->

<!-- Emergency Contact Modal -->
<div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Primary Contact</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone 2</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Primary Contact</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone 2</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Emergency Contact Modal -->

<!-- Education Modal -->
<div id="education_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Education Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-scroll">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Oxford University" class="form-control floating">
                                            <label class="focus-label">Institution</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Computer Science" class="form-control floating">
                                            <label class="focus-label">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Starting Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Complete Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="BE Computer Science" class="form-control floating">
                                            <label class="focus-label">Degree</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Grade A" class="form-control floating">
                                            <label class="focus-label">Grade</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Oxford University" class="form-control floating">
                                            <label class="focus-label">Institution</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Computer Science" class="form-control floating">
                                            <label class="focus-label">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Starting Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Complete Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="BE Computer Science" class="form-control floating">
                                            <label class="focus-label">Degree</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Grade A" class="form-control floating">
                                            <label class="focus-label">Grade</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-plus-circle"></i> Add More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Education Modal -->

<!-- Experience Modal -->
<div id="experience_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Experience Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-scroll">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                            <label class="focus-label">Company Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="United States">
                                            <label class="focus-label">Location</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Web Developer">
                                            <label class="focus-label">Job Position</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                            </div>
                                            <label class="focus-label">Period From</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                            </div>
                                            <label class="focus-label">Period To</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                            <label class="focus-label">Company Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="United States">
                                            <label class="focus-label">Location</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Web Developer">
                                            <label class="focus-label">Job Position</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                            </div>
                                            <label class="focus-label">Period From</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                            </div>
                                            <label class="focus-label">Period To</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-plus-circle"></i> Add More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Experience Modal -->


@endsection

@section('script')
<script>
       $(document).ready(function() {
         $('#level1').DataTable({
         });
      
         $('#multi-filter-select').DataTable( {
             "pageLength": 5,
             initComplete: function () {
                 this.api().columns().every( function () {
                     var column = this;
                     var select = $('<select class="form-control"><option value=""></option></select>')
                     .appendTo( $(column.footer()).empty() )
                     .on( 'change', function () {
                         var val = $.fn.dataTable.util.escapeRegex(
                             $(this).val()
                             );
      
                         column
                         .search( val ? '^'+val+'$' : '', true, false )
                         .draw();
                     } );
      
                     column.data().unique().sort().each( function ( d, j ) {
                         select.append( '<option value="'+d+'">'+d+'</option>' )
                     } );
                 } );
             }
         });
      
         // Add Row
         $('#add-row').DataTable({
             "pageLength": 5,
         });
      
         var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
      
         $('#addRowButton').click(function() {
             $('#add-row').dataTable().fnAddData([
                 $("#addName").val(),
                 $("#addPosition").val(),
                 $("#addOffice").val(),
                 action
                 ]);
             $('#addRowModal').modal('hide');
      
         });
     });


     $(document).ready(function() {
         $('#level2').DataTable({
         });
      
         $('#multi-filter-select').DataTable( {
             "pageLength": 5,
             initComplete: function () {
                 this.api().columns().every( function () {
                     var column = this;
                     var select = $('<select class="form-control"><option value=""></option></select>')
                     .appendTo( $(column.footer()).empty() )
                     .on( 'change', function () {
                         var val = $.fn.dataTable.util.escapeRegex(
                             $(this).val()
                             );
      
                         column
                         .search( val ? '^'+val+'$' : '', true, false )
                         .draw();
                     } );
      
                     column.data().unique().sort().each( function ( d, j ) {
                         select.append( '<option value="'+d+'">'+d+'</option>' )
                     } );
                 } );
             }
         });
      
         // Add Row
         $('#add-row').DataTable({
             "pageLength": 5,
         });
      
         var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
      
         $('#addRowButton').click(function() {
             $('#add-row').dataTable().fnAddData([
                 $("#addName").val(),
                 $("#addPosition").val(),
                 $("#addOffice").val(),
                 action
                 ]);
             $('#addRowModal').modal('hide');
      
         });
     });
   
   
</script>
@endsection