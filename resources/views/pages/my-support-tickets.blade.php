@extends('layouts.main')

@section('content')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 style="display:inline-flex">My Support Tickets</h3>
                             <a class="btn btn-sm btn-primary" style="float:right" href="{{ route('support-ticket_create')  }}"><i class="fa fa-ticket opacity-60 mr-2"></i>{{ __('Raise ticket') }}</a>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->subject }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $ticket->status == 'open' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($ticket->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ 
                                                        $ticket->priority == 'high' ? 'danger' : 
                                                        ($ticket->priority == 'medium' ? 'warning' : 'info')
                                                    }}">
                                                        {{ ucfirst($ticket->priority) }}
                                                    </span>
                                                </td>
                                                <td>{{ $ticket->created_at->format('M d, Y H:i') }}</td>
                                                
                                                <td>
                                                <!-- Button to trigger modal -->
                                                 @if(!empty($ticket->admin_response))
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#responseModal{{ $ticket->id }}">
                                                    View Response
                                                </button>
                                                @endif
                                                <!-- Modal -->
                                                <div class="modal fade" id="responseModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="responseModalLabel{{ $ticket->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="responseModalLabel{{ $ticket->id }}">Admin Response</h5>
                                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $ticket->admin_response }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                {{ $tickets->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        


    @include('script')
 @endsection 