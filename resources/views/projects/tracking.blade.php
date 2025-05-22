<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) My Projects @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">My Projects</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">My Projects</h1>
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
                    <div class="card-header">My Projects</div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Project</th>
                                            <th>
                                            @if(auth()->user()->user_type === 'client')
                                                Client
                                            @else
                                                Freelancer
                                            @endif
                                                </th>
                                            <th>Status</th>
                                            <th>Deadline</th>
                                            <th>Budget</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projects as $project)
                                        <tr>
                                            <td>{{ ucfirst($project->title) }}</td>
                                            <td>
                                                @if(auth()->id() == $project->client_id)
                                                    {{ ucfirst($project->freelancer->name) }}
                                                @else
                                                    {{ ucfirst($project->client->name) }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $project->status == 'active' ? 'success' : ($project->status == 'completed' ? 'info' : 'warning') }}">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</td>

                                            <td>{{ config('payment.currency_symbol') }}{{ $project->budget }}</td>
                                            <td>
                                                <a href="{{ route('projects.tracking.show', $project) }}" class="btn btn-sm btn-primary">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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