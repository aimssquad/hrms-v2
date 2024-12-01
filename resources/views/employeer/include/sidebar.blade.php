@php
    $sidebarItems = \App\Helpers\Helper::getSidebarItems();
    $user_type = Session::get("user_type");
    //dd($sidebarItems);
        $modules = [
        //    1 => [
        //     'title' => 'Organization',
        //     'icon' => 'las la-hotel',
        //     'route' => 'organization.home', // Set the main module route here
        //     'items' => [
        //         ['route' => 'organization.profile', 'label' => 'Profile'],
        //         ['route' => 'employees.rti', 'label' => 'Employees (RTI)'],
        //         ['route' => 'authorizing.officer', 'label' => 'Authorizing Officer'],
        //         ['route' => 'key.contact', 'label' => 'Key Contact'],
        //         ['route' => 'level1.user', 'label' => 'Level 1 User'],
        //         ['route' => 'level2.user', 'label' => 'Level 2 User'],
        //         ['url' => 'org-dashboarddetails', 'label' => 'Sponsor Compliances'],
        //     ]
        // ],
        1 => [
            'title' => 'Recruitment',
            'icon' => 'las la-clone',
            'route' => 'recruitment.dashboard',
            'items' => [
                ['route' => 'recruitment.dashboard', 'label' => 'Dashboard'],
                ['route' => 'recruitment.job-list', 'label' => 'Job List'],
                ['route' => 'recruitment.job-posting', 'label' => 'Job Posting'],
                ['route' => 'recruitment.job-published', 'label' => 'Job Published'],
                ['url' => 'org-recruitment/candidate', 'label' => 'Job Applied'],
                ['url' => 'org-recruitment/short-listing', 'label' => 'Short listing'],
                ['url' => 'org-recruitment/interview', 'label' => 'Interview'],
                ['url' => 'org-recruitment/hired', 'label' => 'Hired'],
                ['url' => 'org-recruitment/offer-letter', 'label' => 'Generate Offer Letter'],
                ['url' => 'org-recruitment/search', 'label' => 'Search'],
                ['url' => 'org-recruitment/status-search', 'label' => 'Status Search'],
                ['url' => 'org-recruitment/reject', 'label' => 'Rejected'],
                ['url' => 'org-recruitment/message-centre', 'label' => 'Message Center'],
            ]
        ],
        2 => [
            'title' => 'Employee Administration',
            'icon' => 'la la-users',
            'items' => [
                ['url' => 'organization/employee/employerdashboard', 'label' => 'Dashboard'],
                ['url' => 'organization/employeeee', 'label' => 'Employees'],
                ['url' => 'organization/inactiveEmployee', 'label' => 'Inactive Employees'],
                ['url' => 'org-settings/vw-department', 'label' => 'Department'],
                ['url' => 'org-settings/vw-designation', 'label' => 'Designation'],
                ['url' => 'org-settings/vw-employee-type', 'label' => 'Type of Employment'],
                ['url' => 'organization/allShifts', 'label' => 'All Shifts'],
            ]
        ],
        3 => [
            'title' => 'Rota',
            'icon' => 'las la-calendar',
            'items' => [
                ['url' => 'rota-org/dashboard', 'label' => 'Dashboard'],
                ['url' => 'rota-org/shift-management', 'label' => 'Shift Planning'],
                ['url' => 'rota-org/late-policy', 'label' => 'Late Policy'],
                ['url' => 'rota-org/offday', 'label' => 'Leave Day'],
                ['url' => 'rota-org/grace-period', 'label' => 'Allowance Period'],
                ['url' => 'rota-org/duty-roster', 'label' => 'Employee Roster'],
            ]
        ],
       
        4 => [
            'title' => 'Attendance',
            'icon' => 'las la-tachometer-alt',
            'items' => [
                ['url' => 'attendance-management/dashboard', 'label' => 'Dashboard'],
                ['url' => 'attendance-management/upload-data', 'label' => 'Sync'],
                ['url' => 'attendance-management/generate-data', 'label' => 'Generate Attendance'],
                ['url' => 'attendance-management/daily-attendance', 'label' => 'Daily Log'],
                ['url' => 'attendance-management/attendance-report', 'label' => 'Attendance Record'],
                ['url' => 'attendance-management/process-attendance', 'label' => 'Execute Attendence'],
                ['url' => 'attendance-management/absent-report', 'label' => 'Absentee Record'],
            ]
        ],
        5 => [
            'title' => 'Leave Handling',
            'icon' => 'las la-clipboard-list',
            'items' => [
                ['url' => 'leave/dashboard', 'label' => 'Dashboard'],
                ['url' => 'leave/leave-type-listing', 'label' => 'Category'],
                ['url' => 'leave/leave-rule-listing', 'label' => 'Policy'],
                ['url' => 'leave/leave-allocation-listing', 'label' => 'Allocation'],
                ['url' => 'leave/leave-balance', 'label' => 'Leave Accrued'],
                ['url' => 'leave/leave-report', 'label' => 'Leave Record'],
                ['url' => 'leave/leave-report-employee', 'label' => 'Record EE Wise'],
            ]
        ],
        6 => [
            'title' => 'Leave Authosizer',
            'icon' => 'lab la-confluence',
            'items' => [
                ['url' => 'leaveapprover/leave-dashboard', 'label' => 'Dashboard'],
                ['url' => 'leaveapprover/leave-request', 'label' => 'Leave Application list'],
            ]
        ],

        7 => [
            'title' => 'Holiday Handling',
            'icon' => 'lab la-blackberry',
            'items' => [
                ['url' => 'orgaization/holiday-dashboard', 'label' => 'Dashboard'],
                ['url' => 'organization/holiday-type', 'label' => 'Category'],
                ['url' => 'organization/holiday-list', 'label' => 'Record'],
            ]
        ],
        8 => [
            'title' => 'Task Control',
            'icon' => 'las la-tasks',
            'items' => [
                ['url' => 'org-task-management/dashboard', 'label' => 'Dashboard'],
                ['url' => 'org-task-management/projects', 'label' => 'Project Directory'],
                ['url' => 'org-task-management/create-project', 'label' => 'New Project'],
            ]
        ],
        9 => [
            'title' => 'Performance Control',
            'icon' => 'las la-certificate',
            'items' => [
                ['url' => 'org-performances/dashboard', 'label' => 'Dashboard'],
                ['url' => 'org-performances', 'label' => 'Appraisal Request List'],
                ['url' => 'org-performances/request', 'label' => 'Create Request'],
            ]
        ],

        10 => [
            'title' => 'Settings',
            'icon' => 'las la-cogs',
            'items' => [
                ['url' => 'organization/settings-dashboard', 'label' => 'Dashboard'],
                ['submenu' => 'Bank Master', 'children' => [
                    ['url' => 'org-settings/vw-cmp-bank', 'label' => 'Add Organisation Bank'],
                    ['url' => 'org-settings/vw-emp-bank', 'label' => 'Add Employee Bank'],
                    ['url' => 'org-settings/vw-ifsc', 'label' => 'IFSC Record'],
                ]],
                ['submenu' => 'HCM Settings', 'children' => [
                   // ['url' => 'org-settings/vw-caste', 'label' => 'Caste Master'],
                   // ['url' => 'org-settings/vw-subcast', 'label' => 'Sub Cast'],
                   // ['url' => 'org-settings/vw-class', 'label' => 'Class Master'],
                    ['url' => 'org-settings/vw-pincode', 'label' => 'Pincode Master'],
                    ['url' => 'org-settings/vw-type', 'label' => 'Employee Type Master'],
                    ['url' => 'org-settings/vw-mode-type', 'label' => 'Mode Of Employee'],
                    ['url' => 'org-settings/vw-religion', 'label' => 'Religion Master'],
                    ['url' => 'org-settings/vw-education', 'label' => 'Education Master'],
                   // ['url' => 'org-settings/vw-department', 'label' => 'Department'],
                   // ['url' => 'org-settings/vw-designation', 'label' => 'Designation'],
                    ['url' => 'org-settings/vw-employee-type', 'label' => 'Employment Type'],
                    ['url' => 'org-settings/vw-paygroup', 'label' => 'Pay Group'],
                    ['url' => 'org-settings/vw-annualpay', 'label' => 'Annual Pay'],
                    ['url' => 'org-settings/vw-bank-sortcode', 'label' => 'Bank Shortcode'],
                    ['url' => 'org-settings/vw-pay-type', 'label' => 'Payment Type'],
                    ['url' => 'org-settings/vw-wedgespay-type', 'label' => 'Salary Pay Mode'],
                    ['url' => 'org-settings/vw-tax', 'label' => 'Tax Master'],
                ]],
            ]
        ],
        11 => [
            'title' => 'User Permissions',
            'icon' => 'las la-universal-access',
            'items' => [
                ['url' => 'user-access-role/dashboard', 'label' => 'Dashboard'],
                ['url' => 'user-access-role/vw-users', 'label' => 'User Settings'],
                ['url' => 'user-access-role/view-users-role', 'label' => 'Access Roles'],
            ]
        ],
        12 => [
            'title' => 'Billing',
            'icon' => 'las la-donate',
            'items' => [
                ['url' => 'organization/billing-show', 'label' => 'Invoice'],
                ['url' => '#', 'label' => 'Payment Receipt'],
            ]
        ], 
        13 => [
            'title' => 'File Manager',
            'icon' => 'las la-file',
            'items' => [
                ['url' => 'file-management/dashboard', 'label' => 'Dashboard'],
                ['url' => 'file-management/file-devision-list', 'label' => 'Division'],
                ['url' => 'file-management/fileManagmentList', 'label' => 'Manager'],
            ]
        ],
        14 => [
            'title' => 'Hr Support',
            'icon' => 'las la-american-sign-language-interpreting',
            'items' => [
                ['url' => 'hr-support/dashboard', 'label' => 'Dashboard'],
            ]
        ],

        15 => [
            'title' => 'Organogram Chart',
            'icon' => 'la la-user',
            'items' => [
                ['url' => '#', 'label' => 'Level'],
                ['url' => '#', 'label' => 'Organisation Hierarchy'],
            ]
        ],

        16 => [
            'title' => 'Change Of Circumstances',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'organization/circumstances', 'label' => 'Dashboard'],
                ['url' => 'org-employee/change-of-circumstances-add', 'label' => 'Change Notification List'],
                ['url' => 'org-dashboard/change-of-circumstances', 'label' => 'COC- Report'],
            ]
        ],
        17 => [
            'title' => 'Employee Hub',
            'icon' => 'las la-clone',
            'items' => [
                ['url' => 'org-user-check-employee', 'label' => 'Login Corner'],
            ]
        ],
        18 => [
            'title' => 'Visitor Register',
            'icon' => 'las la-book',
            'items' => [
                ['url' => 'rota-org/visitor-dashboard', 'label' => 'Dashboard'],
                ['url' => 'rota-org/visitor-link', 'label' => 'Sign Up Link'],
                ['url' => 'rota-org/visitor-regis', 'label' => 'Visitor List'],
            ]
        ],
        
    ];
