<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) Project Details: {{ $project->title }} @else {{ __('404 Not Found') }} @endif</title>
@include('meta')
@include('style')
<style>
.rating-stars {
    direction: rtl;
    unicode-bidi: bidi-override;
    text-align: center;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    font-size: 2rem;
    color: #ddd;
    padding: 0 5px;
}

.rating-stars input:checked ~ label i,
.rating-stars label:hover i,
.rating-stars label:hover ~ label i {
    color: #ffd700;
}

</style>
</head>
<body>
@include('header')

<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
                <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Project Details: {{ $project->title }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">Project Details: {{ $project->title }}</h1>
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
        
        
        <section class="col-lg-8">

            <!-- <div class="container"> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- Content  -->
                        @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach($errors->all() as $error)
                                <p class="mb-1">{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif
                        
                        @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                        @endif
                            <div class="card-header">Project Details: {{ $project->title }}</div>
                        
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="freelancer_id" value="{{ $project->freelancer_id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Project Information</h6>
                                        <p><strong>Status:</strong> 
                                            <span class="badge badge-{{ $project->status == 'active' ? 'success' : ($project->status == 'completed' ? 'info' : 'warning') }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Budget:</strong> {{ config('payment.currency_symbol') }}{{ $project->budget }}</p>
                                        <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</p>
                                        <p><strong>Created:</strong> {{ \Carbon\Carbon::parse($project->created_at)->format('M d, Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Client/Freelancer Details</h6>
                                        @if(auth()->id() == $project->client_id)
                                            <p><strong>Freelancer:</strong> {{ $project->freelancer->name }}</p>
                                            <p><strong>Email:</strong> {{ $project->freelancer->email }}</p>
                                        @else
                                            <p><strong>Client:</strong> {{ $project->client->name }}</p>
                                            <p><strong>Email:</strong> {{ $project->client->email }}</p>
                                        @endif
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6>Project Scope</h6>
                                        <div class="card card-body bg-light">
                                            {!! nl2br(e($project->scope)) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6>Deliverables</h6>
                                        <div class="card card-body bg-light">
                                            {!! nl2br(e($project->deliverables)) !!}
                                        </div>
                                    </div>
                                </div>

                                @if($project->requirements)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6>Requirements</h6>
                                        <div class="card card-body bg-light">
                                            {!! nl2br(e($project->requirements)) !!}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Progress Tracking -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6>Project Progress</h6>
                                        <div class="progress mb-3" style="height: 25px;">
                                            <div class="progress-bar progress-bar-striped bg-success"
                                                role="progressbar"
                                                style="width: {{ $project->progress }}%"
                                                aria-valuenow="{{ $project->progress }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $project->progress }}%
                                            </div>
                                        </div>

                                         @if(auth()->user()->user_type === 'client')
                                        <form method="POST" action="{{ route('projects.update-progress', $project) }}">
                                            @csrf
                                            <div class="input-group">
                                                <input type="number" name="progress"
                                                    class="form-control"
                                                    min="0" max="100"
                                                    value="{{ $project->progress }}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">
                                                            Update Progress
                                                        </button>
                                                    </div>
                                                </div>
                                        </form>
                                        @endif

                                        @if($project->status == 'completed')
                                        <form method="POST" action="{{ route('projects.rate', $project) }}">
                                            @csrf   
                                            <div class="rating-section mt-4 p-3 border rounded bg-light">
                                                <h5 class="mb-4"><i class="fa fa-star"></i> 
                                                    
                                                    @if(auth()->user()->user_type === 'client')
                                                        Rate Freelancer Performance
                                                    @else
                                                        Rate Client
                                                    @endif
                                                </h5>
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <input type="hidden" name="freelancer_id" value="{{ $project->freelancer_id }}">
                                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                                @if(auth()->user()->user_type === 'client' && $project->status == 'completed')
                                                    <!-- Work Quality -->
                                                    <div class="mb-4">
                                                        <h6>Work Quality</h6>
                                                        <div class="rating-stars text-center">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <input type="radio"
                                                                    id="work_star{{ $i }}"
                                                                    name="work_rating"
                                                                    value="{{ $i }}"
                                                                    {{ (old('work_rating', $review->work_rating ?? '') == $i) ? 'checked' : '' }}
                                                                    required>
                                                                <label class="star" for="work_star{{ $i }}"><i class="fa fa-star fa-2x"></i></label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                @endif
                                                <!-- Communication -->
                                                <div class="mb-4">
                                                    <h6>Communication</h6>
                                                    <div class="rating-stars text-center">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio"
                                                                id="comm_star{{ $i }}"
                                                                name="communication_rating"
                                                                value="{{ $i }}"
                                                                {{ (old('communication_rating', $review->communication_rating ?? '') == $i) ? 'checked' : '' }}
                                                                required>
                                                            <label class="star" for="comm_star{{ $i }}"><i class="fa fa-star fa-2x"></i></label>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <!-- Payment -->
                                                <div class="mb-4">
                                                    <h6>Payment Process</h6>
                                                    <div class="rating-stars text-center">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio"
                                                                id="payment_star{{ $i }}"
                                                                name="payment_rating"
                                                                value="{{ $i }}"
                                                                {{ (old('payment_rating', $review->payment_rating ?? '') == $i) ? 'checked' : '' }}
                                                                required>
                                                            <label class="star" for="payment_star{{ $i }}"><i class="fa fa-star fa-2x"></i></label>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <!-- Review Text -->
                                                <div class="form-group">
                                                    <label>Review Comments</label>
                                                    <textarea name="review_text" class="form-control" rows="3" maxlength="500">{{ old('review_text', $review->review_text ?? '') }}</textarea>
                                                </div>

                                                <div class="mt-4 ml-4 text-right">
                                                    <button type="submit" class="btn btn-primary btn-lg">
                                                        <i class="fa fa-paper-plane mr-2"></i> {{ $review ? 'Update Rating' : 'Submit Rating' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        @endif
                                    </div>
                                </div>

                                <!-- Status Management -->
                                @if(auth()->user()->user_type === 'client')
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6>Update Status</h6>
                                        <form method="POST" action="{{ route('projects.update-status', $project) }}">
                                            @csrf
                                            <div class="form-group" style="width:100%;display:inline-flex">
                                                <select name="status" class="form-control">
                                                    <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">
                                                Update Status
                                            </button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                                @endif

                                <div class="mt-3">
                                    <a href="{{ route('projects.dashboard') }}" class="btn btn-secondary">
                                        Back to Projects
                                    </a>
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