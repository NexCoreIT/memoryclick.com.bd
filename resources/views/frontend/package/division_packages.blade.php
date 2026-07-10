@extends('frontend.layout.app')
@section('title', $division->name ?? 'Packages | Memory Click')
@php
    $about_details = DB::table('home_page_contents')->find(1);
@endphp
@section('content')
    <!-- breadcrump start -->
    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>{{ $division->name }} Packages</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{ $division->name }} Packages</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrump end -->

    <!-- package start -->
    <div class="package_sec section_gap">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Packages For <strong>{{ $division->name }}</strong></h2>
            </div>
            <div class="row">


                <div class="col-lg-3 col-xl-2 border-end">
                    <div class="package_category">
                        <button
                            class="btn btn-default shadow-none active border-0 w-100 text-start bg-transparent filter-button"
                            data-filter="all">
                            All
                        </button>
                        @foreach ($categories as $key => $category)
                            <button class="btn btn-default shadow-none border-0 bg-transparent filter-button"
                                data-filter="cate_{{ $key }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-9 col-xl-10">
                    <div class="row gy-4">
                        @foreach ($categories as $key => $item)
                            @php
                                $packages = $packagesByCategory->get($item->id, collect());
                            @endphp
                            @if ($packages->isNotEmpty())
                                @foreach ($packages as $package)
                                    <div class="col-sm-6 col-xl-4 filter cate_{{ $key }}">
                                        <div class="package_list text-center h-100 border p-2 rounded shape-sm">
                                            <img src="{{ asset($package->image) }}" class="img-fluid mb-2 d-block rounded"
                                                alt="">
                                            <h4>{{ $package->package_name }}</h4>
                                            <p class="m-0">
                                                @php
                                                    $people = array_filter([
                                                        $package->chief,
                                                        $package->photographer,
                                                        $package->cinematographer,
                                                    ]);
                                                @endphp
                                                {{ implode(' + ', $people) }}
                                            </p>
                                            <div class="d-flex mt-4 align-items-center justify-content-between">
                                                <div><strong>TK. {{ $package->price }}</strong></div>
                                                <div>
                                                    <button class="btn btn-primary p-2 px-3 btn-sm viewPackageDetails"
                                                        data-id="{{ $package->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#packageDetails">
                                                        Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- package end -->

    <!-- Modal -->
    <div class="modal fade" id="packageDetails" tabindex="-1" aria-labelledby="packageDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="packageDetailsContent">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.viewPackageDetails').click(function() {
                var packageId = $(this).data('id');
                $.ajax({
                    url: "{{ route('package.details') }}",
                    type: "GET",
                    data: {
                        id: packageId
                    },
                    success: function(response) {
                        $('#packageDetailsContent').html(response);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#packageDetailsContent').html(
                            '<div class="p-4 text-center">Something went wrong. Please try again later.</div>'
                        );
                    }
                });
            });
        });
    </script>
@endpush
