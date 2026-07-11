@extends('employeer.task-management.project-management.app')
@section('title', \App\Helpers\Helper::cachedTrans('Chat With Employee'))
@section('css')
<link rel="stylesheet" href="{{ asset('css/project-chat.css') }}">
@endsection
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="page-header">
           
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
               <li class="breadcrumb-item"><a href="#">{{\App\Helpers\Helper::cachedTrans('Chat With Employee')}}</a></li>
            </ul>
         </div>
         {{-- 
         <div class="viewproject-container">
            --}}
            <!-- Left Side - Project Details -->
            <div class="container-fluid">
               <div class="row g-0 h-100">
                  <!-- Left Sidebar - Chat List (like WhatsApp) -->
                  <div class="col-md-4 border-end bg-white" style="height: calc(100vh - 120px); overflow-y: auto;">
                     <div class="d-flex flex-column h-100">
                        <!-- Header -->
                        {{-- <div class="p-3 border-bottom bg-light">
                           <h5 class="mb-0 text-dark">{{ \App\Helpers\Helper::cachedTrans('Messages') }}</h5>
                           <small class="text-muted">{{ \App\Helpers\Helper::cachedTrans('Project Discussions') }}</small>
                        </div> --}}
                        {{-- ----- --}}
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                class="form-control border-start-0" 
                                id="groupSearch" 
                                placeholder="Search groups..."
                                onkeyup="filterGroups()">
                            <button class="btn btn-outline-secondary" type="button" onclick="clearGroupSearch()">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                    
                        <!-- Chat List -->
                        <div class="flex-grow-1 overflow-auto">
                           @forelse($projectData as $group)
                           <a href="{{ url('/org-task-management/' . encrypt($group['project_id']) . '/chat') }}"
                              class="d-flex align-items-center p-3 border-bottom text-decoration-none text-dark chat-list-item {{ $data['id'] == $group['project_id'] ? 'active-chat' : '' }}">
                              <!-- Avatar -->
                              <div class="position-relative">
                                 <div class="avatar-circle bg-warning text-white rounded-circle me-3"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                    {{ strtoupper(substr($group['project_name'], 0, 1)) }}
                                 </div>
                                 @if(!empty($group['unread_count']) && $group['unread_count'] > 0)
                                 <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                 {{ $group['unread_count'] }}
                                 </span>
                                 @endif
                              </div>
                              <!-- Chat Info -->
                              <div class="flex-grow-1">
                                 <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 text-dark">{{ \Illuminate\Support\Str::limit($group['project_name'], 25) }}</h6>
                                    <small class="text-muted">{{ $group['time'] ?? '' }}</small>
                                 </div>
                                 <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted text-truncate" style="max-width: 200px;">
                                    @if(!empty($group['employee']))
                                    <strong>{{ $group['employee'] }}:</strong> 
                                    @endif
                                    {{ \Illuminate\Support\Str::limit($group['last_message'] ?? 'No messages yet', 30) }}
                                    </small>
                                 </div>
                              </div>
                           </a>
                           @empty
                           <div class="text-center p-5 text-muted">
                              <i class="fas fa-comments fa-3x mb-3"></i>
                              <p class="mb-0">No project messages yet</p>
                           </div>
                           @endforelse
                        </div>
                        <!-- Current Project Info -->
                        <div class="border-top p-3 bg-light">
                           <small class="text-muted d-block mb-1">Currently viewing:</small>
                           <div class="d-flex align-items-center">
                              <div class="avatar-circle bg-info text-white rounded-circle me-2"
                                 style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                <!--here skd asdais idhaishdhasihdiashidhasdashdhas
                                adasdgas d as diasidasihdiaidaidiaidihd
                                -->
                              </div>
                              <div>
                                 <h6 class="mb-0 text-dark">
                                      <!--here skd asdais idhaishdhasihdiashidhasdashdhas
                                adasdgas d as diasidasihdiaidaidiaidihd
                                -->
                                 </h6>
                                 <small class="text-muted">
                                 {{ count($data['post_data'] ?? []) }} messages
                                 </small>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Right Side - Chat Messages -->
                  <div class="col-md-8 d-flex flex-column" style="height: calc(100vh - 120px);">
                     <!-- Chat Header -->
                     <div class="d-flex align-items-center p-3 border-bottom bg-white">
                        <div class="d-flex align-items-center">
                           <div class="avatar-circle bg-success text-white rounded-circle me-3"
                              style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                               {{ strtoupper(substr($groupedData['project']['title'], 0, 1)) }}
                           </div>
                           <div class="mr:2px;">
                                <h5 class="mb-0 text-dark">
                                  {{ strtoupper(substr($groupedData['project']['title'], 0, 1)) }}
                                </h5>
                              <small class="text-muted">{{ \App\Helpers\Helper::cachedTrans('Team Discussion') }}</small>
                           </div>
                        </div>
                        {{-- <div class="ms-auto">
                           <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#projectInfoModal">
                           <i class="fas fa-info-circle"></i>
                           </button>
                        </div> --}}
                        {{-- ------------- --}}
                         <!-- Download Messages Filter -->
                           {{-- <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="width: 180px;">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-calendar text-muted"></i>
                                    </span>
                                    <input type="date" 
                                            class="form-control" 
                                            id="fromDate"
                                            name="from_date"
                                            value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                                </div>
                                
                                <span class="text-muted">to</span>
                                
                                <div class="input-group input-group-sm" style="width: 180px;">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-calendar text-muted"></i>
                                    </span>
                                    <input type="date" 
                                            class="form-control" 
                                            id="toDate"
                                            name="to_date"
                                            value="{{ date('Y-m-d') }}">
                                </div>
                                
                                
                                <!-- Download All Button -->
                                 <button type="button" class="btn btn-sm btn-primary" onclick="downloadChat()">
                                    <i class="fas fa-download"></i> Download All
                                 </button>
                           </div> --}}
                           <div class="d-flex align-items-center gap-2">
                              <!-- Date inputs remain the same -->
                              <div class="input-group input-group-sm" style="width: 180px;">
                                 <span class="input-group-text bg-white">
                                       <i class="fas fa-calendar text-muted"></i>
                                 </span>
                                 <input type="date" 
                                          class="form-control" 
                                          id="fromDate"
                                          name="from_date"
                                          value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                              </div>
                              
                              <span class="text-muted">to</span>
                              
                              <div class="input-group input-group-sm" style="width: 180px;">
                                 <span class="input-group-text bg-white">
                                       <i class="fas fa-calendar text-muted"></i>
                                 </span>
                                 <input type="date" 
                                          class="form-control" 
                                          id="toDate"
                                          name="to_date"
                                          value="{{ date('Y-m-d') }}">
                              </div>
                              
                              <!-- Download Options Dropdown -->
                              <div class="btn-group">
                                 <button type="button" class="btn btn-sm btn-primary" onclick="downloadChatZip()">
                                       <i class="fab fa-file-archive-o"></i> Download ZIP
                                 </button>
                              </div>
                           </div>    
                                
                        {{-- -------------- --}}
                     </div>
                     <div id="chatBox" class="chat-box custom-scroll">
                        @forelse($data['post_data'] as $post)
                        {{-- ✅ Show POSTS (parent_id = null) --}}
                        @if(is_null($post->parent_id))
                        <div class="chat-message {{ $post->employee_code == $employee_code ? 'mine' : '' }}" id="post-{{ $post->id }}">
                           @if($post->employee_code != $employee_code)
                           <div class="message-sender">{{ $post->user_name }}</div>
                           @endif
                           <div class="message-content">
                              {{-- 3-dot Menu --}}
                              <div class="message-menu">
                                 <button class="menu-toggle" onclick="toggleMenu({{ $post->id }})">
                                 <i class="fas fa-ellipsis-v"></i>
                                 </button>
                                 <div class="menu-dropdown" id="menu-{{ $post->id }}">
                                    @if($post->employee_code == $employee_code)
                                    <div class="menu-item edit" onclick="openEditModal({{ $post->id }}, '{{ $post->title }}')">
                                       <i class="fas fa-edit"></i> Edit
                                    </div>
                                    <div class="menu-item delete" onclick="deletePost({{ $post->id }})">
                                       <i class="fas fa-trash"></i> Delete
                                    </div>
                                    @endif
                                 </div>
                              </div>
                              {{-- Main Text --}}
                              @if($post->title)
                              <div class="message-text">{{ $post->title }}</div>
                              @endif
                              {{-- File --}}
                              @if($post->file)
                              @php
                              $filePath = 'storage/app/public/' . $post->file;
                              $extension = strtolower(pathinfo($post->file, PATHINFO_EXTENSION));
                              @endphp
                              <div class="attachment">
                                 <a href="{{ asset($filePath) }}" target="_blank" download>
                                    @if(in_array($extension, ['jpg','jpeg','png','gif','webp']))
                                    <img src="{{ asset($filePath) }}" alt="Attachment" class="file-preview-img">
                                    @elseif($extension === 'pdf')
                                    <div class="file-preview pdf">
                                       <i class="fas fa-file-pdf"></i>
                                       <span>PDF File</span>
                                    </div>
                                    @elseif(in_array($extension, ['xls','xlsx']))
                                    <div class="file-preview excel">
                                       <i class="fas fa-file-excel"></i>
                                       <span>Excel File</span>
                                    </div>
                                    @elseif(in_array($extension, ['doc','docx']))
                                    <div class="file-preview word">
                                       <i class="fas fa-file-word"></i>
                                       <span>Word File</span>
                                    </div>
                                    @else
                                    <div class="file-preview generic">
                                       <i class="fas fa-file"></i>
                                       <span>File</span>
                                    </div>
                                    @endif
                                 </a>
                              </div>
                              @endif
                              {{-- Time --}}
                              <div class="message-time">
                                 {{ \Carbon\Carbon::parse($post->created_at)->format('h:i A • M j, Y') }}
                              </div>
                           </div>
                           {{-- Reply button outside, vertically centered --}}
                           @if($post->employee_code != $employee_code)
                           <div class="reply-btn" onclick="setReply({{ $post->id }}, '{{ $post->title }}', '{{ $post->user_name }}')">
                              <i class="fas fa-reply"></i> Reply
                           </div>
                           @endif
                        </div>
                        {{-- ✅ Show Replies (if nested in "replies") --}}
                        @if(!empty($post->replies))
                        <div class="replies-container">
                           @foreach($post->replies as $reply)
                           <div class="chat-message reply {{ $reply['employee_code'] == $employee_code ? 'mine' : '' }}" id="reply-{{ $reply['id'] }}">
                              @if($reply['employee_code'] != $employee_code)
                              <div class="message-sender">{{ $reply['user_name'] }}</div>
                              @endif
                              <div class="message-content">
                                 {{-- Menu --}}
                                 <div class="message-menu">
                                    <button class="menu-toggle" onclick="toggleMenu({{ $reply['id'] }})">
                                    <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="menu-dropdown" id="menu-{{ $reply['id'] }}">
                                       <div class="menu-item reply" onclick="setReply({{ $reply['id'] }}, '{{ $reply['title'] }}', '{{ $reply['user_name'] }}')">
                                          <i class="fas fa-reply"></i> Reply
                                       </div>
                                       @if($reply['employee_code'] == $employee_code)
                                       <div class="menu-item edit" onclick="openEditModal({{ $reply['id'] }}, '{{ $reply['title'] }}')">
                                          <i class="fas fa-edit"></i> Edit
                                       </div>
                                       <div class="menu-item delete" onclick="deletePost({{ $reply['id'] }})">
                                          <i class="fas fa-trash"></i> Delete
                                       </div>
                                       @endif
                                    </div>
                                 </div>
                                 {{-- Quoted parent --}}
                                 <div class="quoted-message">
                                    <span class="quoted-user">{{ $post->user_name }}</span>
                                    <span class="quoted-text">{{ \Illuminate\Support\Str::limit($post->title, 50) }}</span>
                                 </div>
                                 <div class="message-text">{{ $reply['title'] }}</div>
                                 <div class="message-time">{{ \Carbon\Carbon::parse($reply['created_at'])->format('h:i A • M j, Y') }}</div>
                              </div>
                           </div>
                           @endforeach
                        </div>
                        @endif
                        @else
                        {{-- ✅ Direct REPLY (when parent_id is not null but no nested replies array) --}}
                        @php
                        $parent = $data['post_data']->firstWhere('id', $post->parent_id);
                        @endphp
                        <div class="chat-message reply {{ $post->employee_code == $employee_code ? 'mine' : '' }}" id="reply-{{ $post->id }}">
                           @if($post->employee_code != $employee_code)
                           <div class="message-sender">{{ $post->user_name }}</div>
                           @endif
                           <div class="message-content">
                              <div class="message-menu">
                                 <button class="menu-toggle" onclick="toggleMenu({{ $post->id }})">
                                 <i class="fas fa-ellipsis-v"></i>
                                 </button>
                                 <div class="menu-dropdown" id="menu-{{ $post->id }}">
                                    {{-- 
                                    <div class="menu-item reply" onclick="setReply({{ $post->id }}, '{{ $post->title }}', '{{ $post->user_name }}')">
                                       <i class="fas fa-reply"></i> Reply
                                    </div>
                                    --}}
                                    @if($post->employee_code == $employee_code)
                                    <div class="menu-item edit" onclick="openEditModal({{ $post->id }}, '{{ $post->title }}')">
                                       <i class="fas fa-edit"></i> Edit
                                    </div>
                                    <div class="menu-item delete" onclick="deletePost({{ $post->id }})">
                                       <i class="fas fa-trash"></i> Delete
                                    </div>
                                    @endif
                                 </div>
                              </div>
                              {{-- Quoted parent --}}
                              @if(!empty($parent))
                              <div class="quoted-message">
                                 <span class="quoted-user">{{ $parent->user_name }}</span>
                                 <span class="quoted-text">{{ \Illuminate\Support\Str::limit($parent->title, 50) }}</span>
                              </div>
                              @endif
                              <div class="message-text">{{ $post->title }}</div>
                              @if($post->file)
                              @php
                              $filePath = 'storage/app/public/' . $post->file;
                              $extension = strtolower(pathinfo($post->file, PATHINFO_EXTENSION));
                              @endphp
                              <div class="attachment">
                                 <a href="{{ asset($filePath) }}" target="_blank" download>
                                    @if(in_array($extension, ['jpg','jpeg','png','gif','webp']))
                                    <img src="{{ asset($filePath) }}" alt="Attachment" class="file-preview-img">
                                    @elseif($extension === 'pdf')
                                    <div class="file-preview pdf">
                                       <i class="fas fa-file-pdf"></i>
                                       <span>PDF File</span>
                                    </div>
                                    @elseif(in_array($extension, ['xls','xlsx']))
                                    <div class="file-preview excel">
                                       <i class="fas fa-file-excel"></i>
                                       <span>Excel File</span>
                                    </div>
                                    @elseif(in_array($extension, ['doc','docx']))
                                    <div class="file-preview word">
                                       <i class="fas fa-file-word"></i>
                                       <span>Word File</span>
                                    </div>
                                    @else
                                    <div class="file-preview generic">
                                       <i class="fas fa-file"></i>
                                       <span>File</span>
                                    </div>
                                    @endif
                                 </a>
                              </div>
                              @endif
                              <div class="message-time">{{ \Carbon\Carbon::parse($post->created_at)->format('h:i A • M j, Y') }}</div>
                           </div>
                        </div>
                        @endif
                        @empty
                        <div class="no-messages">
                           <i class="fas fa-comments"></i>
                           <p>No messages yet. Start the conversation!</p>
                        </div>
                        @endforelse
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
                           <input type="text" name="title" placeholder="{{\App\Helpers\Helper::cachedTrans('Write your message here...')}}" required>
                           <button type="submit">
                           <i class="fas fa-paper-plane"></i>
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            {{-- 
         </div>
         --}}
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
         <!------------   Reply Model  ----------------->
         <!-- Reply Modal -->
         <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content rounded-lg">
                  <div class="modal-header">
                     <h5 class="modal-title">Reply to <span id="reply-user-name"></span></h5>
                     {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <span>&times;</span>
                     </button> --}}
                  </div>
                  <div class="modal-body">
                     <form action="{{ route('project.post') }}" method="post" enctype="multipart/form-data" id="reply-form">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $data['id'] }}">
                        <input type="hidden" name="parent_id" id="reply-parent-id-modal">
                        <div class="form-group mb-3">
                           <label for="reply-title">Message</label>
                           <input type="text" class="form-control" name="title" id="reply-title" placeholder="Write your reply..." required>
                        </div>
                        <div class="form-group mb-3">
                           <label for="reply-file">Attachment</label>
                           <input type="file" class="form-control" name="file" id="reply-file" accept="image/*,.pdf,.xlsx,.xls,.doc,.docx">
                        </div>
                        <div class="d-flex justify-content-end">
                           <button type="submit" class="btn btn-primary">
                           <i class="fas fa-paper-plane"></i> Send
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{-- @include('taskmanagement.partials.footer') --}}
</div>
@endsection
@section('script')
{{-- @include('taskmanagement.partials.scripts') --}}
{{-- new js for group search --}}
<script>
    function filterGroups() {
        const searchTerm = document.getElementById('groupSearch').value.toLowerCase();
        const groups = document.querySelectorAll('#groupListContainer .chat-list-item');
        let visibleCount = 0;
        
        groups.forEach(group => {
            const groupName = group.getAttribute('data-group-name') || '';
            const employee = group.getAttribute('data-employee') || '';
            const messageText = group.querySelector('.message-text')?.textContent.toLowerCase() || '';
            
            if (searchTerm === '' || 
                groupName.includes(searchTerm) || 
                employee.includes(searchTerm) || 
                messageText.includes(searchTerm)) {
                group.style.display = 'flex';
                visibleCount++;
            } else {
                group.style.display = 'none';
            }
        });
        
        // Show no results message
        const container = document.getElementById('groupListContainer');
        let noResults = container.querySelector('.no-results-message');
        
        if (visibleCount === 0) {
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.className = 'text-center p-5 text-muted no-results-message';
                noResults.innerHTML = `
                    <i class="fas fa-search fa-3x mb-3"></i>
                    <p class="mb-0">No groups found matching "${searchTerm}"</p>
                `;
                container.appendChild(noResults);
            }
        } else if (noResults) {
            noResults.remove();
        }
    }

    function clearGroupSearch() {
        document.getElementById('groupSearch').value = '';
        filterGroups();
    }
