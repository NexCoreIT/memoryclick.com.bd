@extends('backend.layout.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="mb-0">Order Details</h4>
        <a href="{{ route('order.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="150">Name:</th>
                            <td>{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $order->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $order->address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->country }} - {{ $order->postcode }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="150">Transaction ID:</th>
                            <td><code>{{ $order->tran_id }}</code></td>
                        </tr>
                        <tr>
                            <th>Package:</th>
                            <td>{{ $order->package->package_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Amount:</th>
                            <td><strong>TK. {{ number_format($order->amount, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Currency:</th>
                            <td>{{ $order->currency }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($order->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-secondary">Canceled</span>
                                @else
                                    <span class="badge bg-info">{{ $order->status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($order->status == 'completed')
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0">Payment Details</h5>
        </div>
        <div class="card-body">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="200">Validation ID:</th>
                    <td>{{ $order->val_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Bank Transaction ID:</th>
                    <td>{{ $order->bank_tran_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Card Type:</th>
                    <td>{{ $order->card_type ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Card Number:</th>
                    <td>{{ $order->card_no ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Card Issuer:</th>
                    <td>{{ $order->card_issuer ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Card Brand:</th>
                    <td>{{ $order->card_brand ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Card Issuer Country:</th>
                    <td>{{ $order->card_issuer_country ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Currency Amount:</th>
                    <td>{{ $order->currency_amount ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Currency Rate:</th>
                    <td>{{ $order->currency_rate ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection