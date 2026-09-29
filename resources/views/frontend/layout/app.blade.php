<!DOCTYPE html>
<html lang="en">
@php
$home_page_content = DB::table('home_page_contents')->first();
@endphp
<head>
    <meta charset="utf-8">
    {{-- <title>MemoryClick.com.bd - Photo Studio Website Template</title> --}}
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
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
</head>

<body>



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
