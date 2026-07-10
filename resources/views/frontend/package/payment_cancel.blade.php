@extends('frontend.layout.app')
@section('title', 'Payment Canceled | Memory Click')
@section('content')

    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>Payment Canceled</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment Canceled</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body p-5">
                            <div class="mb-4">
                                <i class="fas fa-ban text-warning" style="font-size: 80px;"></i>
                            </div>
                            <h3 class="text-warning mb-3">Payment Canceled</h3>
                            <p class="mb-4">You have canceled the payment. If you need any assistance, please contact us.</p>

                            <div class="mt-4">
                                <a href="{{ route('package') }}" class="btn btn-primary me-2">Browse Packages</a>
                                <a href="https://wa.me/{{ App\Models\HomePageContent::find(1)->phone ?? '880' }}" class="btn btn-dark" target="_blank">
                                    <i class="fab fa-whatsapp me-1"></i> Contact Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection