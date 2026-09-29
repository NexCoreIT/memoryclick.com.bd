@php
    $settings = DB::table('home_page_contents')->find(1)
@endphp

<div class="modal-header">
    <h1 class="modal-title fs-5" id="packageDetailsLabel">{{ $package->package_name }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body text-center">

    <h5>{{ $package->package_name }}</h5>

    <p>
        @php
            $people = array_filter([$package->chief, $package->photographer, $package->cinematographer]);
        @endphp
        {{ implode(' + ', $people) }}
    </p>

    <ul>
        @foreach ($package->features as $feature)
            <li>* {{ $feature->name }}</li>
        @endforeach
    </ul>

    <h6 class="mt-4">For outside of Dhaka & Chittagong metropolitan area</h6>
    <p>Transportation + Accommodation & 15% shift charge (Package Price) will be added with package price.</p>


@if ($package->description)
  <div class="package-description">
    {!! $package->description ?? '' !!}
</div>
@endif



</div>
<div class="d-flex border-top p-3 mt-3 align-items-center justify-content-between">
    <div>
        <h4>{{ $package->price }} TK</h4>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <a href="https://wa.me/{{$settings->phone}}" class="btn btn-sm btn-dark" target="_blank">Contact with us</a>
        @if(!isset($settings->ssl_status) || $settings->ssl_status == 1)
            <a href="{{ route('checkout', ['package_id' => $package->id]) }}" class="btn btn-sm btn-success d-flex align-items-center gap-1">
                <img src="{{ asset('frontend/assets/img/sslcommerz.png') }}" alt="SSLCommerz" style="height: 20px; width: auto;">
                Checkout
            </a>
        @endif
    </div>
</div>


<style>
    /* Style all tables in package description */
.package-description table {
  width: 100%; /* Full width */
  border-collapse: collapse; /* Collapse borders */
  margin-bottom: 1rem; /* Space below table */
  font-family: Arial, sans-serif;
  font-size: 14px;
}

/* Table borders */
.package-description table,
.package-description th,
.package-description td {
  border: 1px solid #ddd;
}

/* Table header styling */
.package-description th {
  background-color: #f2f2f2;
  font-weight: bold;
  padding: 8px;
  text-align: left;
}

/* Table cell padding */
.package-description td {
  padding: 8px;
}

/* Zebra striping for rows */
/* .package-description tr:nth-child(even) {
  background-color: #fafafa;
} */

/* Hover effect on rows */
.package-description tr:hover {
  background-color: #f1f1f1;
}

</style>

