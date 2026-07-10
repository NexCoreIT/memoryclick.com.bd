@extends('frontend.layout.app')
@section('title', 'Payment Successful | Memory Click')
@section('content')

    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>Payment Successful</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment Successful</li>
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
                                <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                            </div>
                            <h3 class="text-success mb-3">Payment Successful!</h3>
                            <p class="mb-4">Your payment has been completed successfully. We will contact you shortly.</p>

                            <div class="text-start bg-light p-3 rounded mb-4">
                                <h6>Order Details:</h6>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td><strong>Transaction ID:</strong></td>
                                        <td>{{ $order->tran_id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Package:</strong></td>
                                        <td>{{ $order->package->package_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Amount:</strong></td>
                                        <td>TK. {{ number_format($order->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection