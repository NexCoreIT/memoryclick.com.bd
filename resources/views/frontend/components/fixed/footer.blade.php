@php
    $links = DB::table('home_page_contents')->find(1);
@endphp

<!-- Footer Start -->
<div class="footer_sec bg-dark text-white border-top border-secondary py-4">
    <div class="container">
        <!-- Main Footer Content - Aligned Side by Side -->
        <div class="d-md-flex justify-content-center text-center justify-content-between align-items-center">

            <!-- Copyright -->
            <p class="mb-0">&copy; {{ date('Y') }} <a class="text-primary"
                    href="#">{{ $links->footer_title ?? 'memorylick.com' }}</a>. All Rights Reserved.</p>

            <!-- Social Media Links -->
            <div class="d-flex my-4 my-md-0 justify-content-center align-items-center">
                <a class="btn btn-square btn-outline-primary rounded-circle me-2"
                    href="{{ $links->facebook_link ?? '#' }}">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a class="btn btn-square btn-outline-primary rounded-circle me-2"
                    href="{{ $links->youtube_link ?? '#' }}">
                    <i class="fab fa-youtube"></i>
                </a>

                <a class="btn btn-square btn-outline-primary rounded-circle me-2"
                    href="{{ $links->instagram_link ?? '#' }}">
                    <i class="fab fa-instagram"></i>
                </a>

            </div>

            <!-- Developer Credit -->
            <p class="mb-0">Developed by <a class="text-primary" href="https://fastitcare.com.bd" target="_blank">Fast
                    IT Care</a></p>

        </div>
    </div>
</div>
<!-- Footer End -->
