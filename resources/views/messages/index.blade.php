<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>{{ $allsettings->site_title }} - Conversations</title>
    @include('meta')
    @include('style')

    <!-- ✅ Required Echo & Pusher JS -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>
</head>
<body>
@include('header')

<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i> Home</a></li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Conversations</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">Conversations</h1>
        </div>
    </div>
</div>

<div class="container pb-5 mb-2 mb-md-3">
    <div class="row">
        <aside class="col-lg-4 pt-5 mt-3">
            @include('dashboard-menu')
        </aside>
        <section class="col-lg-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Conversations</div>
                        <div class="card-body conversation-list">
                            <div class="list-group">
                                @foreach($conversations as $conversation)
                                    <a href="{{ route('messages.index', ['user_id' => $conversation->user_id]) }}"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('user_id') == $conversation->user_id ? 'active' : '' }} {{ $conversation->unread_count ? 'font-weight-bold' : '' }}">
                                        <span>{{ $conversation->name }}</span>
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
        </section>
    </div>
</div>

<style>
    .conversation-list .list-group-item:hover { background-color: #f8f9fa; }
    .conversation-list .list-group-item.active { background-color: #007bff; color: #fff; }
    .conversation-list .list-group-item.font-weight-bold { font-weight: bold; }
    .message-container { display: flex; margin-bottom: 1rem; }
    .message-container.sent { justify-content: flex-end; }
    .message-container.received { justify-content: flex-start; }
    .message-bubble {
        max-width: 70%;
        padding: 0.75rem 1rem;
        border-radius: 1rem;
    }
    .message-container.sent .message-bubble {
        background-color: #007bff;
        color: white;
        border-bottom-right-radius: 0;
    }
    .message-container.received .message-bubble {
        background-color: #f1f1f1;
        color: #333;
        border-bottom-left-radius: 0;
    }
    .message-time {
        font-size: 0.75rem;
        margin-top: 0.25rem;
        text-align: right;
    }
    .messages-container {
        padding: 1rem;
        max-height: 400px;
        overflow-y: auto;
    }
</style>

@include('footer')
@include('script')

<!-- ✅ Real-time Echo Script -->
<script>
    const currentUserId = {{ auth()->id() }};
    const currentConversationUserId = {{ request('user_id') ?? 'null' }};

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config('broadcasting.connections.pusher.key') }}',
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true,
        authEndpoint: '/broadcasting/auth'
    });

    window.Echo.private(`chat.${currentUserId}`)
        .listen('.message.sent', (data) => {
            const messagesContainer = document.querySelector('.messages-container');

            const isInCurrentConversation = parseInt(data.message.sender_id) === currentConversationUserId ||
                                            parseInt(data.message.receiver_id) === currentConversationUserId;

            if (isInCurrentConversation) {
                const isSender = data.message.sender_id === currentUserId;
                const msg = document.createElement('div');
                msg.className = `message-container ${isSender ? 'sent' : 'received'}`;
                msg.innerHTML = `
                    <div class="message-bubble">
                        <div class="message-content">${data.message.content}</div>
                        <div class="message-time">Just now</div>
                    </div>`;
                messagesContainer.appendChild(msg);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
</script>

<!-- ✅ Message Send Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('message-form');
        const messagesContainer = document.querySelector('.messages-container');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const content = form.querySelector('input[name="content"]').value.trim();
            const receiverId = form.querySelector('input[name="receiver_id"]').value;
            const token = document.querySelector('input[name="_token"]').value;

            if (!content) return;

            const formData = new FormData();
            formData.append('content', content);
            formData.append('receiver_id', receiverId);

            fetch(`{{ route('messages.store') }}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    form.querySelector('input[name="content"]').value = '';

                    const msg = document.createElement('div');
                    msg.className = 'message-container sent';
                    msg.innerHTML = `
                        <div class="message-bubble">
                            <div class="message-content">${content}</div>
                            <div class="message-time">Just now</div>
                        </div>`;
                    messagesContainer.appendChild(msg);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            });
        });
    });
</script>

</body>
</html>
