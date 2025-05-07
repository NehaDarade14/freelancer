<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    @include('admin.stylesheet')
</head>

<body>
    @include('admin.navigation')

    <!-- Right Panel -->
    @if(Auth::user()->id == 1)
    <div id="right-panel" class="right-panel">
        @include('admin.header')
        @include('admin.warning')
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-3 ml-auto" align="right">
                    
                    </div>
                    <div class="col-md-12">
                       
                        <div class="card">
                            <div class="card-header">Create New Job</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.jobs.store') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Job Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Job Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="job_type" class="form-label">Job Type</label>
                                            <select class="form-select" id="job_type" name="job_type" required>
                                                <option value="full-time">Full-time</option>
                                                <option value="part-time">Part-time</option>
                                                <option value="contract">Contract</option>
                                                <option value="freelance">Freelance</option>
                                                <option value="internship">Internship</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="experience_level" class="form-label">Experience Level</label>
                                            <select class="form-select" id="experience_level" name="experience_level" required>
                                                <option value="entry">Entry Level</option>
                                                <option value="mid">Mid Level</option>
                                                <option value="senior">Senior Level</option>
                                                <option value="executive">Executive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="salary" class="form-label">Salary (USD)</label>
                                            <input type="number" step="0.01" class="form-control" id="salary" name="salary">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="location" name="location" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deadline" class="form-label">Application Deadline</label>
                                        <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="skills_required" class="form-label">Required Skills (comma separated)</label>
                                        <input type="text" class="form-control" id="skills_required" name="skills_required" placeholder="e.g. PHP, Laravel, JavaScript">
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Create Job</button>
                                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    @include('admin.denied')
    @endif 
    @include('admin.javascript')

</body>

</html>