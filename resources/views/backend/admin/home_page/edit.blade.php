@extends('backend.layout.app')

@section('content')
    <div class="container">
        <br>
        <h2 style="text-align: center">{{ $title }}</h2>
        <br><br>
        <div class="col-12">
            <form action="{{ route('home.page.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header border-bottom-0 pb-0">
                        <h3 class="card-title mb-3 fw-bold">General Settings</h3>
                    </div>
                    <div class="card-header pt-0">
                        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-general" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                                    <i class="ti ti-settings me-2"></i> General
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-stats" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ti ti-chart-bar me-2"></i> Statistics
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-contact" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ti ti-address-book me-2"></i> Contact & Social
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-payment" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ti ti-credit-card me-2"></i> Payment (SSL)
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-tracking" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ti ti-brand-google-analytics me-2"></i> Tracking & SEO
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Tab: General -->
                            <div class="tab-pane active show" id="tabs-general" role="tabpanel">
                                <h4 class="text-primary fw-bold mb-3">Homepage Setup</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Client Reviews Title</label>
                                        <input type="text" name="homepage_title" class="form-control" placeholder="Homepage Title"
                                            value="{{ old('homepage_title', $item->homepage_title) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Logo</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                <hr class="my-4">
                                <h4 class="text-primary fw-bold mb-3">Section Titles</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Services Subtitle</label>
                                        <input type="text" name="service_subtitle" class="form-control" placeholder="e.g. Our Services"
                                            value="{{ old('service_subtitle', $item->service_subtitle) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Services Title</label>
                                        <input type="text" name="service_title" class="form-control" placeholder="e.g. Our Top Services"
                                            value="{{ old('service_title', $item->service_title) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Recent Work Subtitle</label>
                                        <input type="text" name="recent_work_subtitle" class="form-control" placeholder="e.g. Recent Work"
                                            value="{{ old('recent_work_subtitle', $item->recent_work_subtitle) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Recent Work Title</label>
                                        <input type="text" name="recent_work_title" class="form-control" placeholder="e.g. Our recent stunning wedding photography"
                                            value="{{ old('recent_work_title', $item->recent_work_title) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Cinematography Subtitle</label>
                                        <input type="text" name="cinematography_subtitle" class="form-control" placeholder="e.g. Cinematography"
                                            value="{{ old('cinematography_subtitle', $item->cinematography_subtitle) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Cinematography Title</label>
                                        <input type="text" name="cinematography_title" class="form-control" placeholder="e.g. Take a peek at our recent stunning wedding photography"
                                            value="{{ old('cinematography_title', $item->cinematography_title) }}">
                                    </div>
                                </div>
                                <hr class="my-4">
                                <h4 class="text-primary fw-bold mb-3">About Section (Home)</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">About Title</label>
                                        <input type="text" name="about_title" class="form-control" placeholder="About Title"
                                            value="{{ old('about_title', $item->about_title) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">About Button Text</label>
                                        <input type="text" name="about_btn" class="form-control" placeholder="About Button Text"
                                            value="{{ old('about_btn', $item->about_btn) }}" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">About Content</label>
                                        <textarea name="about_content" class="form-control" rows="3" placeholder="About Content"
                                            required>{{ old('about_content', $item->about_content) }}</textarea>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <h4 class="text-primary fw-bold mb-3">Footer Section</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Footer Copyright</label>
                                        <input type="text" name="footer_title" class="form-control" placeholder="Footer Copyright"
                                            value="{{ old('footer_title', $item->footer_title) }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab: Statistics -->
                            <div class="tab-pane" id="tabs-stats" role="tabpanel">
                                <h4 class="text-primary fw-bold mb-3">Statistics Counter Section</h4>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Since Year</label>
                                        <input type="text" name="since_year" class="form-control" placeholder="e.g. 2014"
                                            value="{{ old('since_year', $item->since_year) }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Events Count</label>
                                        <input type="text" name="events_count" class="form-control" placeholder="e.g. 3000"
                                            value="{{ old('events_count', $item->events_count) }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Photos Count</label>
                                        <input type="text" name="photos_count" class="form-control" placeholder="e.g. 1000"
                                            value="{{ old('photos_count', $item->photos_count) }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Clients Count</label>
                                        <input type="text" name="clients_count" class="form-control" placeholder="e.g. 999"
                                            value="{{ old('clients_count', $item->clients_count) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab: Contact & Social -->
                            <div class="tab-pane" id="tabs-contact" role="tabpanel">
                                <h4 class="text-primary fw-bold mb-3">Contact Information</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" placeholder="Enter Address"
                                            value="{{ old('address', $item->address) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                            value="{{ old('email', $item->email) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" name="phone" class="form-control" placeholder="Phone"
                                            value="{{ old('phone', $item->phone) }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Google Maps Embed Code / URL</label>
                                        <textarea name="google_map" class="form-control" rows="3" placeholder="Paste Google Maps <iframe> embed code or embed URL here">{{ old('google_map', $item->google_map) }}</textarea>
                                        <small class="text-muted d-block mt-1">Paste the full Google Maps &lt;iframe ...&gt;&lt;/iframe&gt; embed code or the embed URL (from Google Maps &gt; Share &gt; Embed a map).</small>
                                        @if(!empty($item->google_map))
                                            <div class="mt-3">
                                                <label class="form-label fw-semibold text-muted small">Current Map Preview:</label>
                                                <div class="border rounded overflow-hidden" style="max-width: 600px; height: 220px; background: #f8f9fa;">
                                                    @php
                                                        $previewMap = $item->google_map;
                                                        if (preg_match('/src=["\']([^"\']+)["\']/', $previewMap, $matches)) {
                                                            $previewMap = $matches[1];
                                                        }
                                                    @endphp
                                                    @if(filter_var($previewMap, FILTER_VALIDATE_URL) || \Illuminate\Support\Str::startsWith($previewMap, ['http://', 'https://', '//']))
                                                        <iframe src="{{ $previewMap }}" width="100%" height="220" class="border-0 w-100" style="min-height: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    @else
                                                        {!! $item->google_map !!}
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr class="my-4">
                                <h4 class="text-primary fw-bold mb-3">Social Media Links</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">YouTube Link</label>
                                        <input type="url" name="youtube_link" class="form-control" placeholder="YouTube Link"
                                            value="{{ old('youtube_link', $item->youtube_link) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Facebook Link</label>
                                        <input type="url" name="facebook_link" class="form-control" placeholder="Facebook Link"
                                            value="{{ old('facebook_link', $item->facebook_link) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Instagram Link</label>
                                        <input type="url" name="instagram_link" class="form-control" placeholder="Instagram Link"
                                            value="{{ old('instagram_link', $item->instagram_link) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Twitter Link</label>
                                        <input type="url" name="twitter_link" class="form-control" placeholder="Twitter Link"
                                            value="{{ old('twitter_link', $item->twitter_link) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab: Payment -->
                            <div class="tab-pane" id="tabs-payment" role="tabpanel">
                                <h4 class="text-primary fw-bold mb-3">SSLCommerz Payment Gateway Settings</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">SSLCommerz Checkout Status</label>
                                        <select name="ssl_status" class="form-select">
                                            <option value="1" {{ old('ssl_status', $item->ssl_status ?? 1) == 1 ? 'selected' : '' }}>ON (Enable SSLCOMMERZ Checkout Button)</option>
                                            <option value="0" {{ old('ssl_status', $item->ssl_status ?? 1) == 0 ? 'selected' : '' }}>OFF (Hide SSLCOMMERZ Checkout Button)</option>
                                        </select>
                                        <small class="form-text text-muted">When OFF, the SSLCOMMERZ checkout button will be hidden on package detail modals.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Environment Mode</label>
                                        <select name="ssl_sandbox" class="form-select">
                                            <option value="1" {{ old('ssl_sandbox', $item->ssl_sandbox ?? 1) == 1 ? 'selected' : '' }}>Sandbox / Test Mode</option>
                                            <option value="0" {{ old('ssl_sandbox', $item->ssl_sandbox ?? 1) == 0 ? 'selected' : '' }}>Live Mode</option>
                                        </select>
                                        <small class="form-text text-muted">Select Live Mode when using real merchant credentials.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Store ID</label>
                                        <input type="text" name="ssl_store_id" class="form-control" placeholder="Enter Store ID (e.g. memoryclicklive)"
                                            value="{{ old('ssl_store_id', $item->ssl_store_id) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Store Password / Key</label>
                                        <input type="text" name="ssl_store_password" class="form-control" placeholder="Enter Store Password"
                                            value="{{ old('ssl_store_password', $item->ssl_store_password) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab: Tracking -->
                            <div class="tab-pane" id="tabs-tracking" role="tabpanel">
                                <!-- Global SEO Card -->
                                <div class="card shadow-none border mb-4">
                                    <div class="card-header bg-light py-2 px-3 fw-bold text-dark">
                                        <i class="ti ti-search me-2"></i> Global & Homepage SEO Meta Tags
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Meta Title (SEO)</label>
                                            <input type="text" name="meta_title" class="form-control" placeholder="e.g. MemoryClick - Premium Wedding Photography"
                                                value="{{ old('meta_title', $item->meta_title) }}">
                                            <div class="form-text text-muted small mt-1">This will be used as the default title for the homepage and any page without specific SEO data.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Meta Keywords</label>
                                            <textarea name="meta_keywords" class="form-control small" rows="2" placeholder="e.g. wedding photography, cinematography, bridal shoot">{{ old('meta_keywords', $item->meta_keywords) }}</textarea>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label fw-bold">Meta Description</label>
                                            <textarea name="meta_description" class="form-control small" rows="3" placeholder="e.g. Premium wedding photography and cinematography company based in Bangladesh">{{ old('meta_description', $item->meta_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                    <h4 class="text-primary fw-bold mb-0 d-flex align-items-center">
                                        Google Pixel, Analytics & Search Console Settings
                                    </h4>
                                    <span class="text-muted small"><span class="text-danger fw-bold">*</span> Indicates input field</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="card shadow-none border">
                                            <div class="card-header bg-light py-2 px-3 fw-bold text-dark">
                                                1. Google Search Console Verification
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="mb-0">
                                                    <label class="form-label fw-bold">Google Search Console Code / Verification Tag <span class="text-danger">*</span></label>
                                                    <textarea name="google_search_console_code" class="form-control font-monospace small" rows="2" placeholder='e.g. <meta name="google-site-verification" content="YOUR_VERIFICATION_TOKEN" />'>{{ old('google_search_console_code', $item->google_search_console_code) }}</textarea>
                                                    <div class="form-text text-muted small mt-1">Paste your Google Search Console meta tag or HTML verification snippet.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="card shadow-none border h-100">
                                            <div class="card-header bg-light py-2 px-3 fw-bold text-dark">
                                                2. Google Analytics (GTAG / GTM)
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Google Analytics ID <span class="text-danger">*</span></label>
                                                    <input type="text" name="google_analytics_id" class="form-control" placeholder="e.g. G-XXXXXXXXXX or UA-XXXXXXXX-X" value="{{ old('google_analytics_id', $item->google_analytics_id) }}">
                                                    <div class="form-text text-muted small mt-1">Enter Measurement ID for auto GTAG script generation.</div>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label fw-bold">Google Analytics Full Code</label>
                                                    <textarea name="google_analytics_code" class="form-control font-monospace small" rows="3" placeholder="<script async src='https://www.googletagmanager.com/gtag/js?id=...'></script>...">{{ old('google_analytics_code', $item->google_analytics_code) }}</textarea>
                                                    <div class="form-text text-muted small mt-1">Or paste your custom Google Analytics / Tag Manager script block here.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="card shadow-none border h-100">
                                            <div class="card-header bg-light py-2 px-3 fw-bold text-dark">
                                                3. Google Pixel / Meta Pixel Tracking
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Google Pixel / Meta Pixel ID <span class="text-danger">*</span></label>
                                                    <input type="text" name="google_pixel_id" class="form-control" placeholder="e.g. 123456789012345" value="{{ old('google_pixel_id', $item->google_pixel_id) }}">
                                                    <div class="form-text text-muted small mt-1">Enter Pixel ID for dynamic event tracking.</div>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label fw-bold">Google Pixel Full Code</label>
                                                    <textarea name="google_pixel_code" class="form-control font-monospace small" rows="3" placeholder="<!-- Meta Pixel Code --> <script>...</script>">{{ old('google_pixel_code', $item->google_pixel_code) }}</textarea>
                                                    <div class="form-text text-muted small mt-1">Or paste your full Google / Facebook Pixel tracking snippet.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="card shadow-none border">
                                            <div class="card-header bg-light py-2 px-3 fw-bold text-dark">
                                                4. Custom Tracking Scripts Injection
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row g-3">
                                                    <div class="col-12 col-md-6">
                                                        <label class="form-label fw-bold">Custom Header Scripts (&lt;head&gt;)</label>
                                                        <textarea name="custom_head_code" class="form-control font-monospace small" rows="3" placeholder="Custom scripts injected into <head>">{{ old('custom_head_code', $item->custom_head_code) }}</textarea>
                                                        <div class="form-text text-muted small mt-1">Any additional tracking codes injected into the &lt;head&gt; tag.</div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label class="form-label fw-bold">Custom Body Scripts (&lt;body&gt;)</label>
                                                        <textarea name="custom_body_code" class="form-control font-monospace small" rows="3" placeholder="Custom scripts injected immediately after <body> tag">{{ old('custom_body_code', $item->custom_body_code) }}</textarea>
                                                        <div class="form-text text-muted small mt-1">Additional noscript or body tracking scripts.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-light text-end p-3">
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="ti ti-device-floppy me-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Enter content here...',
            tabsize: 2,
            height: 200
        });
    });
</script>
@endpush