</script>
{{-- ---------------------------old js code bellow --}}
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
   
   function deletePost(postId) {
       if (!confirm("Are you sure you want to delete this post?")) {
           return;
       }
   
       fetch(`/project-posts/${postId}`, {
           method: 'DELETE',
           headers: {
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
               'Accept': 'application/json'
           }
       })
       .then(response => response.json())
       .then(data => {
           if (data.success) {
               // Reload the page
               window.location.reload();
           } else {
               alert('Error deleting post: ' + (data.message || 'Unknown error'));
           }
       })
       .catch(error => {
           console.error('Delete error:', error);
           alert('Error deleting post (network issue)');
       });
   }
   
   
</script>
{{-- -------- --}}
<script>
   function toggleMenu(id) {
       document.querySelectorAll('.menu-dropdown').forEach(menu => {
           if (menu.id !== 'menu-' + id) menu.style.display = 'none';
       });
       let menu = document.getElementById('menu-' + id);
       menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
   }
   
   document.addEventListener("click", function(e) {
       if (!e.target.closest(".message-menu")) {
           document.querySelectorAll(".menu-dropdown").forEach(menu => menu.style.display = "none");
       }
   });
   
</script>
<script>
   function setReply(postId, postTitle, userName) {
       // Fill modal hidden fields
       document.getElementById('reply-parent-id-modal').value = postId;
       document.getElementById('reply-user-name').innerText = userName;
   
       // Open modal (Bootstrap 5)
       var replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
       replyModal.show();
   }
   
