<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('Available Jobs') }} @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Available Jobs') }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('Available Jobs') }}</h1>
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
                                Apply for: {{ $job->title }}
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('jobs.apply.submit', $job) }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="proposal">Your Proposal</label>
                                        <textarea class="form-control @error('proposal') is-invalid @enderror" 
                                                id="proposal" 
                                                name="proposal" 
                                                rows="8"
                                                required>{{ old('proposal') }}</textarea>
                                        <small class="form-text text-muted">Minimum 100 characters. Explain why you're the best fit for this job.</small>
                                        @error('proposal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div id="proposal-counter" class="text-right text-muted">0/5000 characters</div>
                                    </div>

                                    <div class="form-group">
                                        <label for="bid_amount">Your Bid ({{ $job->salary ? 'Budget: $'.number_format($job->salary) : 'No budget specified' }})</label>
                                        <input type="number" 
                                            class="form-control @error('bid_amount') is-invalid @enderror" 
                                            id="bid_amount" 
                                            name="bid_amount" 
                                            value="{{ old('bid_amount') }}"
                                            min="1"
                                            {{ $job->salary ? 'max='.$job->salary : '' }}
                                            required>
                                        @error('bid_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Attachments (Optional)</label>
                                        <div class="custom-file">
                                            <input type="file" 
                                                class="custom-file-input @error('attachments.*') is-invalid @enderror" 
                                                id="attachments" 
                                                name="attachments[]" 
                                                multiple>
                                            <label class="custom-file-label" for="attachments">Choose files (PDF, DOC, DOCX)</label>
                                            @error('attachments.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Max 2MB per file. You can upload multiple files.</small>
                                    </div>

                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary">
                                            Submit Application
                                        </button>
                                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-link">Cancel</a>
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
<script>
    // Character counter for proposal
    document.getElementById('proposal').addEventListener('input', function() {
        const counter = document.getElementById('proposal-counter');
        counter.textContent = this.value.length + '/5000 characters';
    });

    // Show file names when selected
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        let files = [];
        for (let i = 0; i < this.files.length; i++) {
            files.push(this.files[i].name);
        }
        this.nextElementSibling.textContent = files.join(', ') || 'Choose files';
    });
</script>
</body>
</html>   

