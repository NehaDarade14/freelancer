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
                            <div class="card-header">
                                {{ isset($supportTicket) ? __('Edit Ticket') : __('Create Ticket') }}
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ isset($supportTicket) ? route('support-tickets.update', $supportTicket->id) : route('support-tickets.store') }}">
                                    @csrf
                                    @if(isset($supportTicket))
                                        @method('PUT')
                                    @endif

                                    <div class="form-group row">
                                        <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject') }}</label>

                                        <div class="col-md-6">
                                            <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject', $supportTicket->subject ?? '') }}" required autocomplete="subject" autofocus>

                                            @error('subject')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="message" class="col-md-4 col-form-label text-md-right">{{ __('Message') }}</label>

                                        <div class="col-md-6">
                                            <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message" rows="5" required>{{ old('message', $supportTicket->message ?? '') }}</textarea>

                                            @error('message')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Priority') }}</label>

                                        <div class="col-md-6">
                                            <select id="priority" class="form-control @error('priority') is-invalid @enderror" name="priority" required>
                                                <option value="low" {{ old('priority', $supportTicket->priority ?? '') == 'low' ? 'selected' : '' }}>Low</option>
                                                <option value="medium" {{ old('priority', $supportTicket->priority ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="high" {{ old('priority', $supportTicket->priority ?? '') == 'high' ? 'selected' : '' }}>High</option>
                                            </select>

                                            @error('priority')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    @if(isset($supportTicket))
                                    <div class="form-group row">
                                        <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                                        <div class="col-md-6">
                                            <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                                <option value="open" {{ old('status', $supportTicket->status ?? '') == 'open' ? 'selected' : '' }}>Open</option>
                                                <option value="closed" {{ old('status', $supportTicket->status ?? '') == 'closed' ? 'selected' : '' }}>Closed</option>
                                            </select>

                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="admin_response" class="col-md-4 col-form-label text-md-right">{{ __('Admin Response') }}</label>

                                        <div class="col-md-6">
                                            <textarea id="admin_response" class="form-control @error('admin_response') is-invalid @enderror" name="admin_response" rows="5">{{ old('admin_response', $supportTicket->admin_response ?? '') }}</textarea>

                                            @error('admin_response')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ isset($supportTicket) ? __('Update Ticket') : __('Create Ticket') }}
                                            </button>
                                        </div>
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
    <!-- Right Panel -->
     </body>

</html>