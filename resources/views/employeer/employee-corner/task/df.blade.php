@extends('employeer.employee-corner.main')
@section('title', 'Project Discussion')
@section('css')
    <style>
    /* Your existing CSS styles here */
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

    /* Chat Styles */
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

    /* File attachment styles */
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

    .file-attachment {
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 5px;
    margin: 8px 0;
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
                    <div class="project-details custom-scroll">
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

                        <div class="project-info-section">
                            <h3><i class="fas fa-code-branch"></i> Repository</h3>
                            <a
                                href="#"
                                class="repo-link"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                github.com/{{ str_replace(' ', '-', strtolower($groupedData['project']['title'])) }}
                            </a>
                        </div>
                    </div>
                </div>   
                
                <!-- Right Side - Chat -->
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
                                        @if($post->employee_code != $employee_code)
                                            <div class="message-sender">
                                                {{ App\Models\User::where('employee_id', $post->employee_code)->first()->name ?? $post->employee_code }}
                                            </div>
                                        @endif
                                        
                                        <div class="message-content">
                                            @if($post->employee_code == $employee_code)
                                                <div class="message-menu">
                                                    <button class="menu-toggle" onclick="toggleMenu({{ $post->id }})">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="menu-dropdown" id="menu-{{ $post->id }}">
                                                        <div class="menu-item edit" onclick="openEditModal({{ $post->id }})">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </div>
                                                        <div class="menu-item delete" onclick="deletePost({{ $post->id }})">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($post->title)
                                                <div class="message-text">{{ $post->title }}</div>
                                            @endif
                                            
                                            {{-- Display file attachment if exists --}}
                                            @if($post->file)
                                                @php
                                                    $fileExtension = pathinfo($post->file, PATHINFO_EXTENSION);
                                                    $fileIcon = 'fa-file';
                                                    $fileType = 'file';
                                                    
                                                    if (in_array($fileExtension, ['pdf'])) {
                                                        $fileIcon = 'fa-file-pdf';
                                                        $fileType = 'pdf';
                                                    } elseif (in_array($fileExtension, ['xlsx', 'xls'])) {
                                                        $fileIcon = 'fa-file-excel';
                                                        $fileType = 'excel';
                                                    } elseif (in_array($fileExtension, ['png', 'jpg', 'jpeg', 'gif'])) {
                                                        $fileIcon = 'fa-file-image';
                                                        $fileType = 'image';
                                                    }
                                                    
                                                    $fileSize = Storage::disk('public')->exists($post->file) ? 
                                                        number_format(Storage::disk('public')->size($post->file) / 1024 / 1024, 2) . ' MB' : 
                                                        'Unknown size';
                                                @endphp
                                                
                                                @if($fileType === 'image')
                                                    <div class="attachment">
                                                        <a href="{{ asset('storage/' . $post->file) }}" download>
                                                        <img src="{{ asset('storage/' . $post->file) }}" alt="Attachment" style="max-width: 200px; max-height: 200px;">
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="file-attachment">
                                                        <div class="file-icon">
                                                            <i class="fas {{ $fileIcon }}"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <div class="file-name">{{ basename($post->file) }}</div>
                                                            <div class="file-size">{{ $fileSize }}</div>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $post->file) }}" class="download-btn" download>
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                            
                                            <div class="message-time">
                                                {{ $post->created_at->format('h:i A') }} • 
                                                {{ $post->created_at->format('M j, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Add divider for different dates --}}
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
                    <button type="submit" class="btn-submit" style="background-color: #f72585;">Delete</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // JavaScript for handling file upload, menu toggles, and modals
        document.getElementById('file-upload').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                console.log('Selected file:', fileName);
            }
        });

        function toggleMenu(postId) {
            const menu = document.getElementById(`menu-${postId}`);
            const isVisible = menu.classList.contains('show');
            
            document.querySelectorAll('.menu-dropdown.show').forEach(openMenu => {
                if (openMenu.id !== `menu-${postId}`) {
                    openMenu.classList.remove('show');
                }
            });
            
            if (isVisible) {
                menu.classList.remove('show');
            } else {
                menu.classList.add('show');
            }
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.message-menu')) {
                document.querySelectorAll('.menu-dropdown.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        function openEditModal(postId) {
            document.querySelectorAll('.menu-dropdown.show').forEach(menu => {
                menu.classList.remove('show');
            });
            
            fetch(`/project-posts/${postId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('edit-post-id').value = postId;
                        document.getElementById('edit-title').value = data.post.title;
                        
                        const currentFileInfo = document.getElementById('current-file-info');
                        if (data.post.file) {
                            const fileName = data.post.file.split('/').pop();
                            currentFileInfo.innerHTML = `Current file: ${fileName}`;
                        } else {
                            currentFileInfo.innerHTML = 'No file attached';
                        }
                        
                        document.getElementById('edit-form').action = `/project-posts/${postId}`;
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
                    document.getElementById(`post-${postId}`).remove();
                    closeDeleteModal();
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