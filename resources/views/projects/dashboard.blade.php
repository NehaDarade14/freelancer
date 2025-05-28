@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Project Dashboard</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <!-- <input type="text" class="form-control" placeholder="Search projects..." id="projectSearch">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group  mb-3">
                                <button class="btn btn-outline-primary filter-btn" data-filter="all">All</button>
                                <button class="btn btn-outline-success filter-btn" data-filter="active">Active</button>
                                <button class="btn btn-outline-info filter-btn" data-filter="completed">Completed</button>
                            </div>
                        </div>
                    </div>
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Projects</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Active Projects</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-tasks fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Avg. Progress</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $stats['avg_progress'] }}%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ $stats['avg_progress'] }}%" 
                                                            aria-valuenow="{{ $stats['avg_progress'] }}" 
                                                            aria-valuemin="0" 
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-chart-line fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Overdue Projects</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['overdue'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-exclamation-triangle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="row">
                        <!-- Projects Table -->
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Projects Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">View Options:</div>
                                            <a class="dropdown-item" href="#" id="viewTable">Table View</a>
                                            <a class="dropdown-item" href="#" id="viewKanban">Kanban Board</a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" id="tableView">
                                        <table class="table table-bordered" id="projectsTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Project</th>
                                                    <th>Status</th>
                                                    <th>Progress</th>
                                                    <th>Team</th>
                                                    <th>Deadline</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($projects as $project)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('projects.tracking.show', $project) }}">
                                                            {{ $project->title }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $project->status == 'active' ? 'success' : ($project->status == 'completed' ? 'info' : 'warning') }}">
                                                            {{ ucfirst($project->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar progress-bar-striped bg-success" 
                                                                role="progressbar" 
                                                                style="width: {{ $project->progress }}%" 
                                                                aria-valuenow="{{ $project->progress }}" 
                                                                aria-valuemin="0" 
                                                                aria-valuemax="100">
                                                                {{ $project->progress }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($project->team)
                                                            {{ $project->team->name }}
                                                        @else
                                                            <small class="text-muted">No team assigned</small>
                                                        @endif
                                                    </td>
                                                    <td class="{{ $project->isOverdue() ? 'text-danger' : '' }}">
                                                        {{ $project->deadline->format('M d, Y') }}
                                                        @if($project->isOverdue())
                                                            <i class="fa fa-exclamation-circle ml-1"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('projects.tracking.show', $project) }}" class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-none" id="kanbanView">
                                        <!-- Kanban Board will be loaded here via AJAX -->
                                        <div class="kanban-container"></div>
                                    </div>

                                    <div class="d-none" id="ganttView">
                                        <!-- Gantt Chart will be loaded here via AJAX -->
                                        <div id="gantt-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Analytics Sidebar -->
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Project Analytics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="statusPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fa fa-circle text-success"></i> Active
                                        </span>
                                        <span class="mr-2">
                                            <i class="fa fa-circle text-info"></i> Completed
                                        </span>
                                        <span class="mr-2">
                                            <i class="fa fa-circle text-warning"></i> Pending
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Upcoming Deadlines</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        @foreach($upcomingDeadlines as $project)
                                        <a href="{{ route('projects.tracking.show', $project) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $project->title }}</h6>
                                                @if ($project->daysUntilDeadline() < 0)
                                                    <span class="text-danger">{{ abs($project->daysUntilDeadline()) }} days overdue</span>
                                                @else
                                                    <span>{{ $project->daysUntilDeadline() }} days left</span>
                                                @endif

                                            </div>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-{{ $project->progress < 50 ? 'danger' : ($project->progress < 80 ? 'warning' : 'success') }}" 
                                                    role="progressbar" 
                                                    style="width: {{ $project->progress }}%" 
                                                    aria-valuenow="{{ $project->progress }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        
    @include('script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#projectsTable').DataTable({
                responsive: true,
                order: [[4, 'asc']]
            });

            // View Toggle
            $('#viewTable').click(function(e) {
                e.preventDefault();
                $('#tableView').removeClass('d-none');
                $('#kanbanView').addClass('d-none');
                $('#ganttView').addClass('d-none');
            });

            $('#viewKanban').click(function(e) {
                e.preventDefault();
                loadKanbanView();
            });

            $('#viewGantt').click(function(e) {
                e.preventDefault();
                loadGanttView();
            });

            // Filter buttons
            $('.filter-btn').click(function() {
                const filter = $(this).data('filter');
                $('#projectsTable').DataTable().search(filter === 'all' ? '' : filter).draw();
            });

            // Status Pie Chart
            const ctx = document.getElementById('statusPieChart');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Completed', 'Pending'],
                    datasets: [{
                        data: [{{ $stats['active'] }}, {{ $stats['completed'] }}, {{ $stats['pending'] }}],
                        backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e'],
                        hoverBackgroundColor: ['#17a673', '#2c9faf', '#dda20a'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });

            function loadKanbanView() {
                $('#tableView').addClass('d-none');
                $('#ganttView').addClass('d-none');
                $('#kanbanView').removeClass('d-none');

                if ($('.kanban-container').is(':empty')) {
                    $.ajax({
                        url: '{{ route("projects.kanban") }}',
                        method: 'GET',
                        success: function(data) {
                            $('.kanban-container').html(data);
                            initKanban();
                        }
                    });
                }
            }

            function loadGanttView() {
                $('#tableView').addClass('d-none');
                $('#kanbanView').addClass('d-none');
                $('#ganttView').removeClass('d-none');

                if ($('#gantt-chart').is(':empty')) {
                    $.ajax({
                        url: '{{ route("projects.gantt") }}',
                        method: 'GET',
                        success: function(data) {
                            $('#gantt-chart').html(data);
                            initGantt();
                        }
                    });
                }
            }
        });
    </script>
 @endsection 



