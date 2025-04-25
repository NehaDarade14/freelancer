<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - {{ __('Register') }}</title>
@include('meta')
@include('style')
@if($addition_settings->site_google_recaptcha == 1)
{!! RecaptchaV3::initJs() !!}
@endif
</head>
<body>
@include('header')
<section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
      <div class="py-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Register') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Register') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div class="container py-4 py-lg-5 my-4">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card border-0 box-shadow">
            <div class="card-body">
              <h2 class="h4 mb-3"><strong>{{ __('Create Your Account') }}</strong></h2>
              <p class="font-size-sm text-muted mb-4">{{ __('Please fill the following fields with appropriate information to register a new Marketplace account.') }}</p>
              <form method="POST" action="{{ route('register') }}" id="login_form" class="needs-validation" novalidate>
                @csrf
                <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-fn"><strong>{{ __('Your Name') }}</strong> <span class="required">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="dwg-user"></i></span></div>
                    <input id="name" type="text" class="form-control" name="name" placeholder="{{ __('Enter your name') }}" value="{{ old('name') }}" data-bvalidator="required" autocomplete="name" autofocus>
                  </div>
                  @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-ln"><strong>{{ __('Username') }}</strong> <span class="required">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="dwg-user"></i></span></div>
                    <input id="username" type="text" name="username" class="form-control" placeholder="{{ __('Enter your username') }}" data-bvalidator="required">
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-email"><strong>{{ __('E-Mail Address') }}</strong> <span class="required">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="dwg-mail"></i></span></div>
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your email address') }}"  autocomplete="email" data-bvalidator="email,required">
                  </div>
                  @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-pass"><strong>{{ __('Password') }}</strong> <span class="required">*</span></label>
                  <div class="input-group password-toggle">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="dwg-locked"></i></span></div>
                    <!-- <input id="password" type="password" class="form-control" name="password" placeholder="{{ __('Enter your password') }}" autocomplete="new-password" data-bvalidator="required,minlen[8]"> -->
                    <input id="password" type="password" class="form-control" name="password"  placeholder="{{ __('Enter your password') }}" autocomplete="new-password"  required minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$" title="Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, and one number.">

                    <label class="password-toggle-btn">
                      <input class="custom-control-input" type="checkbox">
                      <i class="dwg-eye password-toggle-indicator"></i>
                      <span class="sr-only">{{ __('Show password') }}</span>
                    </label>
                  </div>
                  <small id="password-strength-text" class="form-text text-muted mt-1"></small>
                    <div id="password-strength-bar" class="progress mt-1" style="height: 5px;">
                      <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

               
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-confirm-pass"><strong>{{ __('Confirm Password') }}</strong> <span class="required">*</span></label>
                  <div class="input-group password-toggle">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="dwg-locked"></i></span>
                    </div>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Enter your confirm password') }}" data-bvalidator="equal[password],required,minlen[6]" autocomplete="new-password">
                    <label class="password-toggle-btn">
                      <input class="custom-control-input" type="checkbox"><i class="dwg-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show password') }}</span>
                    </label>
                  </div>
                </div>

              </div>

              <!-- <div class="col-sm-6">
               <div class="form-group">
                <label for="email_ad">{{ __('User Type') }} <span class="required">*</span></label>
                 <select id="user_type" class="form-control" name="user_type" data-bvalidator="required">
                 <option value=""></option>
                 <option value="{{ $encrypter->encrypt('customer') }}">{{ __('Customer') }}</option>
                 <option value="{{ $encrypter->encrypt('vendor') }}">{{ __('Vendor') }}</option>
                </select>
                </div>
             </div> -->
            

              <div class="col-sm-12">
                <div class="form-group">
                  <label class="d-block"><strong>{{ __('User Type') }}</strong> <span class="required">*</span></label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="user_type[]" id="customer" value="{{ $encrypter->encrypt('customer') }}" data-bvalidator="required" />
                    <label class="form-check-label" for="customer">{{ __('Customer') }}</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="user_type[]" id="vendor" value="{{ $encrypter->encrypt('vendor') }}" />
                    <label class="form-check-label" for="vendor">{{ __('Vendor') }}</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="user_type[]" id="freelancer" value="{{ $encrypter->encrypt('freelancer') }}" />
                    <label class="form-check-label" for="freelancer">{{ __('Freelancer') }}</label>
                  </div>
                </div>
              </div>


              @if($addition_settings->site_google_recaptcha == 1)
              <div class="col-sm-12">
              <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                {!! RecaptchaV3::field('register') !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
              </div>
              @endif
              <div class="col-sm-12">
                <div class="form-group">
                  <input  type="checkbox" name="register_rules" id="ch2" value="1" data-bvalidator="required">
                  <span class="become_vendor">{{ __('I agree to the') }} <a href="{{ URL::to('/terms-and-conditions') }}">{{ __('terms & conditions') }}</a>, <a href="{{ URL::to('/privacy-policy') }}">{{ __('privacy policy') }}</a> {{ __('and') }} <a href="{{ URL::to('/subscription') }}">{{ __('membership terms') }}</a></span>
                </div>
              </div>
              <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                  <div class="custom-checkbox d-block">
                    <a href="{{ URL::to('/login') }}" class="nav-link-inline font-size-sm">{{ __('Already have an account?') }} {{ __('Login') }}</a>
                  </div>
                  <button class="btn btn-primary mt-3 mt-sm-0" type="submit">{{ __('Register') }}</button>
                </div> 
              </div>
            </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@include('footer')
@include('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
  const passwordInput = document.getElementById("password");
  const strengthBar = document.querySelector("#password-strength-bar .progress-bar");
  const strengthText = document.getElementById("password-strength-text");

  passwordInput.addEventListener("input", function () {
    const password = passwordInput.value;
    let strength = 0;

    // Criteria
    if (password.length >= 6) strength += 1;
    if (password.match(/[a-z]/)) strength += 1;
    if (password.match(/[A-Z]/)) strength += 1;
    if (password.match(/[0-9]/)) strength += 1;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 1;

    // Update UI
    let width = strength * 20;
    let color = 'danger';
    let message = 'Too weak';

    if (strength >= 1) { color = 'danger'; message = 'Very Weak'; }
    if (strength >= 2) { color = 'warning'; message = 'Weak'; }
    if (strength >= 3) { color = 'info'; message = 'Moderate'; }
    if (strength >= 4) { color = 'primary'; message = 'Strong'; }
    if (strength >= 5) { color = 'success'; message = 'Very Strong'; }

    strengthBar.style.width = width + '%';
    strengthBar.className = 'progress-bar bg-' + color;
    strengthBar.setAttribute('aria-valuenow', width);
    strengthText.textContent = message;
  });
});
</script>

</body>
</html>