</script>
{{-- ----------------------------------------------------------- --}}
{{-- <script>
   // Alternative method using Fetch API (for better UX)
   async function downloadAllMessagesFetch() {
      const fromDate = document.getElementById('fromDate').value;
      const toDate = document.getElementById('toDate').value;
      const projectId = '{{ encrypt($data["id"]) }}';
      
      if (!fromDate || !toDate) {
         showToast('Please select both from and to dates', 'error');
         return;
      }
      
      // Show loading modal or progress bar
      showDownloadProgress();
      
      try {
         const response = await fetch('{{ route("project.chat.download") }}', {
               method: 'POST',
               headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
                  'X-Requested-With': 'XMLHttpRequest'
               },
               body: JSON.stringify({
                  project_id: projectId,
                  from_date: fromDate,
                  to_date: toDate,
                  format: 'csv'
               })
         });
         
         if (!response.ok) {
               throw new Error('Download failed');
         }
         
         // Get the blob data
         const blob = await response.blob();
         
         // Create download link
         const url = window.URL.createObjectURL(blob);
         const a = document.createElement('a');
         a.href = url;
         a.download = `chat-${fromDate}-to-${toDate}.csv`;
         document.body.appendChild(a);
         a.click();
         
         // Cleanup
         window.URL.revokeObjectURL(url);
         document.body.removeChild(a);
         
         showToast('Download completed successfully!', 'success');
         
      } catch (error) {
         console.error('Download error:', error);
         showToast('Download failed. Please try again.', 'error');
      } finally {
         hideDownloadProgress();
      }
   }

   function showDownloadProgress() {
      // Create progress overlay
      const overlay = document.createElement('div');
      overlay.id = 'download-progress';
      overlay.style.cssText = `
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(0,0,0,0.5);
         display: flex;
         justify-content: center;
         align-items: center;
         z-index: 9999;
      `;
      
      overlay.innerHTML = `
         <div style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
               <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
               </div>
               <p class="mt-2">Preparing your download...</p>
               <div class="progress mt-2" style="width: 200px;">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" 
                        role="progressbar" 
                        style="width: 100%"></div>
               </div>
         </div>
      `;
      
      document.body.appendChild(overlay);
   }

   function hideDownloadProgress() {
      const overlay = document.getElementById('download-progress');
      if (overlay) {
         overlay.remove();
      }
   }
</script> --}}

