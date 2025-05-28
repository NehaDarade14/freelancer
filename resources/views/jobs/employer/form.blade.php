@extends('layouts.main')

@section('content')
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
@endsection 