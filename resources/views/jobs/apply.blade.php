@extends('layouts.main')

@section('content')
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
@endsection 

