@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-morphism overflow-hidden d-flex flex-column" style="height: 70vh;">
                <!-- Chat Header -->
                <div class="chat-header p-3 border-bottom border-light border-opacity-10 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('messages.index') }}" class="text-muted me-2"><i class="fas fa-arrow-left"></i></a>
                        <div class="rounded-circle bg-success-gradient d-flex align-items-center justify-content-center text-white small" style="width: 40px; height: 40px;">
                            {{ strtoupper(substr($targetUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="text-white mb-0">{{ $targetUser->name }}</h6>
                            <small class="text-muted">@ {{ $targetUser->username }}</small>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="chat-body p-4 flex-grow-1 overflow-auto d-flex flex-column gap-3" id="chatBody">
                    @forelse($messages as $msg)
                        <div class="message-wrapper d-flex {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}" id="msg-{{ $msg->id }}">
                            <div class="message-bubble p-3 rounded-4 {{ $msg->sender_id == Auth::id() ? 'bg-success bg-opacity-75 text-white' : 'glass-morphism text-white' }}" style="max-width: 75%;">
                                @if($msg->attachment_path)
                                    <div class="attachment-box mb-2 p-2 rounded-3 bg-white-5">
                                        @if(in_array(strtolower($msg->attachment_type), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <img src="{{ asset('storage/' . $msg->attachment_path) }}" class="img-fluid rounded-2 mb-1" style="max-height: 200px; cursor: pointer;" onclick="window.open(this.src)">
                                        @else
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-file-alt fa-2x opacity-50"></i>
                                                <div class="small text-truncate">
                                                    {{ basename($msg->attachment_path) }}
                                                    <br>
                                                    <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="text-info text-decoration-none">Yuklab olish</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="message-text mb-1">{{ $msg->message }}</div>
                                <div class="text-end small opacity-50" style="font-size: 0.7rem;">
                                    {{ $msg->created_at->format('H:i') }}
                                    @if($msg->sender_id == Auth::id())
                                        <i class="fas {{ $msg->is_read ? 'fa-check-double text-info' : 'fa-check' }} ms-1"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center my-auto opacity-50" id="emptyState">
                            <p>Suhbatni boshlang...</p>
                        </div>
                    @endforelse
                </div>

                <!-- Chat Footer -->
                <div class="chat-footer p-3 border-top border-light border-opacity-10">
                    <form action="{{ route('messages.send') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $targetUser->id }}">
                        
                        <!-- Attachment button -->
                        <div class="attachment-btn">
                            <label for="attachmentInput" class="btn btn-outline-light rounded-circle border-0 opacity-50 hover-opacity-100" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-paperclip"></i>
                            </label>
                            <input type="file" name="attachment" id="attachmentInput" class="d-none" onchange="handleFileSelect(this)">
                        </div>

                        <input type="text" name="message" id="messageInput" class="form-control glass-input rounded-pill px-4" placeholder="Xabaringizni yozing..." autocomplete="off">
                        
                        <button type="submit" class="btn btn-success rounded-circle" style="width: 45px; height: 45px;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <div id="filePreview" class="small text-muted mt-2 px-3 d-none">
                        <i class="fas fa-file me-2"></i> <span id="fileName"></span> 
                        <span class="ms-2 text-danger cursor-pointer" onclick="clearFile()"><i class="fas fa-times"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const chatBody = document.getElementById('chatBody');
    const targetUserId = {{ $targetUser->id }};
    const myId = {{ Auth::id() }};
    const emptyState = document.getElementById('emptyState');

    // Scroll to bottom helper
    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
        
        // Start polling for new messages every 3 seconds
        setInterval(fetchNewMessages, 3000);
    });

    function fetchNewMessages() {
        fetch(`/messages/fetch/${targetUserId}`)
            .then(response => response.json())
            .then(messages => {
                if (messages.length > 0) {
                    if (emptyState) emptyState.remove();
                    
                    messages.forEach(msg => {
                        appendMessage(msg);
                    });
                    scrollToBottom();
                }
            });
    }

    function appendMessage(msg) {
        // Prevent duplicates if already in DOM
        if (document.getElementById(`msg-${msg.id}`)) return;

        const wrapper = document.createElement('div');
        wrapper.id = `msg-${msg.id}`;
        wrapper.className = `message-wrapper d-flex justify-content-start`;
        
        let attachmentHtml = '';
        if (msg.attachment_path) {
            const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(msg.attachment_type ? msg.attachment_type.toLowerCase() : '');
            if (isImage) {
                attachmentHtml = `<div class="attachment-box mb-2 p-2 rounded-3 bg-white-5">
                    <img src="/storage/${msg.attachment_path}" class="img-fluid rounded-2 mb-1" style="max-height: 200px; cursor: pointer;" onclick="window.open(this.src)">
                </div>`;
            } else {
                attachmentHtml = `<div class="attachment-box mb-2 p-2 rounded-3 bg-white-5">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-file-alt fa-2x opacity-50"></i>
                        <div class="small text-truncate">
                            ${msg.attachment_path.split('/').pop()}
                            <br>
                            <a href="/storage/${msg.attachment_path}" target="_blank" class="text-info text-decoration-none">Yuklab olish</a>
                        </div>
                    </div>
                </div>`;
            }
        }

        const date = new Date(msg.created_at);
        const timeStr = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

        wrapper.innerHTML = `
            <div class="message-bubble p-3 rounded-4 glass-morphism text-white" style="max-width: 75%;">
                ${attachmentHtml}
                <div class="message-text mb-1">${msg.message || ''}</div>
                <div class="text-end small opacity-50" style="font-size: 0.7rem;">
                    ${timeStr}
                </div>
            </div>
        `;
        chatBody.appendChild(wrapper);
    }

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            document.getElementById('fileName').textContent = input.files[0].name;
            document.getElementById('filePreview').classList.remove('d-none');
        }
    }

    function clearFile() {
        document.getElementById('attachmentInput').value = '';
        document.getElementById('filePreview').classList.add('d-none');
    }
</script>

<style>
.bg-white-5 {
    background: rgba(255, 255, 255, 0.05);
}
.cursor-pointer {
    cursor: pointer;
}
.hover-opacity-100:hover {
    opacity: 1 !important;
}
.chat-body::-webkit-scrollbar {
    width: 6px;
}
.chat-body::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
.bg-success-gradient {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
}
.glass-input {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
}
.glass-input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #2ecc71;
    color: white;
    box-shadow: none;
}
</style>
@endpush
