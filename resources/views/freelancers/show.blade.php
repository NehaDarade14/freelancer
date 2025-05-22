<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('My Job Postings') }} @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('My Job Postings') }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('My Job Postings') }}</h1>
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
                                <h3>{{ ucfirst($freelancer->name) }}'s Profile</h3>
                            </div>

                            <div class="card-body">
                                <div class="text-right mb-4">
                                    <a href="{{ route('projects.create', ['freelancer_id' => $freelancer->id]) }}"
                                       class="btn btn-primary">
                                       <i class="dwg-briefcase mr-2"></i>Initiate Project
                                    </a>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4 text-center">
                                            @if($freelancer->user_photo != '')
                                            <img class="rounded-circle" width="150" src="{{ url('/') }}/public/storage/users/{{ $freelancer->user_photo }}"  alt="{{ $freelancer->name }}">
                                            @else
                                            <img class="rounded-circle" width="150" src="{{ url('/') }}/public/img/no-image.png"  alt="{{ $freelancer->name }}">
                                            @endif

                                        <h5 class="mt-3">{{ ucfirst($freelancer->name) }}</h5>
                                        <p class="text-muted">
                                            Availability: {{ ucfirst(str_replace('_', ' ', $freelancer->available)); }}
                                        </p>
                                        <p class="text-muted">
                                            Experience: {{ $freelancer->experience ? $freelancer->experience .' year' : '' }}
                                        </p>
                                    </div>

                                    <div class="col-md-8">
                                        <h5>Skills</h5>
                                        <div class="mb-3">
                                        @foreach(explode(',', $freelancer->skills) as $skill)
                                            <span class="badge badge-primary">{{ trim($skill) }}</span>
                                        @endforeach

                                        </div>

                                        <h5>Rating</h5>
                                        <div class="mb-3">
                                            @php
                                                $rating = round($freelancer->rating, 1); // use the correct field
                                                $fullStars = floor($rating);
                                                $halfStar = ($rating - $fullStars) >= 0.5;
                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa fa-star text-warning"></i>
                                            @endfor

                                            @if ($halfStar)
                                                <i class="fa fa-star-half text-warning"></i>
                                            @endif

                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="fa fa-star-o text-warning"></i>
                                            @endfor

                                            <span class="ml-2">({{ $rating }} stars)</span>
                                        </div>



                                        <h5>Portfolio</h5>

                                        <div class="mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    @if($freelancer->facebook_url)
                                                        <a href="{{$freelancer->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Facebook View</a>
                                                    @endif
                                                    @if($freelancer->twitter_url)
                                                        <a href="{{$freelancer->twitter_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Twitter View</a>
                                                    @endif
                                                    @if($freelancer->gplus_url)
                                                        <a href="{{$freelancer->gplus_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Gplus View</a>
                                                    @endif
                                                    @if($freelancer->instagram_url)
                                                        <a href="{{$freelancer->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Instagram View</a>
                                                    @endif
                                                    @if($freelancer->linkedin_url)
                                                        <a href="{{$freelancer->linkedin_url }}" target="_blank" class="btn btn-sm btn-outline-primary">LinkedIn View</a>
                                                    @endif
                                                    @if($freelancer->pinterest_url)
                                                        <a href="{{$freelancer->pinterest_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Pinterest View</a>
                                                    @endif
                                                    @if($freelancer->github_url)
                                                        <a href="{{$freelancer->github_url }}" target="_blank" class="btn btn-sm btn-outline-primary">GitHub View</a>
                                                    @endif
                                                    @if($freelancer->other)
                                                        <a href="{{$freelancer->other }}" target="_blank" class="btn btn-sm btn-outline-primary">Other View</a>
                                                    @endif
                                            </div>
                                        </div>
                                        </div>
                                        <h5>Professional Bio</h5>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <p> {{$freelancer->professional_bio}} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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