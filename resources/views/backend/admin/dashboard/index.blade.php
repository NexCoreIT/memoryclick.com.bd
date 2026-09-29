@extends('backend.layout.app')

@push('styles')
    <style>
        .dashboard-card-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Top Counter Cards -->
            <div class="row row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">
                                    <a href="{{ route('photography.index') }}">PHOTOGRAPHY ({{ $total_photography }})</a>
                                </div>
                            </div>
                            <div class="h1 mb-0 mt-2">
                                <a href="{{ route('photography.index') }}">{{ $total_photography }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">
                                    <a href="{{ route('cinematographies.index') }}">CINEMATOGRAPHY ({{ $total_cinematography }})</a>
                                </div>
                            </div>
                            <div class="h1 mb-0 mt-2">
                                <a href="{{ route('cinematographies.index') }}">{{ $total_cinematography }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">
                                    <a href="{{ route('category.index') }}">CATEGORIES ({{ $total_categories }})</a>
                                </div>
                            </div>
                            <div class="h1 mb-0 mt-2">
                                <a href="{{ route('category.index') }}">{{ $total_categories }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">
                                    <a href="{{ route('user.list') }}">USERS ({{ $total_users }})</a>
                                </div>
                            </div>
                            <div class="h1 mb-0 mt-2">
                                <a href="{{ route('user.list') }}">{{ $total_users }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Photography Cards Grid -->
            <div class="row row-cards">
                @forelse ($row as $item)
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('photography.index') }}" class="d-block">
                                <img src="{{ $item->image ? asset($item->image) : asset('default.jpg') }}"
                                     class="card-img-top dashboard-card-img"
                                     alt="{{ $item->title }}">
                            </a>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h4 class="card-title mb-2">
                                        <a href="{{ route('photography.index') }}" class="text-reset">
                                            {{ Str::limit($item->title, 35) }}
                                        </a>
                                    </h4>
                                    @if(!empty($item->client_name))
                                        <div class="text-secondary small mb-1">{{ Str::limit($item->client_name, 25) }}</div>
                                    @endif
                                </div>
                                <div class="text-secondary small mt-2">
                                    {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <x-backend.svg.notfound-service-svg />
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
