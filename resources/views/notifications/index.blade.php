<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) Notifications @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Notifications</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">Notifications</h1>
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
                        <div class="card-header">Notifications</div>

                        <div class="card-body">
                            @if($notifications->count() > 0)
                                <div class="list-group">
                                    @foreach($notifications as $notification)
                                        <a href="{{ route('jobs.applications.messages', $notification->message->job_application_id) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $notification->message->user->name }}</h5>
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
        </section>
    </div>
</div>

@include('footer')
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
</body>
</html>  