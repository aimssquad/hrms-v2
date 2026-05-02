@php
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
$user_type = Session::get("user_type"); 
@endphp  
<?php

    use App\Models\TaskManagement\ProjectMembers;
    use App\User;

    $usetype = Session::get('user_type');
    $project_id = decrypt(request()->route('id'));
    //dd($project_id);    
    if ($usetype == 'employee') {
        $usemail = Session::get('user_email');
        $users_id = Session::get('users_id');
        $dtaem = DB::table('users')

            ->where('id', '=', $users_id)
            ->first();
        $Roles_auth = DB::table('role_authorization')
            ->where('emid', '=', $dtaem->emid)

            ->where('member_id', '=', $dtaem->email)
            ->get()->toArray();
        $arrrole = array();
        foreach ($Roles_auth as $valrol) {
            $arrrole[] = $valrol->menu;
        }
    }

    $project_name_sidebar = DB::table('projects')
        ->where('id', $project_id)
        //->where('status', 'open')
        ->select('title')
        ->first();
    //dd($project_id);

?>
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
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul class="sidebar-vertical">
                    
                                <li class="menu-title">
                                    @if(!empty($project_name_sidebar))
                                        <span> <i class="fa-solid fa-folder"></i>&nbsp; &nbsp; {{\App\Helpers\Helper::cachedTrans("$project_name_sidebar->title")}}</span>
                                    @endif
                                </li>
                                <li class="submenu">
                                    <span><a href="{{url('org-task-management/dashboard')}}"> <i class="fa-solid fa-gauge me-2"></i>&nbsp;&nbsp; {{\App\Helpers\Helper::cachedTrans("All Project Dashboard")}}</a></span>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube {{Request::is('org-employeecornerorganisationdashboard')?'noti-dot':'';}}"></i> <span> {{\App\Helpers\Helper::cachedTrans('Project Management')}}</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <?php
                            // echo $usetype;
                            // die;
                            if ($usetype == 'employee') {
                                // if (in_array('67', $arrrole)) {

                                $currentEmpDetails = User::select('users.*', 'e.id as emp_id')
                                    ->leftJoin('employee as e', 'e.emp_code', '=', 'users.employee_id')
                                    ->where('users.id', $users_id)->first();
                                $currentMember =  ProjectMembers::where(['project_id' => $project_id, 'user_id' => $currentEmpDetails->emp_id])->first();
                                // print_r($currentEmpDetails);
                                // die;
                                if (strtolower($currentMember->role) == 'manager' || strtolower($currentMember->role) == 'owner') {
                                ?> <li >
                                        <a href="{{ url('org-task-management/'.request()->route('id').'/project-members') }}" class="la la-cube">
                                            <span class="sub-item la la-cube">{{\App\Helpers\Helper::cachedTrans('Members')}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('org-task-management/'.request()->route('id').'/tasks')}}">
                                            <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Tasks')}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('org-task-management/'.request()->route('id').'/labels')}}">
                                            <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Master Labels')}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('org-task-management/'.request()->route('id').'/roles')}}">
                                            <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Master Roles')}}</span>
                                        </a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <!-- <li>
                                        <a href="{{ url('org-task-management/'.request()->route('id').'/project-members') }}">
                                            <span class="sub-item">Members</span>
                                        </a>
                                    </li> -->
                                    <li>
                                        <a href="{{ url('org-task-management/'.request()->route('id').'/tasks')}}">
                                            <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Tasks')}}</span>
                                        </a>
                                    </li>

                                <?php
                                }
                                ?>

                            <?php
                            } else {
                            ?>
                                <li>
                                    <a href="{{ url('org-task-management/project-analitic-dashboard/'.request()->route('id')) }}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('org-project-control/'.request()->route('id').'/project-roles')}}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Roles')}}</span>
                                    </a>
                                </li>
                                 <li>
                                    <a href="{{ url('org-project-control/'.request()->route('id').'/permission-master')}}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Master Permission')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('org-project-control/'.request()->route('id').'/role-permission-list')}}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Permission')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('org-project-control/'.request()->route('id').'/project-members') }}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Members')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('org-project-control/'.request()->route('id').'/project-modules') }}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Module')}}</span>
                                    </a>
                                </li>
                                <li >
                                    <a href="{{ url('org-task-management/'.request()->route('id').'/tasks')}}">
                                        <span class="sub-item ">{{\App\Helpers\Helper::cachedTrans('Tasks')}}</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ url('org-task-management/'.request()->route('id').'/labels')}}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Master Labels')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('org-project-control/'.request()->route('id').'/project-roles')}}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Master Roles')}}</span>
                                    </a>
                                </li> --}}

                                

                                 <li>
                                    <a href="{{ url('org-task-management/'.request()->route('id').'/chat')}}">
                                        <span class="sub-item">{{\App\Helpers\Helper::cachedTrans('Chat With Member')}}</span>
                                    </a>
                                </li>

                            <?php
                            }

                            ?>
                                    </ul>
                                </li>

                </ul>

            </div>
            <div class="bg-white ps-2 pe-2 sidebar_bottom">
                <div class="d-flex">
                    <p class="mt-2 mb-0">Powered By</p><div class="float-end ms-3"><img width="70px" src="https://skilledworkerscloud.co.uk/hrms-v2/frontend/assets/img/swch_logo.png"/></div>
                </div>
                <p class="text-dark pb-1" style="font-size:10px;">© {{ date('Y') }} SWCH - HRMS | All Right Reserved |</p>
            </div>
        </div>
    </div>
    <!-- /Sidebar -->
  