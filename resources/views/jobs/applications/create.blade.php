@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Apply for: {{ $job->title }}</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('job-applications.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}">

                        <div class="form-group row">
                            <label for="bid_amount" class="col-md-3 col-form-label text-md-right">Your Bid Amount</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ config('app.currency_symbol') }}</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" max="{{ $job->budget }}" 
                                           class="form-control @error('bid_amount') is-invalid @enderror" 
                                           id="bid_amount" name="bid_amount" 
                                           value="{{ old('bid_amount') }}" required>
                                    @error('bid_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Job budget: {{ config('app.currency_symbol') }}{{ number_format($job->budget, 2) }}
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="proposal" class="col-md-3 col-form-label text-md-right">Your Proposal</label>
                            <div class="col-md-9">
                                <textarea class="form-control @error('proposal') is-invalid @enderror" 
                                          id="proposal" name="proposal" rows="8" required>{{ old('proposal') }}</textarea>
                                @error('proposal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Explain why you're the best candidate for this job (minimum 100 characters)
                                </small>
                                <div class="text-right">
                                    <span id="proposal_counter">0</span>/100 characters
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="attachments" class="col-md-3 col-form-label text-md-right">Attachments</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('attachments.*') is-invalid @enderror" 
                                           id="attachments" name="attachments[]" multiple>
                                    <label class="custom-file-label" for="attachments">Choose files...</label>
                                    @error('attachments.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    You can upload up to 5 files (PDF, DOC, JPG, PNG) with a maximum size of 5MB each
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <i class="fa fa-paper-plane"></i> Submit Application
                                </button>
                                <a href="{{ route('jobs.show', $job) }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update file input label with selected file names
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        let files = e.target.files;
        let label = this.nextElementSibling;
        if (files.length > 1) {
            label.innerText = files.length + ' files selected';
        } else if (files.length === 1) {
            label.innerText = files[0].name;
        } else {
            label.innerText = 'Choose files...';
        }
    });

    // Validate proposal length and update counter
    const proposalField = document.getElementById('proposal');
    const proposalCounter = document.getElementById('proposal_counter');
    const submitBtn = document.getElementById('submit-btn');

    proposalField.addEventListener('input', function(e) {
        const length = this.value.length;
        proposalCounter.textContent = length;
        
        if (length < 100) {
            this.setCustomValidity('Proposal must be at least 100 characters long');
            submitBtn.disabled = true;
        } else {
            this.setCustomValidity('');
            submitBtn.disabled = false;
        }
    });

    // Validate bid amount doesn't exceed job budget
    document.getElementById('bid_amount').addEventListener('change', function(e) {
        if (parseFloat(this.value) > parseFloat({{ $job->budget }})) {
            this.setCustomValidity('Bid amount cannot exceed job budget');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endsection