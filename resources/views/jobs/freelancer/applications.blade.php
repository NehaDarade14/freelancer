<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('My Job Applications') }} @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('My Job Applications') }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('My Job Applications') }}</h1>
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
                                <h3>My Job Applications</h3>
                            </div>

                            <div class="card-body">
                                @if($applications->isEmpty())
                                    <div class="alert alert-info">You haven't applied to any jobs yet.</div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Job Title</th>
                                                    <th>Employer</th>
                                                    <th>Bid Amount</th>
                                                    <th>Status</th>
                                                    <th>Applied On</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($applications as $application)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('jobs.show', $application->job) }}">
                                                            {{ $application->job->title }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $application->job->employer->name }}</td>
                                                    <td>${{ number_format($application->bid_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge 
                                                            @if($application->status == 'submitted') badge-primary
                                                            @elseif($application->status == 'under_review') badge-info
                                                            @elseif($application->status == 'accepted') badge-success
                                                            @elseif($application->status == 'rejected') badge-danger
                                                            @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('freelancer.jobs.applications.view', $application) }}" 
                                                        class="btn btn-sm btn-outline-primary">
                                                            View
                                                        </a>
                                                        <a href="{{ route('message.index', $application) }}"
                                                                    class="btn btn-sm btn-outline-info">
                                                                        Message
                                                                    </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $applications->links() }}
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
</body>
</html>