<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1)  Messages for Application: {{ $application->job->title }} @else {{ __('404 Not Found') }} @endif</title>
@include('meta')
@include('style')
</head>
    <body>
    @include('header')

        <div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page"> Messages for Application: {{ $application->job->title }}</li>
                    </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h1 class="h3 mb-0 text-white"> Messages for Application: {{ $application->job->title }}</h1>
                </div>
            </div>
        </div>
        <div class="container pb-5 mb-2 mb-md-3">
            <div class="row">
                <!-- Sidebar-->
                <aside class="col-lg-4 pt-5 mt-3">
                    <div class="d-block d-lg-none p-4">
                    <a class="btn btn-outline-accent d-block" href="#account-menu" data-toggle="collapse"><i class="dwg-menu mr-2"></i>{{ __('Account menu') }}</a></div>
                    @include('dashboard-menu')
                </aside>    
                <!-- Content  -->
                <section class="col-lg-8">
                    <!-- <div class="container"> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Messages for Application: {{ $application->job->title }}
                                    </div>

                                    <div class="card-body">
                                        <div class="messages-container" style="max-height: 400px; overflow-y: auto; margin-bottom: 20px;">
                                            @foreach($messages as $message)
                                            <div class="message @if($message->user_id == Auth::id()) sent @else received @endif @if(!$message->is_read && $message->user_id != Auth::id()) unread @endif">
                                                <div class="message-header">
                                                    <strong>{{ $message->user->name }}</strong>
                                                    <div>
                                                        @if(!$message->is_read && $message->user_id != Auth::id())
                                                        <span class="badge badge-danger">New</span>
                                                        @endif
                                                        <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                <div class="message-content">
                                                    {{ $message->content }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <form method="POST" action="{{ route('message.create') }}">
                                            @csrf
                                            <input type="hidden" name="job_application_id" value="{{ $application->id }}">
                                            <div class="form-group">
                                                <textarea name="content" class="form-control" rows="3" placeholder="Type your message here..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Send Message</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
            </div>
        </div>

    @include('footer')
    @include('script')
    
    <script>
    $(document).ready(function() {
        // Function to load messages via AJAX
        function loadMessages() {
            $.ajax({
                url: "{{ route('message.get', $application->id) }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    let messagesHtml = '';
                    console.log("datadatadatadata",data)    
                    if(data.messages)
                    {
                        data.messages.forEach(function(message) {
                            const senderName = message.user ? message.user.name : 'Unknown User';
                            const createdAt = new Date(message.created_at).toLocaleString();
                            
                            messagesHtml += `
                                <div class="message ${message.user_id == {{ Auth::id() }} ? 'sent' : 'received'} ${!message.is_read && message.user_id != {{ Auth::id() }} ? 'unread' : ''}">
                                    <div class="message-header">
                                        <strong>${senderName}</strong>
                                        <div>
                                            ${!message.is_read && message.user_id != {{ Auth::id() }} ?
                                                '<span class="badge badge-danger">New</span>' : ''}
                                            <small class="text-muted">${createdAt}</small>
                                        </div>
                                    </div>
                                    <div class="message-content">
                                        ${message.content}
                                    </div>
                                </div>
                            `;
                        });
                        $('.messages-container').html(messagesHtml);
                    }
                        
                    
                    scrollToBottom();
                },
                complete: function() {
                    // Schedule next refresh
                    setTimeout(loadMessages, 5000);    
                }
            });
        }

        // Function to scroll to bottom of messages
        function scrollToBottom() {
            $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
        }

        // Initial load
        loadMessages();

        // Handle form submission via AJAX
        $('form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function() {
                    $('textarea[name="content"]').val('');
                    loadMessages();
                }
            });
        });

        // Mark messages as read when viewed
        $(document).on('click', '.message', function() {
            if ($(this).hasClass('unread')) {
                let messageId = $(this).data('id');
                $.ajax({
                    url: "{{ route('message.markRead', $application->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: messageId
                    },
                    success: function() {
                        $(this).removeClass('unread');
                    }
                });
            }
        });
    });
    </script>
    
<style>
    .message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    .message.unread {
        border-left: 4px solid #007bff;
        background-color: #f8f9fa;
    }
    .sent {
        background-color: #e3f2fd;
        margin-left: 20%;
    }
    .received {
        background-color: #f5f5f5;
        margin-right: 20%;
    }
    .message-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
</style>
</body>
</html>