// Function to check if any module item matches the current URL
function isActiveModule($moduleItems) {
        foreach ($moduleItems as $item) {
            if (isset($item['route']) && Route::is($item['route'])) {
                return true;
            } elseif (isset($item['url']) && Request::is($item['url'])) {
                return true;
            }
        }
        return false;
    }
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
        
          <ul class="sidebar-vertical">
                @if($user_type == "employer")
                    <li class="submenu">
                        <a href="#" ><i class="la la-building"></i> <span> Organization</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li class="{{ Request::is('organization/profile') ? 'noti-dot' : '' }}">
                                <a href="{{ url('organization/profile') }}">Profile</a>
                            </li>
                            <li class="{{ Request::is('employees-according-to-rti') ? 'noti-dot' : '' }}">
                                <a href="{{ url('employees-according-to-rti') }}">Employees (RTI)</a>
                            </li>
                            <li class="{{ Request::is('authorizing-officer') ? 'noti-dot' : '' }}">
                                <a href="{{ url('authorizing-officer') }}">Authorizing Officer</a>
                            </li>
                            <li class="{{ Request::is('key-contact') ? 'noti-dot' : '' }}">
                                <a href="{{ url('key-contact') }}">Key Contact</a>
                            </li>
                            <li class="{{ Request::is('level-1-user') ? 'noti-dot' : '' }}">
                                <a href="{{ url('level-1-user') }}">Level 1 User</a>
                            </li>
                            <li class="{{ Request::is('level-2-user') ? 'noti-dot' : '' }}">
                                <a href="{{ url('level-2-user') }}">Level 2 User</a>
                            </li>
                            <li class="{{ Request::is('org-dashboarddetails') ? 'noti-dot' : '' }}">
                                <a href="{{ url('org-dashboarddetails') }}">Sponsor Compliances</a>
                            </li>
                        </ul>
                    </li>
                
                    @foreach($sidebarItems as $array_role)
                        @php
                            $module_id = $array_role['module_name'];
                            $isActive = isset($modules[$module_id]) ? isActiveModule($modules[$module_id]['items']) : false;
                        @endphp

                        @if(isset($modules[$module_id]))
                            <!--<li class="menu-title"><span>{{ $modules[$module_id]['title'] }}</span></li>-->

                            <li class="submenu {{ $isActive ? 'active' : '' }}">
                                <a href="#"><i class="{{ $modules[$module_id]['icon'] }} {{ $isActive ? 'noti-dot' : '' }}"></i> 
                                    <span>{{ $modules[$module_id]['title'] }}</span> 
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @foreach($modules[$module_id]['items'] as $item)
                                        @if(isset($item['route']))
                                            <li><a href="{{ route($item['route']) }}" class="{{ Route::is($item['route']) ? 'active' : '' }}">{{ $item['label'] }}</a></li>
                                        @elseif(isset($item['submenu']))
                                            <li class="submenu">
                                                <a href="#"><span>{{ $item['submenu'] }}</span> <span class="menu-arrow"></span></a>
                                                <ul>
                                                    @foreach($item['children'] as $child)
                                                        <li><a href="{{ url($child['url']) }}" class="{{ Request::is($child['url']) ? 'active' : '' }}">{{ $child['label'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li><a href="{{ url($item['url']) }}" class="{{ Request::is($item['url']) ? 'active' : '' }}">{{ $item['label'] }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @else
                    @foreach($sidebarItems as $array_role)
                        @php
                            $module_id = $array_role['module_name'];
                            $isActive = isset($modules[$module_id]) ? isActiveModule($modules[$module_id]['items']) : false;
                        @endphp

                        @if(isset($modules[$module_id]))
                            <li class="menu-title"><span>{{ $modules[$module_id]['title'] }}</span></li>

                            <li class="submenu {{ $isActive ? 'active' : '' }}">
                                <a href="#"><i class="{{ $modules[$module_id]['icon'] }} {{ $isActive ? 'noti-dot' : '' }}"></i> 
                                    <span>{{ $modules[$module_id]['title'] }}</span> 
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @foreach($modules[$module_id]['items'] as $item)
                                        @if(isset($item['route']))
                                            <li><a href="{{ route($item['route']) }}" class="{{ Route::is($item['route']) ? 'active' : '' }}">{{ $item['label'] }}</a></li>
                                        @elseif(isset($item['submenu']))
                                            <li class="submenu">
                                                <a href="#"><span>{{ $item['submenu'] }}</span> <span class="menu-arrow"></span></a>
                                                <ul>
                                                    @foreach($item['children'] as $child)
                                                        <li><a href="{{ url($child['url']) }}" class="{{ Request::is($child['url']) ? 'active' : '' }}">{{ $child['label'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li><a href="{{ url($item['url']) }}" class="{{ Request::is($item['url']) ? 'active' : '' }}">{{ $item['label'] }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach        
                @endif
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
