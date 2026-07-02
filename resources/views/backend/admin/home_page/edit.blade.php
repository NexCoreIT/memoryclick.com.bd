@extends('backend.layout.app')

@section('content')
<div class="card col-12 d-flex justify-content-center mt-4">
    <form action="{{ route('home.page.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <h3 class="card-title mb-4">Edit Page Content</h3>

            {{-- Section: Homepage --}}
            <h4>Homepage Section</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Client Reviews Title</label>
                        <input type="text" name="homepage_title" class="form-control" placeholder="Homepage Title"
                            value="{{ old('homepage_title', $item->homepage_title) }}" required>
                    </div>
                    {{-- Uncomment if you want Homepage Content field --}}



                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    {{-- Uncomment if you want Homepage Content field --}}



                </div>

            </div>

            <hr>

            {{-- Section: Statistics / Counter --}}
            <h4>Statistics Counter Section</h4>
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Since Year</label>
                        <input type="text" name="since_year" class="form-control" placeholder="e.g. 2014"
                            value="{{ old('since_year', $item->since_year) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Events Count</label>
                        <input type="text" name="events_count" class="form-control" placeholder="e.g. 3000"
                            value="{{ old('events_count', $item->events_count) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Photos Count</label>
                        <input type="text" name="photos_count" class="form-control" placeholder="e.g. 1000"
                            value="{{ old('photos_count', $item->photos_count) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Clients Count</label>
                        <input type="text" name="clients_count" class="form-control" placeholder="e.g. 999"
                            value="{{ old('clients_count', $item->clients_count) }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- Section: Section Titles --}}
            <h4>Section Titles</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Services Subtitle</label>
                        <input type="text" name="service_subtitle" class="form-control" placeholder="e.g. Our Services"
                            value="{{ old('service_subtitle', $item->service_subtitle) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Services Title</label>
                        <input type="text" name="service_title" class="form-control" placeholder="e.g. Our Top Services"
                            value="{{ old('service_title', $item->service_title) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Recent Work Subtitle</label>
                        <input type="text" name="recent_work_subtitle" class="form-control" placeholder="e.g. Recent Work"
                            value="{{ old('recent_work_subtitle', $item->recent_work_subtitle) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Recent Work Title</label>
                        <input type="text" name="recent_work_title" class="form-control" placeholder="e.g. Our recent stunning wedding photography"
                            value="{{ old('recent_work_title', $item->recent_work_title) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Cinematography Subtitle</label>
                        <input type="text" name="cinematography_subtitle" class="form-control" placeholder="e.g. Cinematography"
                            value="{{ old('cinematography_subtitle', $item->cinematography_subtitle) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Cinematography Title</label>
                        <input type="text" name="cinematography_title" class="form-control" placeholder="e.g. Take a peek at our recent stunning wedding photography"
                            value="{{ old('cinematography_title', $item->cinematography_title) }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- Section: About Info --}}
            <h4>About Section</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">About Title</label>
                        <input type="text" name="about_title" class="form-control" placeholder="About Title"
                            value="{{ old('about_title', $item->about_title) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">About Content</label>
                        <textarea name="about_content" class="form-control" rows="3" placeholder="About Content"
                            required>{{ old('about_content', $item->about_content) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">About Button Text</label>
                        <input type="text" name="about_btn" class="form-control" placeholder="About Button Text"
                            value="{{ old('about_btn', $item->about_btn) }}" required>
                    </div>
                </div>
            </div>

            <hr>

            {{-- Section: Footer Info --}}
            <h4>Footer Section</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Footer Title</label>
                        <input type="text" name="footer_title" class="form-control" placeholder="Footer Title"
                            value="{{ old('footer_title', $item->footer_title) }}" required>
                    </div>
                </div>
                {{-- Uncomment if you want Footer Button Text field --}}
                {{--
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Footer Button Text</label>
                        <input type="text" name="footer_btn" class="form-control" placeholder="Footer Button Text"
                            value="{{ old('footer_btn', $item->footer_btn) }}">
                    </div>
                </div>
                --}}
            </div>

            <hr>

            {{-- Section: Contact Info --}}
            <h4>Contact Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter Address"
                            value="{{ old('address', $item->address) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email"
                            value="{{ old('email', $item->email) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" placeholder="Phone"
                            value="{{ old('phone', $item->phone) }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- Section: Social Links --}}
            <h4>Social Media Links</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">YouTube Link</label>
                        <input type="url" name="youtube_link" class="form-control" placeholder="YouTube Link"
                            value="{{ old('youtube_link', $item->youtube_link) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Facebook Link</label>
                        <input type="url" name="facebook_link" class="form-control" placeholder="Facebook Link"
                            value="{{ old('facebook_link', $item->facebook_link) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Instagram Link</label>
                        <input type="url" name="instagram_link" class="form-control" placeholder="Instagram Link"
                            value="{{ old('instagram_link', $item->instagram_link) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Twitter Link</label>
                        <input type="url" name="twitter_link" class="form-control" placeholder="Twitter Link"
                            value="{{ old('twitter_link', $item->twitter_link) }}">
                    </div>
                </div>
                {{-- Uncomment if you want LinkedIn and Messenger fields --}}
                {{--
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">LinkedIn Link</label>
                        <input type="url" name="linkedin_link" class="form-control" placeholder="LinkedIn Link"
                            value="{{ old('linkedin_link', $item->linkedin_link) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Messenger Username</label>
                        <input type="text" name="messenger_username" class="form-control"
                            placeholder="Messenger Username"
                            value="{{ old('messenger_username', $item->messenger_username) }}">
                    </div>
                </div>
                --}}
            </div>

        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
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
