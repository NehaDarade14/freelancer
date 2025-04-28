<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
                <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Profile Settings') }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('Profile Settings') }}</h1>
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
            <!-- Step Progress -->
            
            <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                <h6 class="font-size-base text-light mb-0">{{ __('Update you profile details below') }}</h6>
                <a class="btn btn-primary btn-sm" href="{{ url('/logout') }}"><i class="dwg-sign-out mr-2"></i>{{ __('Logout') }}</a>
            </div>
            <div class="form-steps mb-4">
                <div class="form-step form-step-active" data-step="1">{{ __('Basic Info') }}</div>
                <div class="form-step" data-step="2">{{ __('Professional') }}</div>
                <div class="form-step" data-step="3">{{ __('Verification') }}</div>
                <div class="form-step" data-step="4">{{ __('Payment Setting') }}</div>
            </div>
            <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <form action="{{ route('freelancer-profile-settings') }}" class="needs-validation" id="profile_form" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <!-- Step 1: Basic Info -->
                <div class="step" id="step1">
                    <div class="row">
                        <!-- Name Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }} <span class="require">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="{{ __('Name') }}"
                                    value="{{ Auth::user()->name }}"
                                    data-bvalidator="required"
                                    data-bvalidator-msg="{{ __('Please enter your full name') }}" readonly="readonly">
                            </div>
                        </div>
                        <!-- Username Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="username">{{ __('Username') }} <span class="require">*</span></label>
                                <input type="text" id="username" name="username" class="form-control"
                                    placeholder="{{ __('Username') }}"
                                    value="{{ Auth::user()->username }}"
                                    data-bvalidator="required,alphanum,minlen[4],maxlen[20]"
                                    data-bvalidator-msg="{{ __('Username must be 4-20 alphanumeric characters') }}" readonly="readonly">
                            </div>
                        </div>
                        <!-- Email Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">{{ __('Email Address') }} <span class="require">*</span></label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="{{ __('Email Address') }}"
                                    value="{{ Auth::user()->email }}"
                                    data-bvalidator="required,email"
                                    data-bvalidator-msg="{{ __('Please enter a valid email address') }}" readonly="readonly">
                            </div>
                        </div>
                        <!-- Password Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <div class="password-toggle">
                                    <input type="password" id="password" name="password" class="form-control"
                                        data-bvalidator="minlen[8],regex[^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$]"
                                        data-bvalidator-msg="{{ __('Password must contain at least 8 characters with uppercase, lowercase, number and special character') }}"
                                        onkeyup="checkPasswordStrength(this.value)">
                                        <div class="password-strength-meter mt-2">
                                            <div class="strength-bar"></div>
                                            <small class="strength-text"></small>
                                        </div>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i class="dwg-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show password') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Confirm Password Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <div class="password-toggle">
                                    <input type="password" name="password_confirmation" id="password-confirm" class="form-control" data-bvalidator="equal[password]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <!-- Country Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="country">{{ __('Country') }} <span class="require">*</span></label>
                                <select name="country" id="country" class="form-control" data-bvalidator="required">
                                    <option value=""></option>
                                    @foreach($country['country'] as $country)
                                        <option value="{{ $country->country_id }}" @if(Auth::user()->country == $country->country_id ) selected="selected" @endif>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>       
                            </div>
                        </div>
                        <!-- Country Badge Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="country_badge">{{ __('Display Country Badge?') }} <span class="require">*</span></label>
                                <select name="country_badge" id="country_badge" class="form-control" data-bvalidator="required">
                                    <option value=""></option>
                                    <option value="1" @if(Auth::user()->country_badge == 1 ) selected="selected" @endif>{{ __('Yes') }}</option>
                                    <option value="0" @if(Auth::user()->country_badge == 0 ) selected="selected" @endif>{{ __('No') }}</option>
                                </select>       
                            </div>
                        </div>
                        <!-- Exclusive Author Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exclusive_author">{{ __('Exclusive Author?') }} <span class="require">*</span></label>
                                <select name="exclusive_author" id="exclusive_author" class="form-control" data-bvalidator="required">
                                    <option value=""></option>
                                    <option value="1" @if(Auth::user()->exclusive_author == 1 ) selected="selected" @endif>{{ __('Yes') }}</option>
                                    <option value="0" @if(Auth::user()->exclusive_author == 0 ) selected="selected" @endif>{{ __('No') }}</option>
                                </select>    
                                <small>({{ __('if selected') }} <strong>"{{ __('Yes') }}"</strong> {{ __('you will get high earning') }})</small>   
                            </div>
                        </div>
                        <!-- Profile Image Field -->
                        <div class="col-sm-6">
                            <div class="form-group pb-2">
                                <label for="user_photo">{{ __('Profile Image') }} (100x100 px)</label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" id="user_photo" name="user_photo"
                                        data-bvalidator="extension[jpg:png:jpeg]"
                                        data-bvalidator-msg="{{ __('Please upload an image (JPG/PNG) under 2MB') }}"
                                        onchange="validateImage(this, 'avatar-preview', 100, 100)">
                                    
                                    <label class="custom-file-label" for="user_photo"></label>
                                    @if(Auth::user()->user_photo != '')
                                    <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->user_photo }}"  alt="{{ Auth::user()->name }}">
                                    @else
                                    <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/img/no-image.png"  alt="{{ Auth::user()->name }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Cover Image Field -->
                        <div class="col-sm-6">
                            <div class="form-group pb-2">
                                <label for="user_banner">{{ __('Cover Image') }} (750x370 px)</label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" id="user_banner" name="user_banner" data-bvalidator="extension[jpg:png:jpeg]" data-bvalidator-msg="{{ __('Please select file of type .jpg, .png or .jpeg') }}">
                                    <label class="custom-file-label" for="user_banner"></label>
                                    @if(Auth::user()->user_banner != '')
                                    <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->user_banner }}"  alt="{{ Auth::user()->name }}">
                                    @else
                                    <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/img/no-image.png"  alt="{{ Auth::user()->name }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Professional -->
                <div class="step" id="step2" style="display:none;">
                    <!-- Add Professional Information Form Fields Here -->
                    <div class="row">
                        <div class="col-sm-12 mb-1">
                            <h4>{{ __('Professional Information') }}</h4>
                        </div>
                    

                        <!-- Skills -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="skills">{{ __('Skills') }} <span class="require">*</span></label>
                                <input type="text" name="skills" id="skills" class="form-control" placeholder="{{ __('Your Skills') }}" value="{{ Auth::user()->skills }}" data-bvalidator="required">
                            </div>
                        </div>  

                        <!-- Experience -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="experience">{{ __('Experience (Years)') }} <span class="require">*</span></label>
                                <input type="number" name="experience" id="experience" class="form-control" placeholder="{{ __('Experience in Years') }}" value="{{ Auth::user()->experience }}" data-bvalidator="required">
                            </div>
                        </div>  
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-1">
                            <h4>{{ __('Portfolio & Bio') }}</h4>
                        </div>

                        <!-- Social Media Links -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="facebook_url">{{ __('Facebook URL') }}</label>
                                <input type="url" name="facebook_url" id="facebook_url" class="form-control" placeholder="{{ __('Facebook URL') }}" value="{{ Auth::user()->facebook_url }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="twitter_url">{{ __('Twitter URL') }}</label>
                                <input type="url" name="twitter_url" id="twitter_url" class="form-control" placeholder="{{ __('Twitter URL') }}" value="{{ Auth::user()->twitter_url }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="instagram_url">{{ __('Instagram URL') }}</label>
                                <input type="url" name="instagram_url" id="instagram_url" class="form-control" placeholder="{{ __('Instagram URL') }}" value="{{ Auth::user()->instagram_url }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="linkedin_url">{{ __('LinkedIn URL') }}</label>
                                <input type="url" name="linkedin_url" id="linkedin_url" class="form-control" placeholder="{{ __('LinkedIn URL') }}" value="{{ Auth::user()->linkedin_url }}">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pinterest_url">{{ __('Pinterest URL') }}</label>
                                <input type="url" name="pinterest_url" id="pinterest_url" class="form-control" placeholder="{{ __('Pinterest URL') }}" value="{{ Auth::user()->pinterest_url }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="github_url">{{ __('GitHub URL') }}</label>
                                <input type="url" name="github_url" id="github_url" class="form-control" placeholder="{{ __('GitHub URL') }}" value="{{ Auth::user()->github_url }}">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="other">{{ __('Other') }}</label>
                                <input type="url" name="other" id="other" class="form-control" placeholder="{{ __('Other URL') }}" value="{{ Auth::user()->github_url }}">
                            </div>
                        </div>
                        <!-- Professional Bio -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="professional_bio">{{ __('Professional Bio') }} <span class="require">*</span></label>
                                <textarea name="professional_bio" id="professional_bio" class="form-control" placeholder="{{ __('Short bio about your professional background...') }}" data-bvalidator="required">{{ Auth::user()->professional_bio }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Verification -->
                <div class="step" id="step3" style="display:none;">
                    <div class="row">
                        <div class="col-sm-12 mb-1">
                            <h4>{{ __('KYC Verification') }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="government_id" class="form-label">Government ID 
                                <span class="text-danger">*</span>
                            </label>
                            @php
                                if(Auth::user()->government_id == '') 
                                    $govbvalidate = 'data-bvalidator="required"'; 
                                else 
                                    $govbvalidate = 'data-bvalidator=""'; 
                            @endphp
                            <input type="file" class="form-control" id="government_id" name="government_id" accept=".pdf,.jpg,.jpeg,.png" {{ $govbvalidate }}>                      
                            
                            <small class="form-text text-muted">Upload a clear scan of your government-issued ID</small>
                            @if(Auth::user()->government_id != '')
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->government_id }}" alt="{{ Auth::user()->name }}">
                            @else
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/img/no-image.png" alt="{{ Auth::user()->name }}">
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="address_proof" class="form-label">Address Proof 
                                <span class="text-danger">*</span>
                            </label>
                            @php
                                if(Auth::user()->government_id == '') 
                                    $addpbvalidate = 'data-bvalidator="required"'; 
                                else 
                                    $addpbvalidate = 'data-bvalidator=""'; 
                            @endphp
                            <input type="file" class="form-control" id="address_proof" name="address_proof" accept=".pdf,.jpg,.jpeg,.png" {{$addpbvalidate}} >
                               
                            <small class="form-text text-muted">Recent utility bill or bank statement</small>
                            @if(Auth::user()->address_proof != '')
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->address_proof }}" alt="{{ Auth::user()->name }}">
                            @else
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/img/no-image.png" alt="{{ Auth::user()->name }}">
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="biometric_photo" class="form-label">Biometric Photo 
                                <span class="text-danger">*</span>
                            </label>
                            @php
                                if(Auth::user()->government_id == '') 
                                    $biopbvalidate = 'data-bvalidator="required"'; 
                                else 
                                    $biopbvalidate = 'data-bvalidator=""'; 
                            @endphp
                            <input type="file" class="form-control" id="biometric_photo" name="biometric_photo" accept=".jpg,.jpeg,.png" {{$biopbvalidate}}>
                            <small class="form-text text-muted">Recent passport-style photo</small>
                            @if(Auth::user()->biometric_photo != '')
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->biometric_photo }}" alt="{{ Auth::user()->name }}">
                            @else
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/img/no-image.png" alt="{{ Auth::user()->name }}">
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="signature_data" class="form-label">Signature Photo 
                                <span class="text-danger">*</span>
                            </label>
                            @php
                                if(Auth::user()->government_id == '') 
                                    $signbvalidate = 'data-bvalidator="required"'; 
                                else 
                                    $signbvalidate = 'data-bvalidator=""'; 
                            @endphp
                            <input type="file" class="form-control" id="signature_data" name="signature_data" accept=".jpg,.jpeg,.png" {{$signbvalidate}} >
                                
                            <small class="form-text text-muted">Signature photo</small>
                            @if(Auth::user()->signature_data != '')
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->signature_data }}" alt="{{ Auth::user()->name }}">
                            @else
                                <img class="lazy" width="50" height="50" src="{{ url('/') }}/public/img/no-image.png" alt="{{ Auth::user()->name }}">
                            @endif
                        </div>
                    </div>
                </div>


                <!-- Step 4: Verification -->
                <div class="step" id="step4" style="display:none;">
                    <div class="row">
                        <div class="col-sm-12 mb-1">
                            <h4>{{ __('Payment Settings') }}</h4>
                            <h5 class="mt-4">{{ __('Paypal Settings') }}</h5>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="account-email">{{ __('Paypal Email ID') }}</label>
                            <input type="text" class="form-control" name="user_paypal_email" value="{{ Auth::user()->user_paypal_email }}"  data-bvalidator="email"
                            data-bvalidator-msg="{{ __('Please enter a valid email address') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="account-email">{{ __('Paypal Mode') }} <span class="require">*</span></label>
                            <select name="user_paypal_mode" id="user_paypal_mode" class="form-control" data-bvalidator="required">
                                <option value=""></option>
                                <option value="1" @if(Auth::user()->user_paypal_mode == 1 ) selected="selected" @endif>{{ __('Live') }}</option>
                                <option value="0" @if(Auth::user()->user_paypal_mode == 0 ) selected="selected" @endif>{{ __('Demo') }}</option>
                            </select>
                            </div>
                        </div> 
                    </div>
                </div>

                <!-- Step Navigation -->
                <div class="form-navigation d-flex justify-content-between">
                    <input type="hidden" name="user_token" value="{{ Auth::user()->user_token }}">
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="save_earnings" value="{{ Auth::user()->earnings }}">
                    <input type="hidden" name="save_photo" value="{{ Auth::user()->user_photo }}">
                    <input type="hidden" name="save_banner" value="{{ Auth::user()->user_banner }}">                
                    <input type="hidden" name="save_government_id" value="{{ Auth::user()->government_id }}">
                    <input type="hidden" name="save_address_proof" value="{{ Auth::user()->address_proof }}">
                    <input type="hidden" name="save_biometric_photo" value="{{ Auth::user()->biometric_photo }}">
                    <input type="hidden" name="save_signature_data" value="{{ Auth::user()->signature_data }}">
                    <input type="hidden" name="save_password" value="{{ Auth::user()->password }}">
                    <input type="hidden" name="save_auth_token" value="{{ Auth::user()->user_auth_token }}">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="moveStep(-1)">{{ __('Previous') }}</button>
                    <div>
                        <button type="button" class="btn btn-primary" id="nextBtn" onclick="moveStep(1)">{{ __('Next') }}</button>
                        <button type="submit" class="btn btn-success d-none" id="submitBtn">{{ __('Save Profile') }}</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>


