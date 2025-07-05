@php
    $sidebarItems = \App\Helpers\Helper::getSidebarItems();
    //dd($sidebarItems);
    $user_type = Session::get("user_type");
@endphp    


<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                {{-- Employer-specific Sidebar --}}
                {{-- @if($user_type == "employer")
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
                                        <a href="{{ url('route-based-on-submenu/' . $submenu['submenu_id']) }}">
                                            {{ $submenu['submenu_name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @endif --}}

                {{-- Employee-specific Sidebar --}}
                @if($user_type == "employee" || $user_type == "employer")
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> 
                            <span>Employee Access Value</span> 
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ url('org-employee-corner-organisation/user-profile') }}">View Profile</a></li>
                            <li><a href="{{ url('org-employee-corner/holiday') }}">Holiday Calendar</a></li>
                            @if($user_type == "employee")
                            <li><a href="{{ url('org-employee-corner/holiday-list') }}">Holiday Apply</a></li>
                            @endif
                            <li><a href="{{ url('org-employee-corner/work-update') }}">Daily Work Update</a></li>
                            @if($user_type == "employee")
                            <li><a href="{{ url('org-employee-corner/leave-apply') }}">Leave Apply</a></li>
                            @endif
                            <li><a href="{{ url('org-employee-corner/attendance-status') }}">Attendance Status</a></li>
                        </ul>
                    </li>
                @endif
                @if($user_type == "employee")    
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
    </div>
</div>
