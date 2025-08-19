<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar Tracker System Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Add your ViewProject.css styles here */
        .viewproject-container {
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        
        .project-details {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid #eee;
        }
        
        .project-chat {
            width: 350px;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #eee;
        }
        
        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .project-header h2 {
            margin: 0;
            color: #333;
        }
        
        .project-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        
        .project-status.development-phase {
            background-color: #ffd700;
            color: #333;
        }
        
        .project-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .progress-container {
            margin-bottom: 30px;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .progress-bar {
            height: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background-color: #4CAF50;
            border-radius: 5px;
        }
        
        .project-info-section {
            margin-bottom: 30px;
        }
        
        .project-info-section h3 {
            color: #444;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .info-label {
            display: block;
            font-size: 14px;
            color: #888;
            margin-bottom: 5px;
        }
        
        .info-value {
            display: block;
            font-weight: bold;
            color: #333;
        }
        
        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .member-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        
        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #4CAF50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .member-info {
            display: flex;
            flex-direction: column;
        }
        
        .member-name {
            font-weight: bold;
            color: #333;
        }
        
        .member-role {
            font-size: 12px;
            color: #666;
        }
        
        .repo-link {
            display: inline-block;
            padding: 8px 15px;
            background-color: #f0f0f0;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
            font-family: monospace;
        }
        
        .repo-link:hover {
            background-color: #e0e0e0;
        }
        
        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #f9f9f9;
        }
        
        .chat-header h3 {
            margin: 0;
            color: #333;
        }
        
        .chat-box {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #fff;
        }
        
        .chat-message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            max-width: 80%;
        }
        
        .chat-message.mine {
            align-self: flex-end;
            align-items: flex-end;
        }
        
        .message-sender {
            font-size: 12px;
            color: #666;
            margin-bottom: 3px;
        }
        
        .message-content {
            padding: 10px 15px;
            border-radius: 18px;
            background-color: #f0f0f0;
            position: relative;
        }
        
        .chat-message.mine .message-content {
            background-color: #4CAF50;
            color: white;
        }
        
        .message-text {
            margin-bottom: 5px;
        }
        
        .message-time {
            font-size: 10px;
            color: #999;
            text-align: right;
        }
        
        .chat-message.mine .message-time {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .chat-input {
            display: flex;
            padding: 15px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
        }
        
        .chat-input input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
        }
        
        .chat-input button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background-color: #4CAF50;
            color: white;
            margin-left: 10px;
            cursor: pointer;
        }
        
        .custom-scroll {
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }
        
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="viewproject-container">
        <!-- Left Side - Project Details -->
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

        <!-- Right Side - Group Messages -->
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
                <input type="text" placeholder="Write your message here...">
                <button>
                    <i class="fas fa-comment-alt"></i>
                </button>
            </div>
        </div>
    </div>
</body>
</html>