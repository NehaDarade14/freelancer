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
                        <div class="breadcrumbs">
                            <div class="col-sm-4">
                                <div class="page-header float-left">
                                    <div class="page-title">
                                        <h1>{{ __('Manage FAQs') }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="page-header float-right">
                                    <div class="page-title">
                                        <ol class="breadcrumb text-right">
                                            <a href="{{ route('faqs.create') }}" class="btn btn-primary float-right">
                                                {{ __('Create FAQ') }}
                                            </a>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                {{ __('FAQs') }}
                                
                            </div>

                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Question</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($faqs as $faq)
                                            <tr>
                                                <td>{{ $faq->id }}</td>
                                                <td>{{ $faq->question }}</td>
                                                <td>{{ $faq->category }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $faq->is_active == 1 ? 'success' : 'danger' }}">
                                                        {{ $faq->is_active == 1 ? 'Active' : 'Inactive' }}
                                                    </span> 
                                                </td>
                                                <td>{{ $faq->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-sm btn-primary">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No FAQs found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                {{ $faqs->links() }}
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
    <!-- Right Panel -->
     </body>

</html>