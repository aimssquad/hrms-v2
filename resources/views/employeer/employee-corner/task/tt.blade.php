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
        <!-- /Page Header -->
        
        {{-- <div class="card mb-0"> --}}
            
                <div class="viewproject-container">
                    <!-- Left Side - Project Details -->
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="project-details custom-scroll">
                                <div class="project-header">
                                    <h2>Solar Tracker System</h2>
                                    <div class="project-status development-phase">
                                        Development Phase
                                    </div>
                                </div>

                                <p class="project-description">A system that automatically adjusts solar panels to track the sun's movement throughout the day to maximize energy efficiency and output by maintaining optimal panel orientation.</p>

                                <div class="project-info-section">
                                    <h3><i class="fas fa-calendar-alt"></i> Timeline</h3>
                                    <div class="info-grid">
                                        <div>
                                            <span class="info-label">Start Date</span>
                                            <span class="info-value">May 15, 2025</span>
                                        </div>
                                        <div>
                                            <span class="info-label">Deadline</span>
                                            <span class="info-value">September 20, 2025</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="project-info-section">
                                    <h3><i class="fas fa-users"></i> Team Members</h3>
                                    <div class="members-grid">
                                        <div class="member-card">
                                            <div class="member-avatar">A</div>
                                            <div class="member-info">
                                                <span class="member-name">Aminul</span>
                                                <span class="member-role">Team Lead</span>
                                            </div>
                                        </div>
                                        <div class="member-card">
                                            <div class="member-avatar">R</div>
                                            <div class="member-info">
                                                <span class="member-name">Rahul</span>
                                                <span class="member-role">Backend Developer</span>
                                            </div>
                                        </div>
                                        <div class="member-card">
                                            <div class="member-avatar">P</div>
                                            <div class="member-info">
                                                <span class="member-name">Priya</span>
                                                <span class="member-role">QA Engineer</span>
                                            </div>
                                        </div>
                                        <div class="member-card">
                                            <div class="member-avatar">S</div>
                                            <div class="member-info">
                                                <span class="member-name">Sneha</span>
                                                <span class="member-role">UI/UX Designer</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="project-info-section">
                                    <h3><i class="fas fa-code-branch"></i> Repository</h3>
                                    <a
                                        href="https://github.com/team-solar/solar-tracker"
                                        class="repo-link"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        github.com/team-solar/solar-tracker
                                    </a>
                                </div>
                            </div>
                        </div>   
                        <div class="col-md-6 col-sm-12">
                            <div class="project-chat">
                                <div class="chat-header">
                                    <i class="fas fa-comment-alt"></i>
                                    <h3>Team Discussion</h3>
                                </div>
                                <div class="chat-box custom-scroll">
                                    <div class="chat-message mine">
                                        <div class="message-content">
                                            <div class="message-text">Hey team, just checking in - the project is on track for our deadline!</div>
                                            <div class="message-time">10:30 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Rahul</div>
                                        <div class="message-content">
                                            <div class="message-text">I've updated the documentation with the new API endpoints.</div>
                                            <div class="message-time">10:35 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Priya</div>
                                        <div class="message-content">
                                            <div class="message-text">Testing will begin tomorrow morning. I've prepared all the test cases.</div>
                                            <div class="message-time">10:40 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Sneha</div>
                                        <div class="message-content">
                                            <div class="message-text">The final UI designs are complete. I'll implement them by tonight.</div>
                                            <div class="message-time">10:45 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message mine">
                                        <div class="message-content">
                                            <div class="message-text">Great progress everyone! Remember to push your latest code to the GitHub repository.</div>
                                            <div class="message-time">10:50 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Rahul</div>
                                        <div class="message-content">
                                            <div class="message-text">Just pushed my changes. Everyone please pull before making new updates.</div>
                                            <div class="message-time">10:55 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Priya</div>
                                        <div class="message-content">
                                            <div class="message-text">I've pulled the latest updates. No merge conflicts so far.</div>
                                            <div class="message-time">11:00 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Sneha</div>
                                        <div class="message-content">
                                            <div class="message-text">Can we schedule a quick sync meeting after lunch?</div>
                                            <div class="message-time">11:05 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message mine">
                                        <div class="message-content">
                                            <div class="message-text">Sure, let's meet at 2:00 PM in the conference room.</div>
                                            <div class="message-time">11:07 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Rahul</div>
                                        <div class="message-content">
                                            <div class="message-text">Works perfectly for my schedule.</div>
                                            <div class="message-time">11:08 AM</div>
                                        </div>
                                    </div>
                                    <div class="chat-message">
                                        <div class="message-sender">Priya</div>
                                        <div class="message-content">
                                            <div class="message-text">Same here! Looking forward to it 👍</div>
                                            <div class="message-time">11:09 AM</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-input">
                                    {{-- <div class="file-input-container">
                                        <label for="file-upload" class="file-upload-btn">
                                        <i class="fas fa-paperclip"></i>
                                        <input type="file" id="file-upload" class="d-none">
                                        </label>
                                    </div> --}}
                                    <input type="text" placeholder="Write your message here...">
                                    <button>
                                        <i class="fas fa-comment-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
           
        {{-- </div> --}}
    </div>    
@endsection

