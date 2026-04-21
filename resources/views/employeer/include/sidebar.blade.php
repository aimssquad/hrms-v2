@php
    $sidebarItems = \App\Helpers\Helper::getSidebarItems(); 
    //dd($sidebarItems);
    $user_type = Session::get("user_type");
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
        // ],  {{\App\Helpers\Helper::cachedTrans('Organization', app()->getLocale())}}
        1 => [
            'title' => \App\Helpers\Helper::cachedTrans('Sponsor Compliances'),
            //GoogleTranslate::trans('Sponsor Compliances', app()->getLocale()),
            'icon' => 'las la-donate',
            'items' => [
                ['url' => 'org-dashboarddetails', 'label' => \App\Helpers\Helper::cachedTrans('Sponsor Compliances'),],
            ]
        ],
        2 => [
            'title' => \App\Helpers\Helper::cachedTrans('Recruitment'),
            'icon' => 'las la-clone',
            'route' => 'recruitment.dashboard',
            'items' => [
                ['route' => 'recruitment.dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['route' => 'recruitment.job-list', 'label' => \App\Helpers\Helper::cachedTrans('Job List'),],
                ['route' => 'recruitment.job-posting', 'label' => \App\Helpers\Helper::cachedTrans('Job Posting'),],
                ['route' => 'recruitment.job-published', 'label' => \App\Helpers\Helper::cachedTrans('Job Published'),],
                ['url' => 'org-recruitment/candidate', 'label' => \App\Helpers\Helper::cachedTrans('Job Applied'),],
                ['url' => 'org-recruitment/short-listing', 'label' => \App\Helpers\Helper::cachedTrans('Short listing'),],
                ['url' => 'org-recruitment/interview', 'label' => \App\Helpers\Helper::cachedTrans('Interview'),],
                ['url' => 'org-recruitment/hired', 'label' => \App\Helpers\Helper::cachedTrans('Hired'),],
                ['url' => 'org-recruitment/offer-letter', 'label' => \App\Helpers\Helper::cachedTrans('Generate Offer Letter'),],
                ['url' => 'org-recruitment/search', 'label' => \App\Helpers\Helper::cachedTrans('Search'),],
                ['url' => 'org-recruitment/status-search', 'label' => \App\Helpers\Helper::cachedTrans('Status Search'),],
                ['url' => 'org-recruitment/reject', 'label' => \App\Helpers\Helper::cachedTrans('Rejected'),],
                ['url' => 'org-recruitment/message-centre', 'label' => \App\Helpers\Helper::cachedTrans('Message Center'),],
            ]
        ],
        3 => [
            'title' => \App\Helpers\Helper::cachedTrans('Employee Administration'),
            'icon' => 'la la-users',
            'items' => [
                ['url' => 'organization/employee/employerdashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'organization/employee', 'label' =>  \App\Helpers\Helper::cachedTrans('Employees'),],
                // ['url' => 'organization/employee/sync-employee-upload', 'label' => \App\Helpers\Helper::cachedTrans('Sync Bulk Employees'),],
                ['url' => 'organization/inactiveEmployee', 'label' =>  \App\Helpers\Helper::cachedTrans('Inactive Employees'),],
                ['url' => 'org-settings/vw-department', 'label' =>  \App\Helpers\Helper::cachedTrans('Department'),],
                ['url' => 'org-settings/vw-designation', 'label' =>  \App\Helpers\Helper::cachedTrans('Designation'),],
                ['url' => 'org-settings/vw-employee-type', 'label' =>  \App\Helpers\Helper::cachedTrans('Type of Employment'),],
                ['url' => 'organization/allShifts', 'label' =>  \App\Helpers\Helper::cachedTrans('All Shifts'),],
                ['url' => 'organization/allGuest', 'label' =>  \App\Helpers\Helper::cachedTrans('All Clients'),],

            ]
        ],
        4 => [
            'title' => \App\Helpers\Helper::cachedTrans('Rota'),
            'icon' => 'las la-calendar',
            'items' => [
                ['url' => 'rota-org/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'rota-org/shift-management', 'label' =>  \App\Helpers\Helper::cachedTrans('Shift Planning'),],
                ['url' => 'rota-org/late-policy', 'label' =>   \App\Helpers\Helper::cachedTrans('Late Policy'),],
                ['url' => 'rota-org/offday', 'label' =>   \App\Helpers\Helper::cachedTrans('Leave Day'),],
                ['url' => 'rota-org/grace-period', 'label' =>   \App\Helpers\Helper::cachedTrans('Allowance Period'),],
                ['url' => 'rota-org/duty-roster', 'label' =>   \App\Helpers\Helper::cachedTrans('Employee Roster'),],
            ]
        ],
       
        5 => [
            'title' => \App\Helpers\Helper::cachedTrans('Attendance'),
            'icon' => 'las la-tachometer-alt',
            'items' => [
                ['url' => 'attendance-management/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'attendance-management/upload-data', 'label' => \App\Helpers\Helper::cachedTrans('Sync'),], 
                ['url' => 'attendance-management/generate-data', 'label' =>  \App\Helpers\Helper::cachedTrans('Generate Attendance'),],
                ['url' => 'attendance-management/daily-attendance', 'label' =>  \App\Helpers\Helper::cachedTrans('Daily Log'),],
                ['url' => 'attendance-management/attendance-report', 'label' =>  \App\Helpers\Helper::cachedTrans('Attendance Record'),],
                ['url' => 'attendance-management/process-attendance', 'label' =>  \App\Helpers\Helper::cachedTrans('Execute Attendence'),],
                ['url' => 'attendance-management/absent-report', 'label' =>  \App\Helpers\Helper::cachedTrans('Absentee Record'),],
                ['url' => 'org/employee-attendance', 'label' =>  \App\Helpers\Helper::cachedTrans('Employee Attendance Permission'),],
                
            ]
        ],
        6 => [
            'title' => \App\Helpers\Helper::cachedTrans('Leave Handling'),
            'icon' => 'las la-clipboard-list',
            'items' => [
                ['url' => 'leave/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'leave/leave-type-listing', 'label' =>    \App\Helpers\Helper::cachedTrans('Category'),],
                ['url' => 'leave/leave-rule-listing', 'label' =>    \App\Helpers\Helper::cachedTrans('Policy'),],
                ['url' => 'leave/leave-allocation-listing', 'label' =>    \App\Helpers\Helper::cachedTrans('Allocation'),],
                ['url' => 'leave/leave-balance', 'label' =>   \App\Helpers\Helper::cachedTrans('Leave Accrued'),],
                ['url' => 'leave/leave-report', 'label' =>   \App\Helpers\Helper::cachedTrans('Leave Record'),],
                ['url' => 'leave/leave-report-employee', 'label' =>  \App\Helpers\Helper::cachedTrans('Record EE Wise'),],
            ]
        ],
        7 => [
            'title' => \App\Helpers\Helper::cachedTrans('Leave Authosizer'),
            'icon' => 'lab la-confluence',
            'items' => [
                ['url' => 'leaveapprover/leave-dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'leaveapprover/leave-request', 'label' => \App\Helpers\Helper::cachedTrans('Leave Application list'),],
            ]
        ],

        8 => [
            'title' => \App\Helpers\Helper::cachedTrans('Holiday Handling'),
            'icon' => 'lab la-blackberry',
            'items' => [
                ['url' => 'orgaization/holiday-dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'organization/holiday-type', 'label' =>     \App\Helpers\Helper::cachedTrans('Category'),],
                ['url' => 'organization/holiday-list', 'label' =>     \App\Helpers\Helper::cachedTrans('Record'),],
                ['url' => 'organization/holiday-types/', 'label' =>   \App\Helpers\Helper::cachedTrans('Holiday Type'),],
                ['url' => 'organization/holiday-applications/', 'label' =>  \App\Helpers\Helper::cachedTrans('Holiday Apply'),],
            ]
        ],
        9 => [
            'title' => \App\Helpers\Helper::cachedTrans('Project Control'),
            'icon' => 'las la-tasks',
            'items' => [
                ['url' => 'org-task-management/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'org-task-management/projects', 'label' =>   \App\Helpers\Helper::cachedTrans('Project Directory'),],
                ['url' => 'org-task-management/create-project', 'label' =>   \App\Helpers\Helper::cachedTrans('New Project'),],
            ]
        ],
        10 => [
            'title' => \App\Helpers\Helper::cachedTrans('Performance Control'),
            'icon' => 'las la-certificate',
            'items' => [
                ['url' => 'org-performances/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'org-performances', 'label' =>    \App\Helpers\Helper::cachedTrans('Appraisal Request List'),],
                ['url' => 'org-performances/request', 'label' =>    \App\Helpers\Helper::cachedTrans('Create Request'),],
            ]
        ],

        11 => [
            'title' => \App\Helpers\Helper::cachedTrans('Settings'),
            'icon' => 'las la-cogs',
            'items' => [
                ['url' => 'organization/settings-dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['submenu' => \App\Helpers\Helper::cachedTrans('Bank Master'), 'children' => [
                    ['url' => 'org-settings/vw-cmp-bank', 'label' =>    \App\Helpers\Helper::cachedTrans('Add Organisation Bank'),],
                    ['url' => 'org-settings/vw-emp-bank', 'label' =>    \App\Helpers\Helper::cachedTrans('Add Employee Bank'),],
                    ['url' => 'org-settings/vw-ifsc', 'label' =>    \App\Helpers\Helper::cachedTrans('IFSC Record'),],
                ]],
                ['submenu' => \App\Helpers\Helper::cachedTrans('HCM Settings'), 'children' => [
                   // ['url' => 'org-settings/vw-caste', 'label' => 'Caste Master'],
                   // ['url' => 'org-settings/vw-subcast', 'label' => 'Sub Cast'],
                   // ['url' => 'org-settings/vw-class', 'label' => 'Class Master'],
                    ['url' => 'org-settings/vw-pincode', 'label' =>    \App\Helpers\Helper::cachedTrans('Pincode Master'),],
                    ['url' => 'org-settings/vw-type', 'label' =>    \App\Helpers\Helper::cachedTrans('Employee Type Master'),],
                    ['url' => 'org-settings/vw-mode-type', 'label' =>    \App\Helpers\Helper::cachedTrans('Mode Of Employee'),],
                    ['url' => 'org-settings/vw-religion', 'label' =>    \App\Helpers\Helper::cachedTrans('Religion Master'),],
                    ['url' => 'org-settings/vw-education', 'label' =>    \App\Helpers\Helper::cachedTrans('Education Master'),],
                   // ['url' => 'org-settings/vw-department', 'label' => 'Department'],
                   // ['url' => 'org-settings/vw-designation', 'label' => 'Designation'],
                    // ['url' => 'org-settings/vw-employee-type', 'label' => 'Employment Type'],
                    ['url' => 'org-settings/vw-paygroup', 'label' =>     \App\Helpers\Helper::cachedTrans('Pay Group'),],
                    ['url' => 'org-settings/vw-annualpay', 'label' =>     \App\Helpers\Helper::cachedTrans('Annual Pay'),],
                    ['url' => 'org-settings/vw-bank-sortcode', 'label' =>     \App\Helpers\Helper::cachedTrans('Bank Shortcode'),],
                    ['url' => 'org-settings/vw-pay-type', 'label' =>     \App\Helpers\Helper::cachedTrans('Payment Type'),],
                    ['url' => 'org-settings/vw-wedgespay-type', 'label' =>     \App\Helpers\Helper::cachedTrans('Salary Pay Mode'),],
                    ['url' => 'org-settings/vw-tax', 'label' =>     \App\Helpers\Helper::cachedTrans('Tax Master'),],
                ]],
            ]
        ],
        12 => [
            'title' => \App\Helpers\Helper::cachedTrans('User Permissions'),
            'icon' => 'las la-universal-access',
            'items' => [
                ['url' => 'user-access-role/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'user-access-role/vw-users', 'label' => \App\Helpers\Helper::cachedTrans('User Settings'),],
                // ['url' => 'user-access-role/view-users-role', 'label' => 'Access Roles'],
                ['url' => 'user-access/emp', 'label' => \App\Helpers\Helper::cachedTrans('Access Roles'),],
                // ['url' => 'user-access/role', 'label' => 'Role'],
            ]
        ],
        13 => [
            'title' => \App\Helpers\Helper::cachedTrans('Billing'),
            'icon' => 'las la-donate',
            'items' => [
                ['url' => 'organization/billing/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'organization/billing-show', 'label' =>  \App\Helpers\Helper::cachedTrans('Invoice'),],
                ['url' => '#', 'label' =>  \App\Helpers\Helper::cachedTrans('Payment Receipt'),],

                ['url' => 'organization/currency', 'label' =>  \App\Helpers\Helper::cachedTrans('Currencies'),],
            ]
        ],  
        14 => [
            'title' => \App\Helpers\Helper::cachedTrans('File Manager'),
            'icon' => 'las la-file',
            'items' => [
                ['url' => 'file-management/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'file-management/file-devision-list', 'label' =>    \App\Helpers\Helper::cachedTrans('Division'),],
                ['url' => 'file-management/fileManagmentList', 'label' =>    \App\Helpers\Helper::cachedTrans('Manager'),],
            ]
        ],
        15 => [
            'title' => \App\Helpers\Helper::cachedTrans('Hr Support'),
            'icon' => 'las la-american-sign-language-interpreting',
            'items' => [
                ['url' => 'hr-support/dashboard-new', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
            ]
        ],

        16 => [
            'title' => \App\Helpers\Helper::cachedTrans('Organogram Chart'),
            'icon' => 'la la-user',
            'items' => [
                ['url' => '#', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => '#', 'label' => \App\Helpers\Helper::cachedTrans('Level'),],
                ['url' => '#', 'label' => \App\Helpers\Helper::cachedTrans('Organisation Hierarchy'),],
            ]
        ],

        17 => [
            'title' => \App\Helpers\Helper::cachedTrans('Change Of Circumstances'),
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'organization/circumstances', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'org-employee/change-of-circumstances-add', 'label' =>      \App\Helpers\Helper::cachedTrans('Change Notification List'),],
                ['url' => 'org-dashboard/change-of-circumstances', 'label' =>      \App\Helpers\Helper::cachedTrans('COC- Report'),],
            ]
        ],
        18 => [
            'title' => \App\Helpers\Helper::cachedTrans('Employee Hub'),
            'icon' => 'las la-clone',
            'items' => [
                ['url' => 'org-user-check-employee', 'label' =>  \App\Helpers\Helper::cachedTrans('Login Corner'),],
            ]
        ],
        19 => [
            'title' => \App\Helpers\Helper::cachedTrans('Visitor Register'),
            'icon' => 'las la-book',
            'items' => [
                ['url' => 'rota-org/visitor-dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'rota-org/visitor-link', 'label' =>   \App\Helpers\Helper::cachedTrans('Sign Up Link'),],
                ['url' => 'rota-org/visitor-regis', 'label' =>  \App\Helpers\Helper::cachedTrans('Visitor List'),],
            ]
        ],
        24 => [
            'title' => \App\Helpers\Helper::cachedTrans('Notice'),
            'icon' => 'las la-bullhorn',
            'items' => [
                ['url' => 'notification-dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'notice/org-notice', 'label' => \App\Helpers\Helper::cachedTrans('Notice'),],
                ['url' => 'all-notification', 'label' => \App\Helpers\Helper::cachedTrans('All Notification'),],
                
            ]
        ],
        25 => [
            'title' => \App\Helpers\Helper::cachedTrans('Mobile Menu'),
            'icon' => 'las la-mobile',
            'items' => [
                ['url' => 'org/mobile-menu', 'label' => \App\Helpers\Helper::cachedTrans('Mobile Menu'),],
                //['url' => 'org/employee-attendance', 'label' => 'Employee Attendance Permission'],
               
            ]
        ],
        26 => [
            'title' => \App\Helpers\Helper::cachedTrans('Customer Billing'),
            'icon' => 'las la-donate',
            'items' => [
                ['url' => 'organization/customer-billing/dashboard', 'label' => \App\Helpers\Helper::cachedTrans('Dashboard'),],
                ['url' => 'organization/customer', 'label' =>  \App\Helpers\Helper::cachedTrans('Customer'),],
                ['url' => 'organization/customer/invoice', 'label' =>  \App\Helpers\Helper::cachedTrans('Customer Invoice'),],
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
                        <a href="#" ><i class="la la-building"></i> <span>  {{\App\Helpers\Helper::cachedTrans('Organization', app()->getLocale())}}</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li class="{{ Request::is('organization/profile') ? 'noti-dot' : '' }}">
                                <a href="{{ url('organization/profile') }}">{{\App\Helpers\Helper::cachedTrans('Profile', app()->getLocale())}}</a>
                            </li>
                            <li class="{{ Request::is('organization/location') ? 'noti-dot' : '' }}">
                                <a href="{{ url('organization/location') }}"> {{\App\Helpers\Helper::cachedTrans('Branch Location', app()->getLocale())}}</a>
                            </li>
                            <li class="{{ Request::is('employees-according-to-rti') ? 'noti-dot' : '' }}">
                                <a href="{{ url('employees-according-to-rti') }}">{{\App\Helpers\Helper::cachedTrans('Employees (RTI)', app()->getLocale())}}</a>
                            </li>
                            <li class="{{ Request::is('authorizing-officer') ? 'noti-dot' : '' }}">
                                <a href="{{ url('authorizing-officer') }}">{{\App\Helpers\Helper::cachedTrans('Authorizing Officer', app()->getLocale())}}</a>
                            </li>
                            <li class="{{ Request::is('key-contact') ? 'noti-dot' : '' }}">
                                <a href="{{ url('key-contact') }}">{{\App\Helpers\Helper::cachedTrans('Key Contact', app()->getLocale())}}</a>
                            </li>
                            <li class="{{ Request::is('level-1-user') ? 'noti-dot' : '' }}">
                                <a href="{{ url('level-1-user') }}">{{\App\Helpers\Helper::cachedTrans('Level 1 User', app()->getLocale())}}</a>
                            </li>
                            <li class="{{ Request::is('level-2-user') ? 'noti-dot' : '' }}">
                                <a href="{{ url('level-2-user') }}">{{\App\Helpers\Helper::cachedTrans('Level 2 User', app()->getLocale())}}</a>
                            </li>
                            {{-- <li class="{{ Request::is('org-dashboarddetails') ? 'noti-dot' : '' }}">
                                <a href="{{ url('org-dashboarddetails') }}">Sponsor Compliances</a>
                            </li> --}}
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
                    {{-- @foreach($sidebarItems as $array_role)
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
                    @endforeach         --}}
                    @foreach ($sidebarItems as $moduleName => $submenus)
                        <li class="menu-title">
                            <span>{{ $moduleName }}</span>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-cube"></i> 
                                <span>{{ $moduleName }}</span> 
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                @foreach ($submenus as $submenu)
                                    <li>
                                        <a href="{{ url($submenu['submenu_url']) }}">
                                            {{ $submenu['submenu_name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @endif
            </ul> 
        </div>
        @php
            $email = Session::get('emp_email');
            //dd($email);
            $company_details = DB::table('registration')
                ->where('email', '=', $email)
                ->first(); 
        @endphp
       

        <div class="bg-white ps-2 pe-2 sidebar_bottom">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Left Side: Developed By -->
                <div class="d-flex align-items-center">
                    <a href="https://sponichr.com/"><img width="60px" src="{{ asset('assets/img/sponicHr-logo.png') }}" style="height:30px; object-fit:fill; display:inline-block;" /></a>
                    <p class="mt-2 mb-0 ms-2" style="font-size: 14px; font-weight: 600; color:#262626;">Developed By</p>
                </div>

                <!-- Right Side: Powered By -->
                <div class="d-flex align-items-center">
                    <div class="">
                        {{-- @if($company_details->org_code == '')
                            <a href="https://skilledworkerscloud.co.uk/"><img width="73px" src="{{ asset('assets/img/swch_logo.png') }}" style="height:35px; object-fit:fill; display:inline-block;" /></a>
                        @else
                            @if($company_details->org_code != '')
                                @php
                                    $sub_details = DB::table('sub_admin_registrations')
                                        ->where('org_code', '=', $company_details->org_code)
                                        ->select('logo')
                                        ->first();
                                @endphp  
                                @if(!empty($sub_details->logo))
                                    <img src="{{ asset('storage/app/public/' . $sub_details->logo) }}" style="width:60px; height:30px; object-fit:fill; display:inline-block;" />
                                @endif      
                            @endif
                        @endif --}}
                    </div>
                </div>
            </div>
            
            <!-- Copyright in next row with justified alignment -->
            <div class="d-flex justify-content-between mt-1">
                <p class="text-dark mb-0 pb-1" style="font-size:10px; width:100%; text-align:justify; text-align-last:justify;">
                    © {{ date('Y') }} SWC - SponicHR | All Rights Reserved |
                </p>
            </div>
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

