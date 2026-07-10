@extends('frontend.layout.app')
@section('title', 'Checkout | Memory Click')
@section('content')

    <!-- breadcrump start -->
    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>Checkout</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('package') }}">Packages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrump end -->

    <!-- checkout start -->
    <div class="checkout_sec section_gap">
        <div class="container">
            <form id="paymentForm" method="POST" action="{{ route('pay.via.ajax') }}">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body p-4">
                                <h4 class="mb-4">Billing Details</h4>

                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="customer_name" class="form-control" required placeholder="Your full name" value="{{ old('name') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control" required placeholder="Your email address" value="{{ old('email') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="tel" name="phone" id="mobile" class="form-control" required placeholder="Your phone number" value="{{ old('phone') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                        <select name="country" id="country" class="form-control" required>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Address <span class="text-danger">*</span></label>
                                        <textarea name="address" id="address" class="form-control" rows="2" required placeholder="Your address">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <input type="text" name="city" id="city" class="form-control" required placeholder="City" value="{{ old('city') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state" class="form-control" placeholder="State/District" value="{{ old('state') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Postcode</label>
                                        <input type="text" name="postcode" class="form-control" placeholder="Postcode" value="{{ old('postcode') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-body p-4">
                                <h4 class="mb-4">Order Summary</h4>
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    {{-- <img src="{{ asset($package->image) }}" alt="{{ $package->package_name }}" class="rounded" style="width: 80px; height: 60px; object-fit: cover;"> --}}
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ $package->package_name }}</h6>
                                        <p class="mb-0 text-muted small">
                                            @php
                                                $people = array_filter([$package->chief, $package->photographer, $package->cinematographer]);
                                            @endphp
                                            {{ implode(' + ', $people) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Package Price</span>
                                    <span>TK. {{ number_format($package->price, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total</strong>
                                    <strong class="text-primary">TK. {{ number_format($package->price, 2) }}</strong>
                                </div>

                                <div class="mt-4">
                                    <p class="text-muted small mb-3">Pay securely with SSLCommerz</p>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                                        <img src="{{ asset('frontend/assets/img/sslcommerz.png') }}" alt="SSLCommerz" style="height: 22px; width: auto;">
                                        Pay Now - TK. {{ number_format($package->price, 2) }}
                                    </button>

                                    <div class="text-center mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-lock me-1"></i>
                                            Secured by SSLCommerz
                                        </small>
                                    </div>

                                    <hr>

                                    <a href="https://wa.me/{{$settings->phone ?? '880'}}" class="btn btn-outline-dark w-100" target="_blank">
                                        <i class="fab fa-whatsapp me-2"></i> Contact with us
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Package Features -->
                        <div class="card mt-3">
                            <div class="card-body p-4">
                                <h6>Package Features:</h6>
                                <ul class="mb-0 small">
                                    @foreach ($package->features as $feature)
                                        <li class="mb-1"><i class="fas fa-check-circle text-success me-1"></i> {{ $feature->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- checkout end -->
    <input type="hidden" id="total_amount" value="{{ $package->price }}">
@endsection

@push('scripts')
<style>
    .checkout_sec .card {
        border: 1px solid #e3e3e3;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
</style>
@endpush