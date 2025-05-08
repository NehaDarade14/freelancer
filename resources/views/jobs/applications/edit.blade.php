@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Edit Application for: {{ $jobApplication->job->title }}</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('job-applications.update', $jobApplication) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="job_id" value="{{ $jobApplication->job_id }}">

                        <div class="form-group row">
                            <label for="bid_amount" class="col-md-3 col-form-label text-md-right">Your Bid Amount</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ config('app.currency_symbol') }}</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" max="{{ $jobApplication->job->budget }}" 
                                           class="form-control @error('bid_amount') is-invalid @enderror" 
                                           id="bid_amount" name="bid_amount" 
                                           value="{{ old('bid_amount', $jobApplication->bid_amount) }}" required>
                                    @error('bid_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Job budget: {{ config('app.currency_symbol') }}{{ number_format($jobApplication->job->budget, 2) }}
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="proposal" class="col-md-3 col-form-label text-md-right">Your Proposal</label>
                            <div class="col-md-9">
                                <textarea class="form-control @error('proposal') is-invalid @enderror" 
                                          id="proposal" name="proposal" rows="8" required>{{ old('proposal', $jobApplication->proposal) }}</textarea>
                                @error('proposal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Explain why you're the best candidate for this job (minimum 100 characters)
                                </small>
                                <div class="text-right">
                                    <span id="proposal_counter">{{ strlen(old('proposal', $jobApplication->proposal)) }}</span>/100 characters
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Current Attachments</label>
                            <div class="col-md-9">
                                @if($jobApplication->attachments->count() > 0)
                                    <div class="mb-3">
                                        @foreach($jobApplication->attachments as $attachment)
                                            <div class="d-flex align-items-center mb-2">
                                                <a href="{{ $attachment->getUrl() }}" target="_blank" class="mr-2">
                                                    <i class="fas fa-file-{{ $attachment->getTypeIcon() }}"></i> {{ $attachment->file_name }}
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-attachment" 
                                                        data-attachment-id="{{ $attachment->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No attachments uploaded</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="attachments" class="col-md-3 col-form-label text-md-right">Add New Attachments</label>
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
                                    <i class="fas fa-save"></i> Update Application
                                </button>
                                <a href="{{ route('jobs.show', $jobApplication->job) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
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
        if (parseFloat(this.value) > parseFloat({{ $jobApplication->job->budget }})) {
            this.setCustomValidity('Bid amount cannot exceed job budget');
        } else {
            this.setCustomValidity('');
        }
    });

    // Handle attachment deletion
    document.querySelectorAll('.delete-attachment').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this attachment?')) {
                fetch(`/job-applications/attachments/${this.dataset.attachmentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.d-flex').remove();
                    }
                });
            }
        });
    });
</script>
@endsection