<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $allsettings->site_title }} - {{ __('FAQs') }}</title>
  @include('meta')
  @include('style')
  @if($addition_settings->site_google_recaptcha == 1)
    {!! RecaptchaV3::initJs() !!}
  @endif

  <!-- Custom Styles for a Modern, Sleek Look with Animations -->
  <style>
    /* General Fade In Animation */
    .fade-in {
      opacity: 0;
      animation: fadeIn 1s ease-in-out forwards;
    }
    @keyframes fadeIn {
      to { opacity: 1; }
    }

    /* Header Banner Section */
    section.bg-position-center-top {
      background-size: cover;
      background-position: center;
      position: relative;
    }
    section.bg-position-center-top::after {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 1;
    }
    section.bg-position-center-top .container {
      position: relative;
      z-index: 2;
    }

    /* Cards Hover Animation */
    .hover-animate {
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .hover-animate:hover {
      transform: scale(1.03);
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    /* FAQs Form Animation */
    #FAQs_form {
      animation: slideInUp 0.8s ease-out both;
    }
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Iframe Full Height */
    .iframe-full-height-wrap {
      position: relative;
      overflow: hidden;
      height: 100%;
    }
    .iframe-full-height {
      border: 0;
      width: 100%;
      height: 100%;
      min-height: 300px;
    }

    /* Footer Custom Styling */
    .footer-modern {
      background: {{ $allsettings->site_header_color }} !important;
      color: #ffffff;
    }
    .footer-modern a {
      color: #ffffff;
      transition: color 0.3s;
    }
    .footer-modern a:hover {
      color: #f1c40f;
      text-decoration: none;
    }
    /* Social Buttons */
    .social-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      background: rgba(255, 255, 255, 0.1);
      margin-right: 8px;
      transition: background 0.3s;
    }
    .social-btn:hover {
      background: rgba(255, 255, 255, 0.2);
    }
    /* Scroll-to-Top Button (Smooth & Animated) */
    .btn-scroll-top {
      position: fixed;
      bottom: 20px;
      right: 10px!important;
      background: #01c064;
      color: #ffffff;
      border-radius: 50%;
      padding: 10px 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: opacity 0.3s, visibility 0.3s, transform 0.3s, background 0.3s;
      z-index: 999;
      border: none;
      opacity: 0;
      visibility: hidden;
      transform: translateY(20px);
    }
    .btn-scroll-top.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .btn-scroll-top:hover {
      background: #ffffff;
      color: #01c064;
    }
    /* Cookie Alert */
    .cookiealert {
      background: #343a40;
      color: #ffffff;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 15px;
      z-index: 1050;
      text-align: center;
    }
    .input-group-text { border-radius: unset; }

    /* Increase spacing between footer widget links */
    .widget-list-item {
      margin-right: 20px;
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
      .social-btn {
        width: 35px;
        height: 35px;
        font-size: 16px;
        margin-right: 6px;
      }
      .btn-scroll-top {
        bottom: 15px;
        right: 10px;
        padding: 8px 10px;
      }
      .footer-modern { text-align: center; }
      /* Make iframe full height on mobile */
      .iframe-full-height {
        min-height: 250px;
      }
    }
  </style>
</head>
<body class="fade-in">
  @include('header')

  <!-- Banner Section with Background Image and Overlay -->
    <section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
        <div class="py-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                <li class="breadcrumb-item">
                    <a class="text-nowrap" href="{{ URL::to('/') }}">
                    <i class="dwg-home"></i>{{ __('Home') }}
                    </a>
                </li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('FAQs') }}</li>
                </ol>
            </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('FAQs') }}</h1>
            </div>
        </div>
        </div>
    </section>

    <section class="container pt-grid-gutter fade-in mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mb-4 mt-4 text-center">Frequently Asked Questions</h1>
                
                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $faq)
                    <div class="card mb-4">
                        <div class="card-header" id="heading{{ $faq->id }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{ $faq->id }}" class="collapse" aria-labelledby="heading{{ $faq->id }}" data-parent="#faqAccordion">
                            <div class="card-body">
                                {!! $faq->answer !!}
                                <div class="text-muted small mt-2">
                                    Category: {{ $faq->category }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @include('footer')
    @include('script')
</body>
</html>