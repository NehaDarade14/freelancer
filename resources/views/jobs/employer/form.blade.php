<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('New Job Post') }} @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('New Job Post') }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('New Job Post') }}</h1>
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
                                <h3>{{ isset($job) ? 'Edit Job' : 'Create New Job' }}</h3>
                            </div>

                            <div class="card-body">
                                <form method="POST" 
                                    action="{{ isset($job) ? route('employer.jobs.update', $job) : route('employer.jobs.store') }}">
                                    @csrf
                                    @if(isset($job))
                                        @method('PUT')
                                    @endif

                                    <div class="form-group">
                                        <label for="title">Job Title</label>
                                        <input type="text" 
                                            class="form-control @error('title') is-invalid @enderror" 
                                            id="title" 
                                            name="title" 
                                            value="{{ old('title', $job->title ?? '') }}"
                                            required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Job Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" 
                                                name="description" 
                                                rows="6"
                                                required>{{ old('description', $job->description ?? '') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="job_type">Job Type</label>
                                                <select class="form-control @error('job_type') is-invalid @enderror" 
                                                        id="job_type" 
                                                        name="job_type"
                                                        required>
                                                    <option value="">Select Job Type</option>
                                                    @foreach(['full-time', 'part-time', 'contract', 'freelance', 'internship'] as $type)
                                                        <option value="{{ $type }}" 
                                                            {{ old('job_type', $job->job_type ?? '') == $type ? 'selected' : '' }}>
                                                            {{ ucfirst($type) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('job_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="experience_level">Experience Level</label>
                                                <select class="form-control @error('experience_level') is-invalid @enderror" 
                                                        id="experience_level" 
                                                        name="experience_level"
                                                        required>
                                                    <option value="">Select Level</option>
                                                    @foreach(['entry', 'mid', 'senior', 'executive'] as $level)
                                                        <option value="{{ $level }}" 
                                                            {{ old('experience_level', $job->experience_level ?? '') == $level ? 'selected' : '' }}>
                                                            {{ ucfirst($level) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('experience_level')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="salary">Salary/Budget (optional)</label>
                                                <input type="number" 
                                                    class="form-control @error('salary') is-invalid @enderror" 
                                                    id="salary" 
                                                    name="salary" 
                                                    value="{{ old('salary', $job->salary ?? '') }}">
                                                @error('salary')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="location">Location</label>
                                                <input type="text" 
                                                    class="form-control @error('location') is-invalid @enderror" 
                                                    id="location" 
                                                    name="location" 
                                                    value="{{ old('location', $job->location ?? '') }}"
                                                    required>
                                                @error('location')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="deadline">Application Deadline</label>
                                        <input type="date" 
                                            class="form-control @error('deadline') is-invalid @enderror" 
                                            id="deadline" 
                                            name="deadline" 
                                            value="{{ old('deadline', isset($job) ? $job->deadline->format('Y-m-d') : '') }}"
                                            min="{{ date('Y-m-d') }}"
                                            required>
                                        @error('deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="skills_required">Required Skills (comma separated)</label>
                                        <input type="text" 
                                            class="form-control @error('skills_required') is-invalid @enderror" 
                                            id="skills_required" 
                                            name="skills_required" 
                                            value="{{ old('location', $job->skills_required ?? '') }}"
                                            required>
                                        @error('skills_required')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    @if(isset($job))
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status">
                                            @foreach(['draft', 'active', 'closed', 'archived'] as $status)
                                                <option value="{{ $status }}" 
                                                    {{ old('status', $job->status) == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endif

                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($job) ? 'Update Job' : 'Post Job' }}
                                        </button>
                                        <a href="{{ isset($job) ? route('jobs.show', $job) : route('employer.jobs') }}" 
                                        class="btn btn-link">
                                            Cancel
                                        </a>
                                    </div>
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
    </body>
</html>