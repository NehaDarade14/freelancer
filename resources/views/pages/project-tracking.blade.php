<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) Project Tracking @else {{ __('404 Not Found') }} @endif</title>
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
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">@if (auth()->user()->user_type === 'client') 
                                        Client Project Tracking
                                    @else
                                        Freelancer Project Tracking
                                    @endif</li>
                    </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h1 class="h3 mb-0 text-white">@if (auth()->user()->user_type === 'client') 
                                        Client Project Tracking
                                    @else
                                        Freelancer Project Tracking
                                    @endif</h1>
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
                                    @if (auth()->user()->user_type === 'client') 
                                        <h4>Client Project Tracking</h4>
                                    @else
                                        <h4>Freelancer Project Tracking</h4>
                                    @endif
                                </div>

                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Project</th>
                                                    <th>Client</th>
                                                    <th>Progress</th>
                                                    <th>Deadline</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($projects as $project)
                                                <tr>
                                                    <td>{{ $project->name }}</td>
                                                    <td>{{ $project->client->name }}</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" 
                                                                style="width: {{ $project->progress }}%" 
                                                                aria-valuenow="{{ $project->progress }}" 
                                                                aria-valuemin="0" 
                                                                aria-valuemax="100">
                                                                {{ $project->progress }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $project->deadline->format('M d, Y') }}</td>
                                                    <td>
                                                        <div>
                                                            <span class="badge badge-{{ $project->job_status_color }}">
                                                                Job: {{ ucfirst($project->job_status) }}
                                                            </span>
                                                            <span class="badge badge-{{ $project->application_status_color }} mt-1">
                                                                Status: {{ ucfirst($project->application_status) }}
                                                            </span>
                                                        </div>
                                                        <!-- <div class="mt-2 small">
                                                            <div>Pending: {{ $project->steps['pending'] }}</div>
                                                            <div>In Progress: {{ $project->steps['in_progress'] }}</div>
                                                            <div>Review: {{ $project->steps['review'] }}</div>
                                                            <div>Completed: {{ $project->steps['completed'] }}</div>
                                                        </div> -->
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('jobs.show', $project->id) }}" class="btn btn-sm btn-primary mb-2">
                                                            View
                                                        </a>
                                                        @if($project->can_update == true && $project->application_count != 0 && auth()->user()->user_type === 'client')
                                                        <form method="POST" action="{{ route('project.update_status', ['job' => $project->id, 'freelancerId' => $project->freelancer_id]) }}" class="status-form" data-type="application">
                                                            @csrf
                                                            <select name="status" class="form-control form-control-sm mb-2 status-select">
                                                                <option value="pending" {{ $project->application_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="in_progress" {{ $project->application_status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                                <option value="review" {{ $project->application_status == 'review' ? 'selected' : '' }}>Review</option>
                                                                <option value="completed" {{ $project->application_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                <option value="rejected" {{ $project->application_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                            </select>
                                                            <div class="status-loading d-none">
                                                                <small class="text-muted">Updating...</small>
                                                            </div>
                                                        </form>
                                                        <form method="POST" action="{{ route('project.update_job_status', $project->id) }}" class="status-form" data-type="job">
                                                            @csrf
                                                            <select name="job_status" class="form-control form-control-sm status-select">
                                                                <option value="draft" {{ $project->job_status == 'draft' ? 'selected' : '' }}>Job: Draft</option>
                                                                <option value="active" {{ $project->job_status == 'active' ? 'selected' : '' }}>Job: Active</option>
                                                                <option value="closed" {{ $project->job_status == 'closed' ? 'selected' : '' }}>Job: Closed</option>
                                                                <option value="archived" {{ $project->job_status == 'archived' ? 'selected' : '' }}>Job: Archived</option>
                                                            </select>
                                                            <div class="status-loading d-none">
                                                                <small class="text-muted">Updating...</small>
                                                            </div>
                                                        </form>
                                                        
                                                    
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                document.querySelectorAll('.status-select').forEach(select => {
                                                                    // Store the previous value for rollback
                                                                    select.dataset.previousValue = select.value;

                                                                    select.addEventListener('change', function () {
                                                                        const form = this.closest('.status-form');
                                                                        const formData = new FormData(form);
                                                                        const loading = form.querySelector('.status-loading');
                                                                        const selectElement = this;

                                                                        loading.classList.remove('d-none');
                                                                        selectElement.disabled = true;

                                                                        fetch(form.action, {
                                                                            method: 'POST',
                                                                            body: formData,
                                                                            headers: {
                                                                                'X-Requested-With': 'XMLHttpRequest',
                                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                            }
                                                                        })
                                                                        .then(async response => {
                                                                            if (!response.ok) {
                                                                                // Try to get error message from the response
                                                                                const errorData = await response.json().catch(() => ({}));
                                                                                throw new Error(errorData.message || 'Request failed');
                                                                            }
                                                                            return response.json();
                                                                        })
                                                                        .then(data => {
                                                                            loading.classList.add('d-none');
                                                                            selectElement.disabled = false;

                                                                            if (data.success) {
                                                                                // Update status badge
                                                                                const statusType = form.dataset.type;
                                                                                const statusBadge = form.closest('tr').querySelector(`.badge-${statusType}`);
                                                                                if (statusBadge) {
                                                                                    const newStatus = selectElement.options[selectElement.selectedIndex].text;
                                                                                    statusBadge.textContent = `${statusType === 'job' ? 'Job' : 'Status'}: ${newStatus}`;

                                                                                    const colorMap = {
                                                                                        'Pending': 'warning',
                                                                                        'In Progress': 'primary',
                                                                                        'Review': 'info',
                                                                                        'Completed': 'success',
                                                                                        'Rejected': 'danger',
                                                                                        'Cancelled': 'secondary'
                                                                                    };

                                                                                    Object.values(colorMap).forEach(color => {
                                                                                        statusBadge.classList.remove(`badge-${color}`);
                                                                                    });

                                                                                    statusBadge.classList.add(`badge-${colorMap[newStatus] || 'secondary'}`);
                                                                                }

                                                                                // Success alert
                                                                                const alert = document.createElement('div');
                                                                                alert.className = 'alert alert-success';
                                                                                alert.textContent = 'Status updated successfully';
                                                                                document.querySelector('.card-body').prepend(alert);
                                                                                setTimeout(() => alert.remove(), 3000);
                                                                            }
                                                                            window.location.reload();
                                                                        })
                                                                        .catch(error => {
                                                                            loading.classList.add('d-none');
                                                                            selectElement.disabled = false;
                                                                            selectElement.value = selectElement.dataset.previousValue;

                                                                            const alert = document.createElement('div');
                                                                            alert.className = 'alert alert-danger';
                                                                            alert.textContent = error.message || 'Failed to update status';
                                                                            document.querySelector('.card-body').prepend(alert);
                                                                            setTimeout(() => alert.remove(), 3000);
                                                                        });
                                                                    });
                                                                });
                                                            });
                                                        </script>

                                                        @else
                                                            <br/>
                                                            @if($project->can_update == true && auth()->user()->user_type === 'client')
                                                            <span class="badge badge-danger">No applications for this project</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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