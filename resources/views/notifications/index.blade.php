@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Notifications</div>

            <div class="card-body">
                @if($notifications->count() > 0)
                    <div class="list-group">
                        @foreach($notifications as $notification)
                            <a href="{{ route('messages.index', ['user_id' => $notification->message->sender_id]) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $notification->user->name }}</h5>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">New message: {{ Str::limit($notification->message->content, 50) }}</p>
                            </a>
                        @endforeach
                    </div>

                    <button id="markAllAsRead" class="btn btn-primary mt-3">Mark All as Read</button>
                @else
                    <p>No new notifications</p>
                @endif
            </div>
        </div>
    </div>
</div>
      
@include('script')
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const markAllBtn = document.getElementById('markAllAsRead');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function () {
            const baseUrl = window.location.origin;

            fetch('{{ url("/all/notifications/mark-as-read") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }   
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        });
    }
});
</script>
 @endsection 