<script>


function downloadChatZip() {
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;
    const projectId = '{{ encrypt($data["id"]) }}';
    
    if (!fromDate || !toDate) {
        alert('Please select both from and to dates');
        return false;
    }
    
    if (new Date(toDate) < new Date(fromDate)) {
        alert('To date must be after or equal to from date');
        return false;
    }
    
    // Show loading with better UX
    const button = event.target;
    const originalHTML = button.innerHTML;
    
    // Create loading overlay
    const overlay = document.createElement('div');
    overlay.id = 'download-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;
    
    overlay.innerHTML = `
        <div style="background: white; padding: 30px; border-radius: 10px; text-align: center; min-width: 300px;">
            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h5 class="mb-2">Preparing Chat Export</h5>
            <p class="text-muted mb-3">This may take a moment...</p>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                     role="progressbar" 
                     style="width: 100%"></div>
            </div>
            <small class="text-muted mt-2 d-block">Creating ZIP file with HTML, JSON, Text, Image and media files</small>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';
    
    // Update button
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating ZIP...';
    button.disabled = true;
    
    // Create form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("project.chat.download.zip") }}';
    form.style.display = 'none';
    
    // Add inputs
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const inputs = [
        { name: 'project_id', value: projectId },
        { name: 'from_date', value: fromDate },
        { name: 'to_date', value: toDate }
    ];
    
    inputs.forEach(input => {
        const el = document.createElement('input');
        el.type = 'hidden';
        el.name = input.name;
        el.value = input.value;
        form.appendChild(el);
    });
    
    document.body.appendChild(form);
    form.submit();
    
    // Clean up after 5 seconds
    setTimeout(() => {
        button.innerHTML = originalHTML;
        button.disabled = false;
        
        const overlay = document.getElementById('download-overlay');
        if (overlay) {
            overlay.remove();
            document.body.style.overflow = '';
        }
    }, 5000);
    
    return false;
}
</script>

 <!--Show Firebase realtime Message-->
    <script>
    
        const projectId = "{{ $data['id'] }}";
        
        const employeeCode = "{{ $employee_code }}";
    
    </script>
    <script type="module">

        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-app.js";
        
        import {
            getDatabase,
            ref,
            onChildAdded
        } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-database.js";
        
        const firebaseConfig = {
              apiKey: "AIzaSyB46Sz62UYBgx7xv8dhyYxeQ-Yyd0r6c_s",
              authDomain: "sponic-hr.firebaseapp.com",
              databaseURL: "https://sponic-hr-default-rtdb.firebaseio.com",
              projectId: "sponic-hr",
              storageBucket: "sponic-hr.firebasestorage.app",
              messagingSenderId: "381369065854",
              appId: "1:381369065854:web:485a01dfa1bd884db2132f"
        
        };
        
        const app = initializeApp(firebaseConfig);
        
        const db = getDatabase(app);
        
        const chatRef = ref(
            db,
            "project_chat/" + projectId
        );
        
        onChildAdded(chatRef, (snapshot)=>{
        
            const message = snapshot.val();
        
            appendMessage(message);
        
        });
        
        //function
        function appendMessage(message){
        
            let mine = message.employee_code == employeeCode;
        
            let html = `
        
                <div class="chat-message ${mine ? 'mine' : ''}">
        
                    ${
                        !mine
                        ? `<div class="message-sender">
                                ${message.employee_name}
                           </div>`
                        : ''
                    }
        
                    <div class="message-content">
        
                        ${
                            message.replies
                            ? `
                                <div class="quoted-message">
        
                                    <span class="quoted-user">
        
                                        ${message.replies.employee_name}
        
                                    </span>
        
                                    <span class="quoted-text">
        
                                        ${message.replies.message}
        
                                    </span>
        
                                </div>
                            `
                            : ''
                        }
        
                        <div class="message-text">
        
                            ${message.message}
        
                        </div>
        
                        <div class="message-time">
        
                            ${message.created_at}
        
                        </div>
        
                    </div>
        
                </div>
        
            `;
        
            document
                .getElementById("chatBox")
                .insertAdjacentHTML(
                    "beforeend",
                    html
                );
        
            document
                .getElementById("chatBox")
                .scrollTop =
                document.getElementById("chatBox").scrollHeight;
        }
        
        </script>
@endsection