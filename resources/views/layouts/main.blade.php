<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    
    @include('style')
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #343a40;
            font-size:18px;
        }
        .sidebar {
            width: 350px;
            background-color: #343a40;
            color: #fff;
            padding: 1rem;
            list-style-type: none;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            margin: 1rem 0;
        }
        .sidebar a:hover {
            color: #fff;
        }
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            color: #fff;
            padding: 1rem 2rem;
        }
        .content {
            flex: 1;
            padding: 2rem;
            background-color: white;
            border-radius:50px;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        .cover {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .icon-box {
            font-size: 2rem;
            color: #0d6efd;
        }
        h1, h2, h3, h4, h5, h6{
            color: black;
        }
        ul{
             list-style-type: none;
             padding: 0;
            margin: 0;
        }
        .account-head{
            color:white;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="mb-4 account-head"><i class="bi bi-speedometer2 me-2"></i>Account</h4>
        <ul>
          @if(Auth::user()->user_type == 'freelancer')
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/profile-settings') }}"><i class="dwg-settings opacity-60 mr-2"></i>{{ __('Setting') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/all/jobs') }}"><i class="dwg-briefcase opacity-60 mr-2"></i>{{ __('Jobs') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/all/jobs/applications') }}"><i class="dwg-list opacity-60 mr-2"></i>{{ __('My Applications') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/projects/dashboard') }}"><i class="dwg-list opacity-60 mr-2"></i>{{ __('Project Tracking') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/all/notification') }}"><i class="dwg-bell opacity-60 mr-2"></i>{{ __('Notifications') }} <span id="notificationBadge" class="badge badge-primary badge-pill ml-auto" style="display: none">0</span></a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/messages') }}"><i class="dwg-chat opacity-60 mr-2"></i>{{ __('Conversation') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('support-ticket_index') }}"><i class="fa fa-list opacity-60 mr-2"></i>{{ __('My Tickets') }}</a></li>
           
            
            @endif 
            @if(Auth::user()->user_type == 'client')
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/employer/jobs') }}"><i class="dwg-briefcase opacity-60 mr-2"></i>{{ __('My Jobs') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/all/jobs') }}"><i class="dwg-briefcase opacity-60 mr-2"></i>{{ __('All Jobs') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/projects/dashboard') }}"><i class="dwg-list opacity-60 mr-2"></i>{{ __('Project Tracking') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/all/notification') }}"><i class="dwg-bell opacity-60 mr-2"></i>{{ __('Notifications') }} <span id="notificationBadge" class="badge badge-primary badge-pill ml-auto" style="display: none">0</span></a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/freelancers/search') }}"><i class="dwg-search opacity-60 mr-2"></i>{{ __('Freelancer Search') }}</a></li>
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/messages') }}"><i class="dwg-chat opacity-60 mr-2"></i>{{ __('Conversation') }}</a></li>       
            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('support-ticket_index') }}"><i class="fa fa-list opacity-60 mr-2"></i>{{ __('My Tickets') }}</a></li>
        
            @endif
             <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/logout') }}"><i class="dwg-sign-out opacity-60 mr-2"></i>{{ __('Logout') }}</a></li>
    </ul>
    </div>

    <div class="main">
        <div class="topbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0" style="color: #fff">Dashboard Panel</h5>
            <div><i class="bi bi-person-circle me-2"></i> {{auth()->user()->name}}</div>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            &copy; 2025 MyApp. All rights reserved.
        </div>
    </div>

</body>
</html>
