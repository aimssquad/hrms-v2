@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Permission Master'))
@section('css')
<style>
    .form-check-input:checked {
        background-color: #ff8c00;
        border-color: #ff8c00;
    }
    .permission-group {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .permission-group-title {
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 8px;
        margin-bottom: 12px;
        cursor: pointer;
    }
    .permission-group-title:hover {
        color: #ff8c00;
    }
    .checkbox-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }
    .reminder-settings {
        background: #f1f3f5;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
    }
    .reminder-settings .form-group {
        margin-bottom: 15px;
    }
    .demo-badge {
        font-size: 10px;
        background: #ff8c00;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Project Permission Master <span class="demo-badge">DEMO</span></h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                    <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                    <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Project Permission Master')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    @include('employeer.layout.message')
    
    <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Assign Permissions to Role</h4>
        </div>
        <div class="row p-3">
            <div class="col-md-5">
                <strong>TASK NAME:</strong> {{ $workItemData->title ?? 'N/A' }}
            </div>
            <div class="col-md-5">
                <strong>Task End Date:</strong> {{ isset($workItemData->end_date) ? \Carbon\Carbon::parse($workItemData->end_date)->format('d M Y') : 'N/A' }}
            </div>
        </div>

        <div class="card-body">
            <form action="{{ url('org-project-control/'.request()->route('id').'/remainder-mail-settings') }}" method="POST">
                @csrf
                <input type="hidden" name="work_item_id" value="{{ $workItemData->id ?? '' }}">
                <input type="hidden" name="project_id" value="{{ $project->id ?? '' }}">
                
                <!-- Work Item Reminder Settings - Additional Fields with Demo Data -->
                <div class="reminder-settings">
                    <h5 class="permission-group-title">⏰ Work Item Reminder Settings</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">Select Employee(s)</label>
                                <select name="employee_ids[]" id="employee_ids" class="form-select select" multiple="multiple" required>
                                    <option value="">-- Select Employees --</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->employee_id }}">
                                            {{ $employee->name }} 
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple employees</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label fw-bold">Reminder Type</label>
                                <select name="reminder_type" class="form-select" required>
                                    <option value="before_due" {{ old('reminder_type') == 'before_due' ? 'selected' : '' }}>Before Due</option>
                                    <option value="due_today" {{ old('reminder_type') == 'due_today' ? 'selected' : '' }}>Due Today</option>
                                    <option value="overdue" {{ old('reminder_type') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label fw-bold">Days Before</label>
                                <input type="number" name="days_before" class="form-control" value="{{ old('days_before', 3) }}" min="1" max="30" required>
                                <small class="text-muted">Number of days before due date</small>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Sent</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label fw-bold">Sent At</label>
                                <input type="datetime-local" name="sent_at" class="form-control" value="{{ old('sent_at') }}">
                                <small class="text-muted">When the reminder was sent (optional)</small>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Sent At</label>
                                <input type="datetime-local" name="sent_at" class="form-control" value="{{ old('sent_at') }}">
                                <small class="text-muted">When the reminder was sent (optional)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Work Item</label>
                                <input type="text" class="form-control" value="{{ $workItemData->title ?? 'N/A' }}" readonly disabled>
                                <small class="text-muted">Current work item</small>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <!-- Submit -->
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-2"></i> Send Reminder
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
{{-- <script>
    $(document).ready(function() {
        // Initialize select2 or other select enhancements
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select').select2({
                theme: 'bootstrap-5'
            });
        }

        // Toggle all permissions in a group when clicking the group title
        $('.permission-group-title').on('click', function() {
            const checkboxes = $(this).closest('.permission-group').find('.form-check-input');
            const allChecked = checkboxes.length === checkboxes.filter(':checked').length;
            checkboxes.prop('checked', !allChecked);
        });

        // Add hover effect for better UX
        $('.permission-group').hover(
            function() {
                $(this).css('box-shadow', '0 2px 8px rgba(255, 140, 0, 0.1)');
            },
            function() {
                $(this).css('box-shadow', 'none');
            }
        );

        // Validate at least one permission is selected before submit
        $('form').on('submit', function(e) {
            const checked = $(this).find('input[name="permissions[]"]:checked').length;
            if (checked === 0) {
                e.preventDefault();
                alert('Please select at least one permission.');
                return false;
            }
        });
    });
</script> --}}
<script>
    $(document).ready(function() {
        // Initialize select2 with multi-select configuration
        if (typeof $.fn.select2 !== 'undefined') {
            $('#employee_ids').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select employees...',
                allowClear: true,
                closeOnSelect: false,
                width: '100%'
            });
        }

        // Form validation
        $('form').on('submit', function(e) {
            // Validate at least one employee is selected
            const selectedEmployees = $(this).find('select[name="employee_ids[]"]').val();
            if (!selectedEmployees || selectedEmployees.length === 0) {
                e.preventDefault();
                alert('Please select at least one employee.');
                return false;
            }

            // Validate days_before
            const daysBefore = $(this).find('input[name="days_before"]').val();
            if (daysBefore && (parseInt(daysBefore) < 1 || parseInt(daysBefore) > 30)) {
                e.preventDefault();
                alert('Days before must be between 1 and 30.');
                return false;
            }
        });

        // Auto-set sent_at if status is "Sent"
        $('select[name="status"]').on('change', function() {
            if ($(this).val() == '1') {
                const now = new Date();
                const formatted = now.toISOString().slice(0, 16);
                $('input[name="sent_at"]').val(formatted);
            } else {
                $('input[name="sent_at"]').val('');
            }
        });

        // Calculate days between now and end date
        const endDate = '{{ $workItemData->end_date ?? '' }}';
        if (endDate) {
            const end = new Date(endDate);
            const now = new Date();
            const diffTime = Math.abs(end - now);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays > 0 && diffDays <= 30) {
                $('input[name="days_before"]').val(diffDays);
            }
        }
    });
</script>

@endsection