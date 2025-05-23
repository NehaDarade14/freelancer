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
                                {{ isset($faq) ? __('Edit FAQ') : __('Create FAQ') }}
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ isset($faq) ? route('faqs.update', $faq->id) : route('faqs.store') }}">
                                    @csrf
                                    @if(isset($faq))
                                        @method('PUT')
                                    @endif

                                    <div class="form-group row">
                                        <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Question') }}</label>

                                        <div class="col-md-6">
                                            <input id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question', $faq->question ?? '') }}" required autocomplete="question" autofocus>

                                            @error('question')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="answer" class="col-md-4 col-form-label text-md-right">{{ __('Answer') }}</label>

                                        <div class="col-md-6">
                                            <textarea id="answer" class="form-control @error('answer') is-invalid @enderror" name="answer" rows="5" required>{{ old('answer', $faq->answer ?? '') }}</textarea>

                                            @error('answer')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                                        <div class="col-md-6">
                                            <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category', $faq->category ?? '') }}" required>

                                            @error('category')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="is_active" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                                        <div class="col-md-6">
                                            <select id="is_active" class="form-control @error('is_active') is-invalid @enderror" name="is_active" required>
                                                <option value="1" {{ old('is_active', $faq->is_active ?? '') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('is_active', $faq->is_active ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>

                                            @error('is_active')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ isset($faq) ? __('Update FAQ') : __('Create FAQ') }}
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