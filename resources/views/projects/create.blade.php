<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) Initiate Project with {{ ucfirst($freelancer->name) }} @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Initiate Project with {{ ucfirst($freelancer->name) }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">Initiate Project with {{ ucfirst($freelancer->name) }}</h1>
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
                            <h3>Initiate Project with {{ ucfirst($freelancer->name) }}</h3>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('projects.store') }}">
                                @csrf
                                <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">

                                <div class="form-group row">
                                    <label for="title" class="col-md-4 col-form-label text-md-right">Project Title</label>
                                    <div class="col-md-6">
                                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" 
                                            name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">Project Brief</label>
                                    <div class="col-md-6">
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                            name="description" required rows="5" placeholder="Overall project description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="scope" class="col-md-4 col-form-label text-md-right">Project Scope</label>
                                    <div class="col-md-6">
                                        <textarea id="scope" class="form-control @error('scope') is-invalid @enderror"
                                            name="scope" required rows="3" placeholder="Detailed scope of work">{{ old('scope') }}</textarea>
                                        @error('scope')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="deliverables" class="col-md-4 col-form-label text-md-right">Deliverables</label>
                                    <div class="col-md-6">
                                        <textarea id="deliverables" class="form-control @error('deliverables') is-invalid @enderror"
                                            name="deliverables" required rows="3" placeholder="Expected outputs and milestones">{{ old('deliverables') }}</textarea>
                                        @error('deliverables')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="requirements" class="col-md-4 col-form-label text-md-right">Technical Requirements</label>
                                    <div class="col-md-6">
                                        <textarea id="requirements" class="form-control @error('requirements') is-invalid @enderror"
                                            name="requirements" rows="3" placeholder="Specific technical needs">{{ old('requirements') }}</textarea>
                                        @error('requirements')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="communication" class="col-md-4 col-form-label text-md-right">Communication</label>
                                    <div class="col-md-6">
                                        <select id="communication" class="form-control @error('communication') is-invalid @enderror"
                                            name="communication" required>
                                            <option value="">Select preferred method</option>
                                            <option value="email">Email</option>
                                            <option value="chat">Platform Chat</option>
                                            <option value="video">Video Calls</option>
                                            <option value="mixed">Mixed (All of above)</option>
                                        </select>
                                        @error('communication')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="budget" class="col-md-4 col-form-label text-md-right">Budget ($)</label>
                                    <div class="col-md-6">
                                        <input id="budget" type="number" min="1" step="0.01" 
                                            class="form-control @error('budget') is-invalid @enderror" 
                                            name="budget" value="{{ old('budget') }}" required>
                                        @error('budget')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="deadline" class="col-md-4 col-form-label text-md-right">Deadline</label>
                                    <div class="col-md-6">
                                        <input id="deadline" type="date" 
                                            class="form-control @error('deadline') is-invalid @enderror" 
                                            name="deadline" value="{{ old('deadline') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                        @error('deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Initiate Project
                                        </button>
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

    @include('footer')
    @include('script')
    </body>
</html>