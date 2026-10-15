@php
    $logo = DB::table('home_page_contents')->first();
@endphp

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white border-bottom navbar-light sticky-top px-4 px-lg-5">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ $logo && $logo->image ? asset($logo->image) : asset('fav.png') }}" alt="MemoryClick Logo" style="height: 45px;">
        </a>

        <button type="button" class="navbar-toggler shadow-none p-2" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-align-right-icon lucide-align-right">
                <path d="M21 12H9" />
                <path d="M21 18H7" />
                <path d="M21 6H3" />
            </svg>
        </button>
        <div class="collapse navbar-collapse justify-content-between py-4 py-lg-0" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

                <a href="{{ route('about.page') }}" class="nav-item nav-link {{ request()->routeIs('about.page') ? 'active' : '' }}">About Us</a>

                <div class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle {{ request()->routeIs('photography.page') || request()->routeIs('cinematography.page') ? 'active' : '' }}"
                        data-bs-toggle="dropdown">Portfolio</a>
                    <div class="dropdown-menu rounded-0 shadow-sm border-0 m-0 py-2 dropdown-menu-end">
                        <a href="{{ route('photography.page') }}" class="dropdown-item py-2 {{ request()->routeIs('photography.page') ? 'active' : '' }}">Photography</a>
                        <a href="{{ route('cinematography.page') }}" class="dropdown-item py-2 {{ request()->routeIs('cinematography.page') ? 'active' : '' }}">Cinematography</a>
                    </div>
                </div>
                <a href="{{ route('package') }}" class="nav-item nav-link">Package</a>
                <a href="{{ route('blog.index') }}" class="nav-item nav-link {{ request()->routeIs('blog.index', 'blog.details') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('contactUs.page') }}" class="nav-item nav-link {{ request()->routeIs('contactUs.page') ? 'active' : '' }}">Contact Us</a>
                <a href="{{ route('term.page') }}" class="nav-item nav-link {{ request()->routeIs('term.page') ? 'active' : '' }}">Term</a>
            </div>
        </div>
    </div>
</nav>

<!-- mobile menu -->
<div class="mobile_menu d-block d-lg-none">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">MemoryClick</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <a href="{{route('home')}}" class="nav-item nav-link active">Home</a>
            <a href="{{route('about.page')}}" class="nav-item nav-link">About Us</a>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header nav-item nav-link">
                        <button class="accordion-button p-0 border-0 shadow-none collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                            aria-controls="collapseThree">
                            Protfolio
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse ps-4 border-bottom border-light"
                        data-bs-parent="#accordionExample">
                        <a href="{{route('photography.page')}}" class="dropdown-item py-2 small">Photography</a>
                        <a href="{{route('cinematography.page')}}" class="dropdown-item py-2 small">Cinematography</a>
                    </div>
                </div>
            </div>
            <a href="{{route('package')}}" class="nav-item nav-link">Package</a>
            <a href="{{route('blog.index')}}" class="nav-item nav-link {{ request()->routeIs('blog.index', 'blog.details') ? 'active' : '' }}">Blog</a>
            <a href="{{route('contactUs.page')}}" class="nav-item nav-link">Contact Us</a>
            <a href="{{route('term.page')}}" class="nav-item nav-link">Term</a>
        </div>
    </div>
</div>
<!-- Navbar End -->
