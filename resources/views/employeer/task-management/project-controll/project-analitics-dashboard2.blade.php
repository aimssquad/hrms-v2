@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Analytics Dashboard'))

@section('css')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
        body {
            background: #f5f7fb;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .page-header {
            padding-bottom: 1rem;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            font-size: 1.2rem;
        }
        .modern-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            transition: 0.2s;
            border: 1px solid #f0f2f5;
            cursor: default;
        }
        .modern-card:hover {
            border-color: #d0d7e6;
            background: #fafcff;
        }
        .dash-widget-info span {
            font-size: 0.8rem;
            font-weight: 500;
            color: #6b7a8f;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .dash-widget-info h3 {
            font-weight: 700;
            font-size: 1.8rem;
            color: #1e293b;
            margin: 0;
            line-height: 1.2;
        }
        .modern_icon_wrapper {
            background: #eef2f9;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            color: #2a4b7c;
        }
        .modern-icon {
            font-size: 1.6rem;
        }
        .modern-arrow {
            color: #4a6a8b;
            font-weight: 500;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .modern-arrow i {
            margin-left: 4px;
            font-size: 0.7rem;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 20, 50, 0.04);
            background: #ffffff;
            transition: 0.2s;
        }
        .card-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
            letter-spacing: -0.2px;
        }
        .stat-label {
            color: #5e6f88;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .stat-value {
            font-weight: 700;
            color: #0b1a33;
        }
        .progress-sm {
            height: 6px;
            border-radius: 10px;
            background: #e9edf4;
        }
        .badge-status {
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .badge-inprogress { background: #dbeafe; color: #1a4c8a; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-completed { background: #d4edda; color: #0b5e3c; }
        .table th {
            border-top: none;
            color: #4b5b70;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }
        .activity-log-item {
            border-left: 3px solid #d0dcec;
            padding-left: 14px;
            margin-bottom: 12px;
        }
        .activity-log-item .time {
            font-size: 0.7rem;
            color: #7a8aa0;
        }
        .member-progress {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .member-progress .bar {
            flex: 1;
            height: 6px;
            background: #e8ecf3;
            border-radius: 20px;
        }
        .member-progress .bar-fill {
            height: 6px;
            border-radius: 20px;
            background: #2a4b7c;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f3f8;
        }
        .task-item:last-child { border-bottom: none; }
        .task-title { font-weight: 500; font-size: 0.9rem; }
        .task-meta { font-size: 0.75rem; color: #5f738d; }
        .bg-soft-primary { background: #eef5ff; }
        .text-primary-dark { color: #1a3a6b; }
        .chart-container {
            position: relative;
            max-width: 160px;
            margin: 0 auto;
        }
        .pie-label {
            font-size: 0.75rem;
            color: #3d5068;
        }
        .border-dash {
            border: 1px dashed #dce2ec;
            border-radius: 20px;
            padding: 0.5rem 1rem;
        }
        .hover-shadow:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.02);
        }
        .fs-small { font-size: 0.75rem; }
    </style>
@endsection

@section('content')

<div class="container-fluid px-4 py-3">

    <!-- ========== HEADER / BREADCRUMB ========== -->
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
        <div>
            <h3 class="fw-bold text-dark mb-1">SponicHR <span class="text-secondary fw-normal">/ Dashboard</span></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-secondary">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-secondary">Projects</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 mt-2 mt-sm-0">
            <span class="badge bg-light text-secondary border px-3 py-2"><i class="far fa-calendar me-1"></i> Jul 28, 2026</span>
        </div>
    </div>

    <!-- ========== STAT CARDS (7 items) ========== -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <div class="card-body modern-card">
                    <div class="dash-widget-info">
                        <span>Total Members</span>
                        <h3>24</h3>
                    </div>
                    <div class="modern_icon_wrapper"><i class="fa-solid fa-users modern-icon"></i></div>
                    <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <div class="card-body modern-card">
                    <div class="dash-widget-info">
                        <span>Total Modules</span>
                        <h3>6</h3>
                    </div>
                    <div class="modern_icon_wrapper"><i class="fa-solid fa-folder modern-icon"></i></div>
                    <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <div class="card-body modern-card">
                    <div class="dash-widget-info">
                        <span>Sub Modules</span>
                        <h3>12</h3>
                    </div>
                    <div class="modern_icon_wrapper"><i class="fa-solid fa-folder-open modern-icon"></i></div>
                    <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <div class="card-body modern-card">
                    <div class="dash-widget-info">
                        <span>Tasks</span>
                        <h3>48</h3>
                    </div>
                    <div class="modern_icon_wrapper"><i class="fa-solid fa-tasks modern-icon"></i></div>
                    <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <div class="card-body modern-card">
                    <div class="dash-widget-info">
                        <span>Sub Tasks</span>
                        <h3>96</h3>
                    </div>
                    <div class="modern_icon_wrapper"><i class="fa-solid fa-check-square modern-icon"></i></div>
                    <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <div class="card-body modern-card">
                    <div class="dash-widget-info">
                        <span>Member Label</span>
                        <h3>8</h3>
                    </div>
                    <div class="modern_icon_wrapper"><i class="fa-solid fa-tags modern-icon"></i></div>
                    <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <div class="card-body modern-card">
                    <div class="dash-widget-info">
                        <span>Member Roles</span>
                        <h3>5</h3>
                    </div>
                    <div class="modern_icon_wrapper"><i class="fa-solid fa-user-tie modern-icon"></i></div>
                    <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <!-- chat card -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card dash-widget overflow-visible border-0 shadow-sm">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card-body modern-card">
                        <div class="dash-widget-info">
                            <span>Chat</span>
                            <h3>12</h3>
                        </div>
                        <div class="modern_icon_wrapper"><i class="fa-solid fa-comments modern-icon"></i></div>
                        <div class="modern-arrow pt-2"><span>View</span> <i class="fa-solid fa-arrow-right"></i></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- ========== ROW: PROGRESS OVERVIEW + WORK ITEMS + TASK STATUS ========== -->
    <div class="row g-4 mb-4">
        <!-- Progress Overview (Pie) -->
        <div class="col-lg-4">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-2"><i class="fas fa-chart-pie me-2 text-secondary"></i>Progress Overview</h6>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="chart-container" style="max-width:140px;">
                        <canvas id="progressPieChart" width="140" height="140"></canvas>
                    </div>
                    <div class="ms-3">
                        <div><span class="badge bg-success me-1" style="width:10px;height:10px;display:inline-block;"></span> Completed <strong>68%</strong> <span class="text-muted fs-small">(163)</span></div>
                        <div><span class="badge bg-warning me-1" style="width:10px;height:10px;display:inline-block;"></span> In Progress <strong>20%</strong> <span class="text-muted fs-small">(48)</span></div>
                        <div><span class="badge bg-secondary me-1" style="width:10px;height:10px;display:inline-block;"></span> Pending <strong>12%</strong> <span class="text-muted fs-small">(29)</span></div>
                    </div>
                </div>
                <!-- small weekly change -->
                <div class="mt-2 d-flex gap-3 fs-small text-muted border-top pt-2">
                    <span><i class="fas fa-arrow-up text-success"></i> 12% this week</span>
                    <span><i class="fas fa-arrow-up text-success"></i> 8% this week</span>
                    <span><i class="fas fa-arrow-down text-danger"></i> 5% this week</span>
                </div>
            </div>
        </div>

        <!-- Work Items by Type (Doughnut) -->
        <div class="col-lg-4">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-2"><i class="fas fa-list-ul me-2 text-secondary"></i>Work Items by Type</h6>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="chart-container" style="max-width:140px;">
                        <canvas id="workItemsChart" width="140" height="140"></canvas>
                    </div>
                    <div class="ms-3">
                        <div><span class="badge bg-primary me-1" style="width:10px;height:10px;display:inline-block;"></span> Completed <strong>68%</strong> <span class="text-muted fs-small">(163)</span></div>
                        <div><span class="badge bg-info me-1" style="width:10px;height:10px;display:inline-block;"></span> In Progress <strong>20%</strong> <span class="text-muted fs-small">(48)</span></div>
                        <div><span class="badge bg-secondary me-1" style="width:10px;height:10px;display:inline-block;"></span> Pending <strong>12%</strong> <span class="text-muted fs-small">(29)</span></div>
                    </div>
                </div>
                <div class="mt-2 d-flex gap-3 fs-small text-muted border-top pt-2">
                    <span><i class="fas fa-arrow-up text-success"></i> 18% this week</span>
                    <span><i class="fas fa-arrow-up text-success"></i> 22% this week</span>
                </div>
            </div>
        </div>

        <!-- Task Status (horizontal bars) -->
        <div class="col-lg-4">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-3"><i class="fas fa-tasks me-2 text-secondary"></i>Task Status</h6>
                <div class="mb-2">
                    <div class="d-flex justify-content-between"><span class="stat-label">Completed</span> <span class="stat-value">68% (56%)</span></div>
                    <div class="progress progress-sm"><div class="progress-bar bg-success" style="width:68%"></div></div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between"><span class="stat-label">In Progress</span> <span class="stat-value">48% (25%)</span></div>
                    <div class="progress progress-sm"><div class="progress-bar bg-info" style="width:48%"></div></div>
                </div>
                <div>
                    <div class="d-flex justify-content-between"><span class="stat-label">Pending</span> <span class="stat-value">29% (19%)</span></div>
                    <div class="progress progress-sm"><div class="progress-bar bg-secondary" style="width:29%"></div></div>
                </div>
                <div class="mt-3 text-muted fs-small border-top pt-2 d-flex gap-3">
                    <span><i class="fas fa-calendar-alt"></i> 56% completed</span>
                    <span><i class="fas fa-clock"></i> 25% in progress</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== ACTIVITY LOG & RECENT MODULES ========== -->
    <div class="row g-4 mb-4">
        <!-- Activity Log -->
        <div class="col-lg-5">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-3"><i class="fas fa-stream me-2 text-secondary"></i>Activity Log</h6>
                <div class="activity-log-item">
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Alice updated task</span> <span class="time">2h ago</span></div>
                    <div class="text-muted fs-small">"Design Dashboard UI" set to In Progress</div>
                </div>
                <div class="activity-log-item">
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Robert created sub-module</span> <span class="time">4h ago</span></div>
                    <div class="text-muted fs-small">Backend: API Integration added</div>
                </div>
                <div class="activity-log-item">
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Emily closed task</span> <span class="time">yesterday</span></div>
                    <div class="text-muted fs-small">User Role Management completed</div>
                </div>
                <div class="activity-log-item">
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Michael commented</span> <span class="time">yesterday</span></div>
                    <div class="text-muted fs-small">"Fix Navigation Issue" needs review</div>
                </div>
                <div class="mt-2"><a href="#" class="text-decoration-none fs-small">View all activity <i class="fas fa-arrow-right ms-1"></i></a></div>
            </div>
        </div>

        <!-- Recent Modules & Progress (table) -->
        <div class="col-lg-7">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-3"><i class="fas fa-layer-group me-2 text-secondary"></i>Recent Modules & Progress</h6>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead><tr><th>#</th><th>Module / Sub Module</th><th>Tasks</th><th>Progress</th><th>Status</th></tr></thead>
                        <tbody>
                            <tr><td>1</td><td>Planning Requirement Gathering</td><td>8/12</td><td><div class="progress progress-sm w-75"><div class="progress-bar bg-info" style="width:67%"></div></div> 67%</td><td><span class="badge-status badge-inprogress">In Progress</span></td></tr>
                            <tr><td>2</td><td>Design UI/UX Design</td><td>10/15</td><td><div class="progress progress-sm w-75"><div class="progress-bar bg-info" style="width:66%"></div></div> 66%</td><td><span class="badge-status badge-inprogress">In Progress</span></td></tr>
                            <tr><td>3</td><td>Development Backend Development</td><td>15/20</td><td><div class="progress progress-sm w-75"><div class="progress-bar bg-success" style="width:75%"></div></div> 75%</td><td><span class="badge-status badge-inprogress">In Progress</span></td></tr>
                            <tr><td>4</td><td>Testing System Testing</td><td>5/10</td><td><div class="progress progress-sm w-75"><div class="progress-bar bg-warning" style="width:50%"></div></div> 50%</td><td><span class="badge-status badge-pending">Pending</span></td></tr>
                            <tr><td>5</td><td>Deployment Production Release</td><td>2/5</td><td><div class="progress progress-sm w-75"><div class="progress-bar bg-secondary" style="width:40%"></div></div> 40%</td><td><span class="badge-status badge-pending">Pending</span></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-1"><a href="#" class="text-decoration-none fs-small">View Details <i class="fas fa-arrow-right ms-1"></i></a></div>
            </div>
        </div>
    </div>

    <!-- ========== MY TASKS + PROJECT OVERVIEW + TOP MEMBERS ========== -->
    <div class="row g-4">
        <!-- My Tasks -->
        <div class="col-lg-5">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-3"><i class="fas fa-clipboard-list me-2 text-secondary"></i>My Tasks</h6>
                <div class="task-item"><div><span class="task-title">Design Dashboard UI</span><div class="task-meta">In Progress</div></div><span class="badge bg-light fw-bold">96</span></div>
                <div class="task-item"><div><span class="task-title">API Integration</span><div class="task-meta">In Progress</div></div><span class="badge bg-light fw-bold">48</span></div>
                <div class="task-item"><div><span class="task-title">Fix Navigation Issue</span><div class="task-meta">Testing</div></div><span class="badge bg-light fw-bold">12</span></div>
                <div class="task-item"><div><span class="task-title">User Role Management</span><div class="task-meta text-success">Completed</div></div><span class="badge bg-light fw-bold">96</span></div>
                <div class="task-item"><div><span class="task-title">Database Optimization</span><div class="task-meta text-success">Completed</div></div><span class="badge bg-light fw-bold">96</span></div>
                <div class="mt-2"><a href="#" class="text-decoration-none fs-small">View all tasks <i class="fas fa-arrow-right ms-1"></i></a></div>
            </div>
        </div>

        <!-- Project Overview + Work Items Hierarchy -->
        <div class="col-lg-4">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-3"><i class="fas fa-project-diagram me-2 text-secondary"></i>Project Overview</h6>
                <div class="fw-semibold">SponicHR - Web Version</div>
                <div class="d-flex justify-content-between mt-2"><span class="text-muted">Start Date</span> <span>Jul 20, 2026</span></div>
                <div class="d-flex justify-content-between"><span class="text-muted">End Date</span> <span>Dec 31, 2026</span></div>
                <hr>
                <h6 class="mt-2 fw-semibold fs-sm">Work Items Hierarchy</h6>
                <div class="d-flex flex-wrap gap-3">
                    <span><i class="fas fa-folder text-primary"></i> Module</span>
                    <span><i class="fas fa-folder-open text-info"></i> Sub Module</span>
                    <span><i class="fas fa-tasks text-success"></i> Task</span>
                    <span><i class="fas fa-check-square text-secondary"></i> Sub Tasks</span>
                </div>
                <hr>
                <div class="text-end"><a href="#" class="text-decoration-none fs-small">View Details <i class="fas fa-arrow-right ms-1"></i></a></div>
            </div>
        </div>

        <!-- Top Members Contribution -->
        <div class="col-lg-3">
            <div class="card h-100 p-3">
                <h6 class="card-title mb-3"><i class="fas fa-user-friends me-2 text-secondary"></i>Top Members</h6>
                <div class="mb-3">
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Alice Johnson</span> <span>32 tasks</span></div>
                    <div class="member-progress"><span class="fs-small">85%</span><div class="bar"><div class="bar-fill" style="width:85%"></div></div></div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Robert Smith</span> <span>28 tasks</span></div>
                    <div class="member-progress"><span class="fs-small">72%</span><div class="bar"><div class="bar-fill" style="width:72%"></div></div></div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Emily Davis</span> <span>21 tasks</span></div>
                    <div class="member-progress"><span class="fs-small">60%</span><div class="bar"><div class="bar-fill" style="width:60%"></div></div></div>
                </div>
                <div>
                    <div class="d-flex justify-content-between"><span class="fw-semibold">Michael Brown</span> <span>18 tasks</span></div>
                    <div class="member-progress"><span class="fs-small">50%</span><div class="bar"><div class="bar-fill" style="width:50%"></div></div></div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer hint (invisible) -->
    <div class="mt-4 text-center text-muted opacity-50 fs-small">SponicHR · Dashboard v1.0</div>
</div>



@endsection
@section('script')


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Progress Pie
        const ctx1 = document.getElementById('progressPieChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Completed', 'In Progress', 'Pending'],
                datasets: [{
                    data: [68, 20, 12],
                    backgroundColor: ['#28a745', '#ffc107', '#6c757d'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Work Items Doughnut
        const ctx2 = document.getElementById('workItemsChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending'],
                datasets: [{
                    data: [68, 20, 12],
                    backgroundColor: ['#0d6efd', '#0dcaf0', '#6c757d'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: '70%'
            }
        });
    });
</script>
<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection