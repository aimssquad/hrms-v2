@extends('employeer.employee-corner.main')
@section('title', 'Project Discussion')
@section('css')
    <style>
        /* styles.css */
        :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --secondary: #3f37c9;
        --dark: #212529;
        --light: #f8f9fa;
        --gray: #6c757d;
        --success: #4cc9f0;
        --warning: #f8961e;
        --danger: #f72585;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        }

        body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: var(--dark);
        background-color: #f5f7fb;
        }

        .viewproject-container {
        display: flex;
        gap: 24px;
        height: 85vh;
        max-width: 1600px;
        margin: 20px auto;
        padding: 0 20px;
        }

        /* Left Side - Project Details */
        .project-details {
        flex: 1;
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: var(--card-shadow);
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        }

        .project-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        }

        .project-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--dark);
        }

        .project-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        }

        .project-status.development-phase {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary);
        }

        .project-description {
        color: var(--gray);
        font-size: 15px;
        line-height: 1.7;
        }

        .progress-container {
        margin: 20px 0;
        }

        .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
        color: var(--gray);
        }

        .progress-label span:last-child {
        font-weight: 600;
        color: var(--primary);
        }

        .progress-bar {
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        }

        .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        border-radius: 4px;
        transition: width 0.3s ease;
        }

        .project-info-section {
        display: flex;
        flex-direction: column;
        gap: 16px;
        }

        .project-info-section h3 {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 18px;
        color: var(--dark);
        }

        .project-info-section h3 .fas {
        color: var(--primary);
        }

        .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        }

        .info-grid > div {
        background: #f8f9fa;
        padding: 12px 16px;
        border-radius: 8px;
        }

        .info-label {
        display: block;
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 4px;
        }

        .info-value {
        font-size: 14px;
        font-weight: 500;
        }

        .members-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        }

        .member-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: transform 0.2s;
        }

        .member-card:hover {
        transform: translateY(-2px);
        }

        .member-avatar {
        width: 36px;
        height: 36px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        }

        .member-info {
        display: flex;
        flex-direction: column;
        }

        .member-name {
        font-size: 14px;
        font-weight: 600;
        }

        .member-role {
        font-size: 12px;
        color: var(--gray);
        }

        .repo-link {
        display: inline-block;
        padding: 10px 16px;
        background: #f8f9fa;
        border-radius: 8px;
        color: var(--primary);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
        }

        .repo-link:hover {
        background: rgba(67, 97, 238, 0.1);
        }

        /* Right Side - Chat */
        .project-chat {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        }

        .chat-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        }

        .chat-header h3 {
        font-size: 18px;
        font-weight: 600;
        }

        .chat-header .fas {
        color: var(--primary);
        }

        .chat-box {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
        background-color: #fafafa;
        }

        .chat-message {
        display: flex;
        flex-direction: column;
        max-width: 75%;
        }

        .chat-message.mine {
        align-self: flex-end;
        }

        .chat-message:not(.mine) {
        align-self: flex-start;
        }

        .message-sender {
        font-size: 12px;
        font-weight: 600;
        color: var(--gray);
        margin-bottom: 4px;
        margin-left: 8px;
        }

        .message-content {
        padding: 12px 16px;
        border-radius: 18px;
        position: relative;
        word-wrap: break-word;
        }

        .chat-message:not(.mine) .message-content {
        background: white;
        border-top-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .chat-message.mine .message-content {
        background: #FF902F;
        color: white;
        border-top-right-radius: 4px;
        }

        .message-text {
        font-size: 14px;
        line-height: 1.5;
        }

        .message-time {
        font-size: 11px;
        margin-top: 4px;
        text-align: right;
        }

        .chat-message:not(.mine) .message-time {
        color: var(--gray);
        }

        .chat-message.mine .message-time {
        color: rgba(255, 255, 255, 0.7);
        }

        .chat-input {
        display: flex;
        padding: 16px;
        border-top: 1px solid #e9ecef;
        background: white;
        }

        .chat-input input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #e9ecef;
        border-radius: 24px;
        outline: none;
        font-size: 14px;
        transition: all 0.2s;
        }

        .chat-input input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .chat-input button {
        width: 48px;
        height: 48px;
        margin-left: 12px;
        background: #FF902F;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        }

        .chat-input button:hover {
        background: #f97706;
        transform: translateY(-2px);
        }

        .chat-input button .fas {
        width: 20px;
        height: 20px;
        }

        /* Add these styles to your CSS */
        .project-chat {
        display: flex;
        flex-direction: column;
        height: 100%; /* Make sure it takes full height of parent */
        max-height: 85vh; /* Or whatever maximum height you prefer */
        }

        .chat-box {
        flex: 1; /* This makes it grow to fill available space */
        overflow-y: auto; /* Enables vertical scrolling */
        min-height: 0; /* Important for flex children to scroll properly */
        }

        /* If you're using Bootstrap rows, you might also need: */
        .row {
        height: 100%;
        }

        .col-md-6 {
        height: 100%;
        }
        /* File input styles */
        .file-input-container {
        position: relative;
        margin-right: 10px;
        
        }

        .file-upload-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        color: var(--gray);
        cursor: pointer;
        transition: all 0.2s;
        }

        .file-upload-btn:hover {
        background: #dee2e6;
        color: var(--dark);
        }

        .d-none {
        display: none !important;
        }

        /* Adjust the text input to account for new button */
        .chat-input input[type="text"] {
        flex: 1;
        margin: 0 10px;
        }
    </style>
    <style>
        .file-upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: #54656f;
            font-size: 20px;
            cursor: pointer;
        }
        
        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .chat-message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            background: #f8f9fa;
        }

        /* .chat-message.mine {
            background: #007bff;
            color: white;
            margin-left: 20%;
        } */

        .chat-message.mine .message-time {
            color: rgba(255, 255, 255, 0.8);
        }

        .message-sender {
            font-weight: bold;
            margin-bottom: 5px;
            color: #495057;
        }

        .message-content {
            position: relative;
        }

        .message-text {
            margin-bottom: 8px;
        }

        .message-time {
            font-size: 11px;
            color: #6c757d;
            text-align: right;
        }

        .file-attachment {
            display: flex;
            align-items: center;
            /* background: rgb(248, 179, 75); */
            padding: 10px;
            border-radius: 5px;
            margin: 8px 0;
            /* border: 1px solid #dee2e6; */
        }

        .file-icon {
            margin-right: 10px;
            font-size: 20px;
            color: #dc3545;
        }

        .file-icon .fa-file-excel {
            color: #28a745;
        }

        .file-icon .fa-file-pdf {
            color: #dc3545;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            font-size: 14px;
        }

        .file-size {
            font-size: 12px;
            color: #6c757d;
        }

        .download-btn {
            padding: 5px;
            cursor: pointer;
            color: #6a6b6b;
        }

        .attachment img {
            max-width: 100%;
            border-radius: 5px;
            margin: 8px 0;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider-text {
            background: white;
            padding: 0 15px;
            color: #6c757d;
            font-size: 12px;
        }

        .divider:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
            z-index: -1;
        }

        .no-messages {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .no-messages i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Three-dot menu styles */
        .message-menu {
            position: absolute;
            top: 8px;
            right: 8px;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .chat-message.mine:hover .message-menu {
            opacity: 1;
        }

        .menu-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            padding: 4px;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-message.mine .menu-toggle:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .chat-message:not(.mine) .menu-toggle {
            color: #6c757d;
        }

        .chat-message:not(.mine) .menu-toggle:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .menu-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10;
            min-width: 120px;
            display: none;
        }

        .menu-dropdown.show {
            display: block;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            cursor: pointer;
            color: #495057;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .menu-item:hover {
            background-color: #f8f9fa;
        }

        .menu-item i {
            margin-right: 8px;
            font-size: 12px;
        }

        .menu-item.edit {
            color: #4361ee;
        }

        .menu-item.delete {
            color: #f72585;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6c757d;
        }

        .modal-form-group {
            margin-bottom: 16px;
        }

        .modal-form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .modal-form-group input,
        .modal-form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-size: 14px;
        }

        .modal-form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .current-file {
            margin-top: 8px;
            font-size: 14px;
            color: #6c757d;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-cancel {
            padding: 8px 16px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            color: #6c757d;
        }

        .btn-submit {
            padding: 8px 16px;
            background-color: #FF902F;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
        }
    </style>
    <style>
         :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --dark: #212529;
            --light: #f8f9fa;
            --gray: #6c757d;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f72585;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            }

            body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f5f7fb;
            }

            .viewproject-container {
            display: flex;
            gap: 24px;
            height: 85vh;
            max-width: 1600px;
            margin: 20px auto;
            padding: 0 20px;
            }

            /* Project Details Styles */
            .project-details {
            flex: 1;
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: var(--card-shadow);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            }

            .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            }

            .project-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            }

            .project-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            }

            .project-status.development-phase {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            }

            .project-status.open {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            }

            .project-status.completed {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
            }

            .project-description {
            color: var(--gray);
            font-size: 15px;
            line-height: 1.7;
            }

            .project-info-section {
            display: flex;
            flex-direction: column;
            gap: 16px;
            }

            .project-info-section h3 {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            color: var(--dark);
            }

            .project-info-section h3 .fas {
            color: var(--primary);
            }

            .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            }

            .info-grid > div {
            background: #f8f9fa;
            padding: 12px 16px;
            border-radius: 8px;
            }

            .info-label {
            display: block;
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 4px;
            }

            .info-value {
            font-size: 14px;
            font-weight: 500;
            }

            .members-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            }

            .member-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: transform 0.2s;
            }

            .member-card:hover {
            transform: translateY(-2px);
            }

            .member-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            }

            .member-info {
            display: flex;
            flex-direction: column;
            }

            .member-name {
            font-size: 14px;
            font-weight: 600;
            }

            .member-role {
            font-size: 12px;
            color: var(--gray);
            }

            .repo-link {
            display: inline-block;
            padding: 10px 16px;
            background: #f8f9fa;
            border-radius: 8px;
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            }

            .repo-link:hover {
            background: rgba(67, 97, 238, 0.1);
            }

            /* Tasks List Styles */
            .tasks-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            }

            .task-item {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #FF902F;
            }

            .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            }

            .task-header h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            }

            .task-dates {
            font-size: 12px;
            color: #6c757d;
            }

            .task-description {
            margin: 0;
            font-size: 13px;
            color: #495057;
            }
    </style>
    
