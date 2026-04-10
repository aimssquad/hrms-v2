@php
    $email = Session::get('empsu_email');
    $subadmin_dtl = DB::table('sub_admin_registrations')->where('email',$email)->first();
    //dd($subadmin_dtl);
    if (!$subadmin_dtl) {
        Session::flush();
        header('Location: ' . url('/superadmin'));
        exit(); 
    }
@endphp
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                {{-- <li class="menu-title"> 
                    <span>Main</span>
                </li> --}}
                <li class="menu">
                    <a href="{{url('subadmin/profile')}}"><i class="la la-user"></i> <span> Partner Profile</span></a>
                    {{-- <ul>
                        <li><a href="{{url('superadmindasboard')}}">Dashboard</a></li>
                        <li><a href="{{url('subadmin/profile')}}">Profile</a></li>
                    </ul> --}}
                </li>
                <li class="menu">
                    <a href="{{url('superadmindasboard')}}"><i class="la la-home"></i> <span> Dashboard</span></a>
                    {{-- <ul>
                        <li><a href="{{url('superadmindasboard')}}">Dashboard</a></li>
                        <li><a href="{{url('subadmin/profile')}}">Profile</a></li>
                    </ul> --}}
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-building"></i> <span> Organisation</span> <span class="menu-arrow"></span></a>
                    <ul>
                        {{-- <li><a href="{{url('superadmin/active')}}">Active Organisation</a></li> --}}
                        <li><a href="{{url('superadmin/verify')}}">Active Organisation</a></li>
                        <li><a href="{{url('superadmin/notverify')}}">Not Approved Organisation</a></li>
                        <li><a href="{{url('subadmin/organization-employee')}}">Total Organization Employee</a></li>
                        {{-- <li><a href="{{url('superadmin/verify')}}">Approved Organisation</a></li> --}}
                    </ul>
                </li>
                {{-- <li class="menu-title"> 
                    <span>Billing</span>
                </li> --}}
                <li class="submenu">
                    <a href="#" class="noti-dot"><i class="las la-money-bill-wave-alt"></i> <span> Billing</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('superadmin/taxforbill')}}">Tax Master</a></li>
                        <!--<li><a href="{{url('superadmin/billing')}}">Billing</a></li>-->
                        <!--<li><a href="{{url('superadmin/payment-received')}}">Payment Received</a></li>-->
                        <!--<li><a href="{{url('superadmin/billing-report')}}">Report</a></li>-->
                        <!--<li><a href="{{url('superadmin/billing-search')}}">Billing Search</a></li>-->
                        <!--<li><a href="{{url('superadmin/payment-search')}}">Payment Received Search</a></li>-->
                        <li><a href="{{url('sub-admin/billing-rule-list')}}">Billing Rule</a></li>
                        <li><a href="{{url('sub-admin/billing-list')}}">Invoice List</a></li>
                        <li><a href="{{url('/sub-admin/all-bills')}}">Subscription Invoice</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="bg-white ps-2 pe-2 sidebar_bottom">
            <div class="d-flex">
                <p class="mt-2 mb-0">Powered By</p><div class="float-end ms-3">
                    {{-- <img width="70px" src="https://skilledworkerscloud.co.uk/hrms-v2/frontend/assets/img/swch_logo.png"/> --}}
                    @if(!empty($subadmin_dtl->logo))
                        <img src="{{asset('storage/app/public/' . $subadmin_dtl->logo)}}" alt="Logo" style="width: auto; height: 40px; object-fit: contain;">
                    @else
                        <img src="{{asset('assets/img/user.png')}}" alt="Company Logo" style="width: auto; height: 60px; object-fit: contain;"> 
                    @endif
                </div>
            </div>
            <p class="text-dark pb-1" style="font-size:10px;">© {{ date('Y') }}  | All Right Reserved |</p>
        </div>
    </div>
</div>

<style>
    .sidebar_bottom{
        position:fixed;
        width:250px;
        bottom:0;
        z-index:99;
    }
    .sidebar .sidebar-menu, .two-col-bar .sidebar-menu {
    padding-bottom: 75px;
}
@media(max-width:991px){
    .sidebar_bottom {
    position: fixed;
    width: 225px;
    bottom: 0;
}
}
</style>
<!-- Two Col Sidebar -->
@include('employeer.layout.side-settings')
<!-- /Two Col Sidebar -->
