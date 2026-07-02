@extends('backend.layout.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="mb-0">Testimonials</h4>
        <a href="{{ route('testimonial.create') }}" class="btn btn-primary">Add New</a>
    </div>

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Ratings</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($testimonials as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ Str::limit($item->description, 50) }}</td>
                        <td>{{ $item->rating }}/5</td>
                        <td>
                            <span class="badge bg-{{ $item->status ? '1' : '0' }}">
                                {{ $item->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('testimonial.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('testimonial.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No testimonials found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
