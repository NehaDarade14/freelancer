@extends('layouts.main')

@section('content')
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Conversations</div>
                        <div class="card-body conversation-list">
                            <div class="list-group">
                                @foreach($conversations as $conversation)
                                    <a href="{{ route('messages.index', ['user_id' => $conversation->user_id]) }}"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('user_id') == $conversation->user_id ? 'active' : '' }} {{ $conversation->unread_count ? 'font-weight-bold' : '' }}">
                                        <div class="d-flex align-items-center">
                                            
                                             @if($conversation->user_photo != '')
                                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/storage/users/{{ $conversation->user_photo }}"  alt="{{ $conversation->name }}">
                                            @else
                                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/img/no-image.png"  alt="{{ $conversation->name }}">
                                            @endif
                                            <span>{{ $conversation->name }}</span>
                                        </div>
                                        @if($conversation->unread_count)
                                            <span class="badge badge-primary badge-pill">{{ $conversation->unread_count }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Box -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            @if(request('user_id') && isset($user))
                                <span>Messages with {{ $user->name }}</span>
                            @else
                                <span>Select a conversation</span>
                            @endif
                        </div>
                        <div class="card-body messages-container">
                            @foreach($messages as $message)
                                <div class="message-container {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                                    <div class="message-bubble">
                                        <div class="message-content">{{ $message->content }}</div>
                                        <div class="message-time">{{ $message->created_at->format('h:i A') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <form id="message-form">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ request('user_id') }}">
                                <div class="input-group">
                                    <input type="text" name="content" class="form-control" placeholder="Type your message..." required>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
<style>
    .conversation-list .list-group-item:hover { background-color: #f8f9fa; }
    .conversation-list .list-group-item.active {
        background: linear-gradient(135deg, #007bff, #0062cc);
        color: #fff;
        border-color: #005cbf;
    }
    .message-container {
        display: flex;
        margin-bottom: 1rem;
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .message-bubble {
        max-width: 75%;
        padding: 1.2rem 1.5rem;
        border-radius: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: relative;
        word-break: break-word;
        transition: transform 0.2s ease;
        margin: 0.5rem 0;
        line-height: 1.4;
    }
    .message-container.sent .message-bubble {
        margin-left: auto;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-bottom-right-radius: 4px;
        border: 1px solid #0056b3;
    }
    .message-container.received .message-bubble {
        margin-right: auto;
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        color: #333;
        border-bottom-left-radius: 4px;
        border: 1px solid #dee2e6;
    }
    .message-container:hover .message-bubble {
        transform: translateY(-2px);
    }
    .message-content {
        font-size: 1.05rem;
        line-height: 1.5;
    }
    .message-time {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.8);
        margin-top: 0.8rem;
    }
    .message-container.received .message-time {
        color: rgba(0,0,0,0.6);
    }
    .message-container.sent .message-bubble {
        background: linear-gradient(135deg, #007bff, #0062cc);
        color: white;
        border-bottom-right-radius: 4px;
    }
    .message-container.received .message-bubble {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #333;
        border-bottom-left-radius: 4px;
    }
    .message-time {
        font-size: 0.75rem;
        margin-top: 0.5rem;
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .messages-container {
        padding: 1.5rem;
        max-height: 70vh;
        min-height: 400px;
        overflow-y: auto;
        scroll-behavior: smooth;
        background: #f8f9fa;
        border-radius: 0.5rem;
    }
    
    .kra-profile-icon {
        width: 24px;
        height: 24px;
        object-fit: contain;
        margin-right: 0.5rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        transition: transform 0.2s ease;
    }
    .kra-profile-icon:hover {
        transform: scale(1.1);
    }

    /* Fix Pusher connection indicator */
    .pusher-connection-state {
        position: fixed;
        bottom: 10px;
        right: 10px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #dc3545;
    }
    .pusher-connection-state.connected {
        background: #28a745;
    }
    .typing-indicator {
        display: inline-flex;
        gap: 4px;
        padding: 8px 12px;
        background: #e9ecef;
        border-radius: 20px;
        margin-left: 1rem;
    }
    .typing-dot {
        width: 6px;
        height: 6px;
        background: #6c757d;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }
    @keyframes typing {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .message-status {
        font-size: 0.65rem;
        margin-left: 4px;
    }
    .kra-disclaimer {
        font-size: 0.8rem;
        padding: 1rem;
        background: #fff3cd;
        border-radius: 0.5rem;
        margin-top: 1rem;
        border: 1px solid #ffeeba;
    }
    @media (max-width: 768px) {
        .message-bubble { max-width: 85%; }
        .messages-container { max-height: 50vh; }
    }
</style>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>
@include('script')

<!-- ✅ Enhanced Real-time Script -->
<script>
    const currentUserId = {{ auth()->id() }};
    const currentConversationUserId = {{ request('user_id') ?? 'null' }};
    let isTyping = false;
    let lastTypingTime = 0;

    // Pusher Echo Configuration
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config('broadcasting.connections.pusher.key') }}',
        cluster: 'mt1',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        },
        forceTLS: false,
        wsHost: window.location.hostname,
        wsPort: 6001,
        enabledTransports: ['ws'],
        disableStats: true,
        activityTimeout: 30000,
        pongTimeout: 10000,
        authTransport: 'jsonp',
        logToConsole: {{ config('app.debug') ? 'true' : 'false' }}
    });

    // Real-time Listeners
    window.Echo.private(`chat.${currentUserId}`)
        .listen('.message.sent', (data) => handleNewMessage(data))
        .listenForWhisper('typing', (data) => handleTypingEvent(data))
        .listen('.connected', () => updateConnectionStatus(true))
        .listen('.disconnected', () => updateConnectionStatus(false));
    
        // Add connection status indicator with error prevention
        let connectionState = document.querySelector('.pusher-connection-state');
        if (!connectionState) {
            connectionState = document.createElement('div');
            connectionState.className = 'pusher-connection-state';
            document.body.appendChild(connectionState);
        }
    
        function updateConnectionStatus(connected) {
            connectionState.classList.toggle('connected', connected);
        }

    // Message Handling
    function handleNewMessage(data) {
        const messagesContainer = document.querySelector('.messages-container');
        const isRelevant = data.message.sender_id == currentConversationUserId ||
                         data.message.receiver_id == currentConversationUserId;

        if (isRelevant) {
            const msg = createMessageElement(data.message, data.message.sender_id === currentUserId);
            messagesContainer.appendChild(msg);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            updateConversationList(data.message);
        }
    }

    // Typing Indicators
    function handleTypingEvent(data) {
        const typingIndicator = document.getElementById('typing-indicator');
        if (data.user_id === currentConversationUserId) {
            typingIndicator.style.display = data.typing ? 'flex' : 'none';
        }
    }

    // Message Element Creation
    function createMessageElement(message, isSender) {
        const msg = document.createElement('div');
        msg.className = `message-container ${isSender ? 'sent' : 'received'}`;
        
        // Use temporary timestamp if not available
        const timestamp = message.created_at ?
            new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) :
            new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

        msg.innerHTML = `
            <div class="message-bubble ${isSender ? 'sending' : ''}">
                <div class="message-content">${message.content}</div>
                <div class="message-time">
                    ${timestamp}
                    ${isSender ? '<span class="message-status">⌛</span>' : ''}
                </div>
            </div>`;
        return msg;
    }

    // Conversation List Update
    function updateConversationList(message) {
        const convItem = document.querySelector(`.conversation-list a[href*="user_id=${message.sender_id}"]`);
        if (convItem) {
            const badge = convItem.querySelector('.badge') || document.createElement('span');
            badge.className = 'badge badge-primary badge-pill';
            badge.textContent = parseInt(badge.textContent || 0) + 1;
            if (!convItem.contains(badge)) convItem.appendChild(badge);
        }
    }
</script>

<!-- ✅ Enhanced Message Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('message-form');
        const input = form.querySelector('input[name="content"]');
        const messagesContainer = document.querySelector('.messages-container');
        const typingIndicator = document.createElement('div');
        typingIndicator.id = 'typing-indicator';
        typingIndicator.className = 'typing-indicator';
        typingIndicator.innerHTML = `
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        `;
        messagesContainer.parentNode.insertBefore(typingIndicator, messagesContainer.nextSibling);

        // Input Event Handling
        input.addEventListener('input', debounce(() => {
            if (input.value.trim()) {
                window.Echo.private(`chat.${currentUserId}`)
                    .whisper('typing', {
                        user_id: currentUserId,
                        typing: true
                    });
                lastTypingTime = Date.now();
            }
        }, 500));

        // Form Submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const content = input.value.trim();
            const receiverId = form.querySelector('input[name="receiver_id"]').value;
            if (!content || !receiverId) return;

            let sendButton, tempElement, originalButtonText; // Declare all needed variables
            try {
                sendButton = form.querySelector('button[type="submit"]');
                const originalButtonText = sendButton.innerHTML;
                tempElement = null; // Initialize tempElement
                
                // Show loading state
                sendButton.disabled = true;
                sendButton.innerHTML = `<div class="spinner-border spinner-border-sm" role="status"></div>`;

                // Create temporary message immediately
                const tempMessage = {
                    content,
                    created_at: new Date().toISOString(),
                    sender_id: currentUserId
                };
                
                tempElement = createMessageElement(tempMessage, true);
                messagesContainer.appendChild(tempElement);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                const response = await fetch(`{{ route('messages.store') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ content, receiver_id: receiverId }),
                    signal: AbortSignal.timeout(5000)
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Server error: ${response.status} - ${errorText}`);
                }

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Invalid response format');
                }
                
                input.value = '';
                
                // Update temporary message with server response
                const data = await response.json();
                if(tempElement?.querySelector('.message-status')) {
                    tempElement.querySelector('.message-status').innerHTML = '✓✓';
                }
            } catch (error) {
                showErrorAlert('Message failed to send. Please try again.');
                // Remove temporary message on error
                if(tempElement) tempElement.remove();
            } finally {
                sendButton.disabled = false;
                sendButton.innerHTML = originalButtonText;
            }
        });

        // Enter Key Handling
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                form.dispatchEvent(new Event('submit'));
            }
        });

        // Utility Functions
        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(this, args), timeout);
            };
        }

        function showErrorAlert(message) {
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger mt-3';
            alert.textContent = message;
            form.parentNode.insertBefore(alert, form.nextSibling);
            setTimeout(() => alert.remove(), 3000);
        }
    });
</script>

 @endsection
