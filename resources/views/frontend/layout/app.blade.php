<!DOCTYPE html>
<html lang="en">
@php
$home_page_content = DB::table('home_page_contents')->first();
@endphp
<head>
    <meta charset="utf-8">
    {{-- <title>MemoryClick.com.bd - Photo Studio Website Template</title> --}}
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    @yield('seo')
    <title>@yield('title', 'memoryclick.com.bd')</title>

     <!-- Favicon -->
    <link rel="icon" href="{{ asset('fav.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('fav.png') }}" type="image/x-icon">

    @include('frontend.components.fixed.style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .whatsapp-float {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            background-color: #128C7E;
            transform: scale(1.1);
        }

        .whatsapp-icon {
            font-size: 36px;
        }
    </style>
    @stack('styles')

    <!-- Google Search Console -->
    @if(!empty($home_page_content->google_search_console_code))
        {!! $home_page_content->google_search_console_code !!}
    @endif

    <!-- Google Analytics (GTAG) -->
    @if(!empty($home_page_content->google_analytics_code))
        {!! $home_page_content->google_analytics_code !!}
    @elseif(!empty($home_page_content->google_analytics_id))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $home_page_content->google_analytics_id }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '{{ $home_page_content->google_analytics_id }}');
        </script>
    @endif

    <!-- Google / Meta Pixel -->
    @if(!empty($home_page_content->google_pixel_code))
        {!! $home_page_content->google_pixel_code !!}
    @elseif(!empty($home_page_content->google_pixel_id))
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '{{ $home_page_content->google_pixel_id }}');
          fbq('track', 'PageView');
        </script>
    @endif

    <!-- Custom Head Code -->
    @if(!empty($home_page_content->custom_head_code))
        {!! $home_page_content->custom_head_code !!}
    @endif
</head>

<body>
    <!-- Custom Body Code -->
    @if(!empty($home_page_content->custom_body_code))
        {!! $home_page_content->custom_body_code !!}
    @endif



    {{-- header --}}

    @include('frontend.components.fixed.header')


    {{-- main content --}}
    @yield('content')




      <!-- WhatsApp Button -->
<div class="whatsapp-button">
    <a href="https://wa.me/{{$home_page_content->phone ?? ''}}" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp whatsapp-icon"></i>
    </a>
</div>
    {{-- footer --}}

    @include('frontend.components.fixed.footer')

    {{-- script --}}
    @include('frontend.components.fixed.script')
    <script>
        // Optional: Add animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappButton = document.querySelector('.whatsapp-float');
            setTimeout(() => {
                whatsappButton.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    whatsappButton.style.transform = 'scale(1)';
                }, 300);
            }, 1000);
        });
    </script>
    @stack('scripts')
</body>

</html>