@endsection


@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title" style="color:#ff902f">Project Discussion</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}" style="color:#ff902f">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color:#ff902f">Project Discussion</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="viewproject-container">
            <!-- Left Side - Project Details -->
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="project-details ">
                        <div class="project-header">
                            <h2>{{ $groupedData['project']['title'] }}</h2>
                            <div class="project-status {{ $groupedData['project']['status'] }}">
                                {{ ucfirst($groupedData['project']['status']) }}
                            </div>
                        </div>

                        <p class="project-description">{{ $groupedData['project']['description'] }}</p>

                        <div class="project-info-section">
                            <h3><i class="fas fa-calendar-alt"></i> Timeline</h3>
                            <div class="info-grid">
                                <div>
                                    <span class="info-label">Start Date</span>
                                    @if(count($groupedData['tasks']) > 0)
                                        @php
                                            $startDates = array_column($groupedData['tasks'], 'start_date');
                                            $earliestStartDate = min($startDates);
                                        @endphp
                                        <span class="info-value">{{ \Carbon\Carbon::parse($earliestStartDate)->format('M d, Y') }}</span>
                                    @else
                                        <span class="info-value">Not set</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="info-label">Deadline</span>
                                    @if(count($groupedData['tasks']) > 0)
                                        @php
                                            $endDates = array_column($groupedData['tasks'], 'expected_end_date');
                                            $latestEndDate = max($endDates);
                                        @endphp
                                        <span class="info-value">{{ \Carbon\Carbon::parse($latestEndDate)->format('M d, Y') }}</span>
                                    @else
                                        <span class="info-value">Not set</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="project-info-section">
                            <h3><i class="fas fa-users"></i> Team Members</h3>
                            <div class="members-grid">
                                @foreach($groupedData['members'] as $member)
                                    <div class="member-card">
                                        <div class="member-avatar">{{ substr($member['name'], 0, 1) }}</div>
                                        <div class="member-info">
                                            <span class="member-name">{{ $member['name'] }}</span>
                                            <span class="member-role">{{ $member['role'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="project-info-section">
                            <h3><i class="fas fa-tasks"></i> Project Tasks</h3>
                            @if(count($groupedData['tasks']) > 0)
                                <div class="tasks-list">
                                    @foreach($groupedData['tasks'] as $task)
                                        <div class="task-item">
                                            <div class="task-header">
                                                <h4>{{ $task['task_name'] }}</h4>
                                                <span class="task-dates">
                                                    {{ \Carbon\Carbon::parse($task['start_date'])->format('M d') }} - 
                                                    {{ \Carbon\Carbon::parse($task['expected_end_date'])->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <p class="task-description">{{ $task['task_desc'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No tasks created for this project yet.</p>
                            @endif
                        </div>

                    </div>
                </div>     
                <div class="col-md-6 col-sm-12">
                    <div class="project-chat">
                        <div class="chat-header">
                            <i class="fas fa-comment-alt"></i>
                            <h3>Team Discussion ({{ $groupedData['project']['title'] }})</h3>
                        </div>
                        
                        <div class="chat-box custom-scroll">
                            @if($data['post_data']->count() > 0)
                                @foreach($data['post_data'] as $post)
                                    <div class="chat-message {{ $post->employee_code == $employee_code ? 'mine' : '' }}" id="post-{{ $post->id }}">
                                        {{-- Sender --}}
                                        @if($post->employee_code != $employee_code)
                                            <div class="message-sender">
                                                {{ $post->user->name ?? $post->employee_code }}
                                            </div>
                                        @endif
                                        
                                        {{-- Main Post Content --}}
                                        <div class="message-content">
                                            {{-- Edit/Delete Menu for my posts --}}
                                            @if($post->employee_code == $employee_code)
                                                <div class="message-menu">
                                                    <button class="menu-toggle" onclick="toggleMenu({{ $post->id }})">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="menu-dropdown" id="menu-{{ $post->id }}">
                                                        <div class="menu-item edit" onclick="openEditModal({{ $post->id }})">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </div>
                                                        <div class="menu-item delete btn-btnp" onclick="deletePost({{ $post->id }})">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            {{-- Post Text --}}
                                            @if($post->title)
                                                <div class="message-text">{{ $post->title }}</div>
                                            @endif
                                            
                                            {{-- Attachments --}}
                                            @if($post->file)
                                                @php
                                                    $fileExtension = pathinfo($post->file, PATHINFO_EXTENSION);
                                                    $fileType = in_array($fileExtension, ['png','jpg','jpeg','gif']) ? 'image' : 'file';
                                                @endphp

                                                @if($fileType === 'image')
                                                    <div class="attachment">
                                                        <a href="{{ asset('storage/' . $post->file) }}" download>
                                                            <img src="{{ asset('storage/' . $post->file) }}" alt="Attachment" style="max-width: 200px; max-height: 200px;">
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="file-attachment">
                                                        <i class="fas fa-file"></i>
                                                        <a href="{{ asset('storage/' . $post->file) }}" download>
                                                            {{ basename($post->file) }}
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                            
                                            <div class="message-time">
                                                {{ $post->created_at->format('h:i A • M j, Y') }}
                                            </div>
                                        </div>

                                        {{-- Replies Section --}}
                                        @if($post->replies->count() > 0)
                                            <div class="replies">
                                                @foreach($post->replies as $reply)
                                                    <div class="reply-message {{ $reply->employee_code == $employee_code ? 'mine' : '' }}">
                                                        <div class="reply-content">
                                                            <strong>{{ $reply->user->name ?? $reply->employee_code }}:</strong> 
                                                            {{ $reply->reply_text }}
                                                            <div class="reply-time">
                                                                {{ $reply->created_at->format('h:i A • M j, Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Reply Form --}}
                                        <form action="{{ route('project.post.reply') }}" method="post" class="reply-form">
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $data['id'] }}">
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <div class="reply-input">
                                                <input type="text" name="reply_text" placeholder="Write a reply..." required>
                                                <button type="submit"><i class="fas fa-reply"></i></button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Divider for dates --}}
                                    @if(!$loop->last && !$post->created_at->isSameDay($data['post_data'][$loop->index + 1]->created_at))
                                        <div class="divider">
                                            <span class="divider-text">{{ $data['post_data'][$loop->index + 1]->created_at->format('F j, Y') }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="no-messages">
                                    <i class="fas fa-comments"></i>
                                    <p>No messages yet. Start the conversation!</p>
                                </div>
                            @endif
                        </div>
                        
                        {{-- New Post Form --}}
                        <form action="{{ route('project.post') }}" method="post" enctype="multipart/form-data" id="post-form">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $data['id'] }}">
                            <div class="chat-input">
                                <div class="file-input-container">
                                    <label for="file-upload" class="file-upload-btn">
                                        <i class="fas fa-paperclip"></i>
                                        <input type="file" id="file-upload" class="file-upload-input" name="file" accept="image/*,.pdf,.xlsx,.xls,.doc,.docx">
                                    </label>
                                </div>
                                <input type="text" name="title" placeholder="Write your message here..." required>
                                <button type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
  
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Post</h3>
                <button class="close-modal" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="edit-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="project_id" value="{{ $data['id'] }}">
                <input type="hidden" name="post_id" id="edit-post-id">
                
                <div class="modal-form-group">
                    <label for="edit-title">Message</label>
                    <textarea name="title" id="edit-title" required></textarea>
                </div>
                
                <div class="modal-form-group">
                    <label for="edit-file">File (Leave empty to keep current file)</label>
                    <input type="file" name="file" id="edit-file" accept="image/*,.pdf,.xlsx,.xls,.doc,.docx">
                    <div class="current-file" id="current-file-info"></div>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Update Post</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Delete</h3>
                <button class="close-modal" onclick="closeDeleteModal()">&times;</button>
            </div>
            <p>Are you sure you want to delete this post? This action cannot be undone.</p>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="post_id" id="delete-post-id">
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="btn-submit btn-primary" >Delete</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Simple JavaScript to handle file upload preview (optional enhancement)
        document.getElementById('file-upload').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                // You could display a preview or file name here
                console.log('Selected file:', fileName);
            }
        });

        // Toggle menu dropdown
        function toggleMenu(postId) {
            const menu = document.getElementById(`menu-${postId}`);
            const isVisible = menu.classList.contains('show');
            
            // Close all other menus
            document.querySelectorAll('.menu-dropdown.show').forEach(openMenu => {
                if (openMenu.id !== `menu-${postId}`) {
                    openMenu.classList.remove('show');
                }
            });
            
            // Toggle current menu
            if (isVisible) {
                menu.classList.remove('show');
            } else {
                menu.classList.add('show');
            }
        }

        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.message-menu')) {
                document.querySelectorAll('.menu-dropdown.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        // Edit and Delete functionality
        function openEditModal(postId) {
            // Close any open menus
            document.querySelectorAll('.menu-dropdown.show').forEach(menu => {
                menu.classList.remove('show');
            });
            
            // Fetch post data via AJAX
            fetch(`/project-posts/${postId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('edit-post-id').value = postId;
                        document.getElementById('edit-title').value = data.post.title;
                        
                        // Show current file info if exists
                        const currentFileInfo = document.getElementById('current-file-info');
                        if (data.post.file) {
                            const fileName = data.post.file.split('/').pop();
                            currentFileInfo.innerHTML = `Current file: ${fileName}`;
                        } else {
                            currentFileInfo.innerHTML = 'No file attached';
                        }
                        
                        // Set form action
                        document.getElementById('edit-form').action = `/project-posts/${postId}`;
                        
                        // Show modal
                        document.getElementById('editModal').style.display = 'flex';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading post data');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function deletePost(postId) {
            // Close any open menus
            document.querySelectorAll('.menu-dropdown.show').forEach(menu => {
                menu.classList.remove('show');
            });
            
            document.getElementById('delete-post-id').value = postId;
            document.getElementById('delete-form').action = `/project-posts/${postId}`;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');
            
            if (event.target === editModal) {
                closeEditModal();
            }
            
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        }

        // Handle form submissions with AJAX
        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const postId = document.getElementById('edit-post-id').value;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to see changes
                    window.location.reload();
                } else {
                    alert('Error updating post: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating post');
            });
        });

        document.getElementById('delete-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const postId = document.getElementById('delete-post-id').value;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the post from the UI
                    document.getElementById(`post-${postId}`).remove();
                    closeDeleteModal();
                    
                    // Show success message
                    alert('Post deleted successfully');
                } else {
                    alert('Error deleting post: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting post');
            });
        });
    </script>
@endsection