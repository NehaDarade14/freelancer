@if($addition_settings->subscription_mode == 0)
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('Profile Settings') }} @else {{ __('404 Not Found') }} @endif</title>
@include('meta')
@include('style')
</head>
<body>
   @include('header')
	@include('profile')
   @include('footer')
   @include('script')
</body>
</html>

@else
	@if(Auth::user()->user_type == 'vendor' || Auth::user()->user_type == 'customer')
      <!DOCTYPE HTML>
      <html lang="en">
      <head>
      <title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('Profile Settings') }} @else {{ __('404 Not Found') }} @endif</title>
      @include('meta')
      @include('style')
      </head>
      <body>
         @include('header')
         @include('profile')
         @include('footer')
         @include('script')
      </body>
      </html>

   @elseif(Auth::user()->user_type == 'freelancer')
     
         @include('freelancer-profile')
       
   @else
   <!DOCTYPE HTML>
      <html lang="en">
      <head>
      <title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('Profile Settings') }} @else {{ __('404 Not Found') }} @endif</title>
      @include('meta')
      @include('style')
      </head>
      <body>
         @include('header')
         @include('not-found')
         @include('footer')
         @include('script')
      </body>
      </html>        
   @endif
@endif
