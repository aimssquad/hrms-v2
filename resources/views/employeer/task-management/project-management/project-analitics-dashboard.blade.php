@extends('employeer.task-management.project-management.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Analytics Dashboard'))

@section('css')
<style>
    #projectChart {
        max-width: 250px;
        max-height: 250px;
        margin: auto;
    }
</style>
@endsection

@section('content')

<!-- Page Content -->
<div class="content container-fluid pb-0">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans($projects->title. ' Dashboard')}}</h3>
                {{-- <h3 class="page-title">{{$projects->title .'Dashboard'}}</h3> --}}
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                    <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Members')}}</span>
                                            <h3>{{ $totalMembers }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-users fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Task')}}</span>
                                            <h3>{{ $totalTasks }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-list-check fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Member Label')}}</span>
                                            <h3>{{ $memberLabels->sum('total') }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-tags fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Member Roles')}}</span>
                                            <h3>{{ $memberRoles->sum('total') }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-user-tie fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Active Projects')}}</span>
                                            <h3>{{$activeProject}}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-bars-progress fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Completed Projects')}}</span>
                                            <h3>{{$closedProject}}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-circle-check fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="{{url('/org-task-management/'.encrypt($id).'/chat')}}">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Chat')}}</span>
                                            {{-- <h3>25</h3> --}}
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-comments fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                     {{-- here need to show some analitics chart for showing performance and  --}}
                     <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{$projects->title}} Analytics</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="projectChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Task Analytics</h5>
                            </div>
                            <div class="card-body" style="height:300px;">
                                <canvas id="taskChart" ></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Members Growth</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="memberChart"></canvas>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
                
        
    

</div>
<!-- /Page Content -->


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Project Chart (Pie)
//    new Chart(document.getElementById('projectChart'), {
//         type: 'pie',
//         data: {
//             labels: ['Members', 'Tasks', 'Labels', 'Roles'],
//             datasets: [{
//                 data: [
//                     {{ $totalMembers }},
//                     {{ $totalTasks }},
//                     {{ $memberLabels->sum('total') }},
//                     {{ $memberRoles->sum('total') }}
//                 ],
//                 backgroundColor: [
//                     '#3b82f6', // Members (blue)
//                     '#10b981', // Tasks (green)
//                     '#f59e0b', // Labels (yellow)
//                     '#6366f1'  // Roles (purple)
//                 ]
//             }]
//         }
//     });

    

    new Chart(document.getElementById('projectChart'), {
        type: 'doughnut', // ✅ change pie → doughnut
        data: {
            labels: ['Members', 'Tasks', 'Labels', 'Roles'],
            datasets: [{
                data: [
                    {{ $totalMembers }},
                    {{ $totalTasks }},
                    {{ $memberLabels->sum('total') }},
                    {{ $memberRoles->sum('total') }}
                ],
                backgroundColor: [
                    '#3b82f6', // Members
                    '#10b981', // Tasks
                    '#f59e0b', // Labels
                    '#6366f1'  // Roles
                ],
                borderWidth: 2
            }]
        },
        options: {
            cutout: '65%', // 🔥 this makes donut shape
            plugins: [{
                id: 'centerText',
                beforeDraw(chart) {
                    const {width} = chart;
                    const {height} = chart;
                    const ctx = chart.ctx;

                    ctx.restore();
                    ctx.font = "bold 18px sans-serif";
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText('Total', width / 2, height / 2 - 10);
                    ctx.fillText(
                        {{ $totalMembers + $totalTasks + $memberLabels->sum('total') + $memberRoles->sum('total') }},
                        width / 2,
                        height / 2 + 10
                    );
                    ctx.save();
                }
            }]
        }
    });

    // Task Chart (Bar)
    // new Chart(document.getElementById('taskChart'), {
    //     type: 'bar',
    //     data: {
    //         labels: ['Total', 'Completed', 'Pending'],
    //         datasets: [{
    //             label: 'Tasks',
    //             data: [
    //                 {{ $totalTasks }},
    //                 {{ $completedTasks }},
    //                 {{ $pendingTasks }}
    //             ],
    //             backgroundColor: ['#007bff', '#28a745', '#dc3545']
    //         }]
    //     }
    // });

    // Member Chart (Line)
    const memberLabels = [
        @foreach($memberGrowth as $m)
            "{{ date('M', mktime(0,0,0,$m->month,1)) }}",
        @endforeach
    ];

    const memberData = [
        @foreach($memberGrowth as $m)
            {{ $m->total }},
        @endforeach
    ];

    new Chart(document.getElementById('memberChart'), {
        type: 'line',
        data: {
            labels: memberLabels,
            datasets: [{
                label: 'Members',
                data: memberData,
                borderColor: '#007bff',
                fill: false
            }]
        }
    });

    // task chart for showing task distribution among members (optional)
 

</script>

 <script>
const employees = [];
const statusData = {};

// Initialize labels
@foreach($labels as $label)
    statusData["{{ strtolower($label) }}"] = [];
@endforeach

// Fill data
@foreach($employeeTasks->groupBy('name') as $name => $tasks)
    employees.push("{{ $name }}");

    @foreach($labels as $label)
        statusData["{{ strtolower($label) }}"].push(
            @php
                $found = 0;
                foreach($tasks as $t){
                    if(strtolower($t->status) == strtolower($label)){
                        $found = $t->total;
                    }
                }
            @endphp
            {{ $found }}
        );
    @endforeach
@endforeach


// Colors
// const statusColors = {
//     'todo': '#ef4444',
//     'pending': '#f59e0b',
//     'resolved': '#3b82f6',
//     'completed': '#22c55e'
// };

// 🎨 Soft pastel color palette (modern dashboard)
const colorPalette = [
    '#93c5fd', // light blue
    '#86efac', // light green
    '#fcd34d', // light yellow
    '#fca5a5', // light red
    '#c4b5fd', // light purple
    '#fdba74', // light orange
    '#67e8f9', // cyan
    '#f9a8d4'  // pink
];

// Generate dynamic colors
let datasets = [];
let colorIndex = 0;

Object.keys(statusData).forEach((status) => {
    datasets.push({
        label: status.charAt(0).toUpperCase() + status.slice(1),
        data: statusData[status],
        backgroundColor: colorPalette[colorIndex % colorPalette.length],
        borderRadius: 6,
        borderSkipped: false
    });

    colorIndex++;
});

// Dataset
// let datasets = [];

// Object.keys(statusData).forEach((status) => {
//     datasets.push({
//         label: status,
//         data: statusData[status],
//         backgroundColor: statusColors[status] || '#8b5cf6',
//         borderRadius: 6
//     });
// });

// Chart
new Chart(document.getElementById('taskChart'), {
    type: 'bar',
    data: {
        labels: employees, // ✅ NOW employee names show here
        datasets: datasets
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            x: { stacked: true },
            y: { stacked: true, beginAtZero: true }
        }
    }
});
</script>

@endsection