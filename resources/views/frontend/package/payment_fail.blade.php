@extends('frontend.layout.app')
@section('title', 'Payment Failed | Memory Click')
@section('content')

    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>Payment Failed</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment Failed</li>
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
                                <i class="fas fa-times-circle text-danger" style="font-size: 80px;"></i>
                            </div>
                            <h3 class="text-danger mb-3">Payment Failed!</h3>
                            <p class="mb-4">Unfortunately your payment could not be processed. Please try again or contact us.</p>

                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="mt-4">
                                <a href="{{ route('package') }}" class="btn btn-primary me-2">Try Again</a>
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