<style>
    .progress-bar {
        background-color:green;
    }
        .form-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }   
        .form-step {
            flex: 1;
            text-align: center;
            padding: 0.5rem;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #6c757d;
        }
        .form-step-active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .step { display: none; }
        .step.active { display: block; }
        .avatar-preview, .cover-preview {
            width: 50%;
            height: 100px;
            background-size: cover;
            background-position: center;
            border: 2px dashed #ddd;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Password Strength Meter */
        .password-strength-meter {
            height: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        
        .bg-danger { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; }
        .bg-info { background-color: #17a2b8; }
        .bg-success { background-color: #28a745; }
        
        .strength-text {
            display: block;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        
        /* Validation Error Styles */
        .invalid-feedback {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .is-valid {
            border-color: #28a745 !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    .avatar-preview img, .cover-preview img {
        max-height: 100%;
        max-width: 100%;
    }

    /* Signature canvas responsive */
    #signature-pad {
        width: 100%;
        height: 100px;
        border: 1px solid #ddd;
        background: white;
        cursor: crosshair;
    }
    </style>
<script>

  let currentStep = 1;
  const totalSteps = 4;

  function showStep(step) {
  // Hide all steps
  for (let i = 1; i <= totalSteps; i++) {
    document.getElementById('step' + i).style.display = 'none';
  }
  // Show the selected step
  document.getElementById('step' + step).style.display = 'block';

  // Update the form progress
  const progressBar = document.querySelector('.progress-bar');
  progressBar.style.width = (step / totalSteps) * 100 + '%';

  // Toggle button visibility
  document.getElementById('prevBtn').style.display = (step === 1) ? 'none' : 'inline-block';
  document.getElementById('nextBtn').style.display = (step === totalSteps) ? 'none' : 'inline-block';
  document.getElementById('submitBtn').classList.toggle('d-none', step !== totalSteps);

  // === NEW CODE: Update form-step-active class ===
  document.querySelectorAll('.form-step').forEach(function(stepElement) {
    stepElement.classList.remove('form-step-active');
    if (parseInt(stepElement.getAttribute('data-step')) === step) {
      stepElement.classList.add('form-step-active');
    }
  });
}


  function validateStep(step) {
    let isValid = true;
    // Validate all fields in current step
    $('#step' + step + ' [data-bvalidator]').each(function() {
        if (!$(this).bValidator('validate')) {
            isValid = false;
        }
    });
    return isValid;
  }

  function moveStep(stepChange) {
    if (stepChange > 0 && !validateStep(currentStep)) {
        return false;
    }
    const nextStep = currentStep + stepChange;
    if (nextStep >= 1 && nextStep <= totalSteps) {
      currentStep = nextStep;
      showStep(currentStep);
    }
  }

  // Initialize the form to show the first step
  showStep(currentStep);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize bValidator with custom configuration
        $('#profile-form').bValidator({
            errorTemplate: '<div class="invalid-feedback d-block">{message}</div>',
            successClass: 'is-valid',
            errorClass: 'is-invalid',
            validateOnSubmit: true,
            customValidators: {
                maxsize: function(el, value) {
                    if (el.files && el.files[0]) {
                        return el.files[0].size <= (parseInt(value) * 1024 * 1024);
                    }
                    return true;
                },
                regex: function(el, regex) {
                    return new RegExp(regex).test($(el).val());
                }
            }
        });

        // Real-time validation on input
        $('input, select, textarea').on('blur input', function() {
            $(this).bValidator('validate');
        });

        // Optional: Handle password visibility toggle
        $(".password-toggle-btn").on("click", function() {
            let passwordField = $(this).siblings("input");
            let isPasswordVisible = passwordField.attr("type") === "text";
            passwordField.attr("type", isPasswordVisible ? "password" : "text");
        });
    });

    function checkPasswordStrength(password) {
        const strengthMeter = document.querySelector('.password-strength-meter');
        const strengthBar = strengthMeter.querySelector('.strength-bar');
        const strengthText = strengthMeter.querySelector('.strength-text');
        
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[\W_]/.test(password)) strength++;
        
        const width = (strength/5)*100;
        strengthBar.style.width = width + '%';
        strengthBar.className = `strength-bar ${getStrengthClass(strength)}`;
        strengthText.textContent = getStrengthText(strength);
    }

    function getStrengthClass(strength) {
        return ['bg-danger', 'bg-danger', 'bg-warning', 'bg-info', 'bg-success'][strength] || 'bg-danger';
    }

    function getStrengthText(strength) {
        return ['Very Weak', 'Weak', 'Moderate', 'Strong', 'Very Strong'][strength] || 'Very Weak';
    }

    function validateImage(input, previewId, maxWidth, maxHeight) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    if (this.width > maxWidth || this.height > maxHeight) {
                        alert(`{{ __('Image dimensions must be exactly') }} ${maxWidth}x${maxHeight}px`);
                        input.value = '';
                        preview.innerHTML = '';
                    } else {
                        preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail">`;
                    }
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    
</script>