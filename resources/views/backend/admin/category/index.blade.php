@extends('backend.layout.app')

@section('content')
    <div class="container">
        <br>
        <h2 class="text-center">{{ $title }}</h2>
        <div class="text-end mb-3">
            <a href="{{ route('category.create') }}" class="btn btn-info">+ Add Category</a>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter table-mobile-md card-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="w-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ Str::limit($category->name, 20) }}</td>
                                    <td>
                                        <span class="badge text-white {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $category->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('category.edit', $category->slug) }}" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>
                                            @if (($category->name))
                                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        <x-backend.svg.notfound-svg />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .pagination {
            justify-content: center;
        }
    </style>
@endpush
