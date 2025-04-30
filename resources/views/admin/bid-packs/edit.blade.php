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
                                        <h1>{{ __('Edit Bid Pack') }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{ __('Edit Bid Pack') }}</strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.bid-packs.update', $bidPack) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Package Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                            id="name" name="name" value="{{ old('name', $bidPack->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="bids_allowed" class="form-label">Bid Allowance</label>
                                        <input type="number" class="form-control @error('bids_allowed') is-invalid @enderror" 
                                            id="bids_allowed" name="bids_allowed" 
                                            value="{{ old('bids_allowed', $bidPack->bids_allowed) }}" min="1" required>
                                        @error('bids_allowed')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                            id="price" name="price" value="{{ old('price', $bidPack->price) }}" min="0" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="is_active" value="0">
    
                                        <input type="checkbox" class="form-check-input" 
                                            id="is_active" name="is_active" 
                                            value="1" 
                                            {{ old('is_active', $bidPack->is_active) == 1 ? 'checked' : '' }}>
                                        
                                        <label class="form-check-label" for="is_active">Is Active</label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="expiration_rules">Expiration Rules</label>
                                        <select name="expiration_rules" class="form-control" required>
                                            <option value="monthly" {{ old('expiration_rules', $bidPack->expiration_rules) == 'monthly' ? 'selected' : '' }}>Monthly Reset</option>
                                            <option value="unlimited" {{ old('expiration_rules', $bidPack->expiration_rules) == 'unlimited' ? 'selected' : '' }}>Never Expire</option>
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-primary">Update Bid Pack</button>
                                    <a href="{{ route('admin.bid-packs.index') }}" class="btn btn-secondary">Cancel</a>
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
    @include('admin.javascript')
    </body>

</html>