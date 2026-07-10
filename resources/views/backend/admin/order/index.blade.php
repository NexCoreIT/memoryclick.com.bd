@extends('backend.layout.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="mb-0">Orders</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction ID</th>
                        <th>Customer</th>
                        <th>Package</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $key => $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $key }}</td>
                        <td><code>{{ $order->tran_id }}</code></td>
                        <td>
                            <strong>{{ $order->name }}</strong><br>
                            <small class="text-muted">{{ $order->phone }}<br>{{ $order->email }}</small>
                        </td>
                        <td>{{ $order->package->package_name ?? 'N/A' }}</td>
                        <td>TK. {{ number_format($order->amount, 2) }}</td>
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
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                            <form action="{{ route('order.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection