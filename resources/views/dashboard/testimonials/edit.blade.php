@extends('dashboard.layouts.app')
@section('title', 'Edit Testimonial – TrustCredNet')
@section('page-title', 'Edit Testimonial')

@section('content')

<div class="row">
<div class="col-lg-8">

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">Edit Testimonial</h2>
        <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline dash-btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Website --}}
        <div class="dash-form-group">
            <label class="dash-form-label" for="website_id">Website <span style="color:#DC2626;">*</span></label>
            <select id="website_id" name="website_id"
                    class="dash-form-input {{ $errors->has('website_id') ? 'is-invalid' : '' }}" required>
                @foreach($websites as $site)
                    <option value="{{ $site->id }}" {{ old('website_id', $testimonial->website_id) == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
            @error('website_id') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        {{-- Customer Name + Role --}}
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="author_name">
                        Customer Name <span style="color:#DC2626;">*</span>
                    </label>
                    <input type="text" id="author_name" name="author_name"
                           value="{{ old('author_name', $testimonial->author_name) }}"
                           class="dash-form-input {{ $errors->has('author_name') ? 'is-invalid' : '' }}"
                           required>
                    @error('author_name') <div class="dash-form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="author_role">
                        Role / Company <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span>
                    </label>
                    <input type="text" id="author_role" name="author_role"
                           value="{{ old('author_role', $testimonial->author_role) }}"
                           class="dash-form-input {{ $errors->has('author_role') ? 'is-invalid' : '' }}"
                           placeholder="e.g. CEO at Acme Inc.">
                    @error('author_role') <div class="dash-form-error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Email + Date --}}
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="author_email">
                        Customer Email <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span>
                    </label>
                    <input type="email" id="author_email" name="author_email"
                           value="{{ old('author_email', $testimonial->author_email) }}"
                           class="dash-form-input {{ $errors->has('author_email') ? 'is-invalid' : '' }}">
                    @error('author_email') <div class="dash-form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="reviewed_at">Date of Review</label>
                    <input type="date" id="reviewed_at" name="reviewed_at"
                           value="{{ old('reviewed_at', $testimonial->reviewed_at?->toDateString()) }}"
                           class="dash-form-input {{ $errors->has('reviewed_at') ? 'is-invalid' : '' }}">
                    @error('reviewed_at') <div class="dash-form-error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Rating --}}
        <div class="dash-form-group">
            <label class="dash-form-label">Rating <span style="color:#DC2626;">*</span></label>
            <div class="d-flex align-items-center gap-2" id="starPicker">
                @php $currentRating = old('rating', $testimonial->rating); @endphp
                @for($i = 1; $i <= 5; $i++)
                <label style="cursor:pointer;">
                    <input type="radio" name="rating" value="{{ $i }}"
                           {{ $currentRating == $i ? 'checked' : '' }}
                           style="display:none;" class="star-radio">
                    <i class="bi bi-star-fill"
                       style="font-size:2rem;color:{{ $currentRating >= $i ? '#F59E0B' : '#D1D5DB' }};transition:color .15s;"
                       data-val="{{ $i }}"></i>
                </label>
                @endfor
                <span id="ratingLabel" style="font-size:.85rem;font-weight:600;color:var(--tcn-gray);margin-left:8px;">
                    {{ $currentRating }} / 5
                </span>
            </div>
        </div>

        {{-- Testimonial Text --}}
        <div class="dash-form-group">
            <label class="dash-form-label" for="content">
                Testimonial Text <span style="color:#DC2626;">*</span>
            </label>
            <textarea id="content" name="content" rows="5"
                      class="dash-form-input {{ $errors->has('content') ? 'is-invalid' : '' }}"
                      required>{{ old('content', $testimonial->content) }}</textarea>
            @error('content') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        {{-- Customer Image --}}
        <div class="dash-form-group">
            <label class="dash-form-label" for="customer_image">
                Customer Photo <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span>
            </label>
            @if($testimonial->customer_image)
                <div style="margin-bottom:10px;display:flex;align-items:center;gap:12px;">
                    <img src="{{ $testimonial->customer_image }}" alt="Current photo"
                         style="width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid var(--tcn-border);">
                    <span style="font-size:.82rem;color:var(--tcn-gray);">Current photo. Upload a new one to replace it.</span>
                </div>
            @endif
            <div class="d-flex align-items-center gap-3">
                <div id="imgPreviewWrap" style="display:none;">
                    <img id="imgPreview"
                         style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid var(--tcn-border);">
                </div>
                <input type="file" id="customer_image" name="customer_image" accept="image/*"
                       class="dash-form-input {{ $errors->has('customer_image') ? 'is-invalid' : '' }}"
                       style="padding:8px 14px;">
            </div>
            <div class="dash-form-help">JPG, PNG or WEBP · Max 2 MB.</div>
            @error('customer_image') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        {{-- Status + Featured --}}
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="status">Status</label>
                    <select id="status" name="status" class="dash-form-input">
                        @foreach(['approved' => 'Approved', 'pending' => 'Pending', 'rejected' => 'Rejected'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('status', $testimonial->status) === $val ? 'selected' : '' }}>
                                {{ $lbl }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label">&nbsp;</label>
                    <label class="d-flex align-items-center gap-2" style="cursor:pointer;padding-top:6px;">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured"
                               {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}
                               style="width:16px;height:16px;accent-color:var(--tcn-green);cursor:pointer;">
                        <span class="dash-form-label" style="margin:0;">Mark as Featured</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="dash-btn dash-btn-primary">
                <i class="bi bi-check-lg"></i> Save Changes
            </button>
            <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline">Cancel</a>
        </div>
    </form>
</div>

</div>
</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.star-radio').forEach(radio => {
        radio.addEventListener('change', () => {
            const val = parseInt(radio.value);
            document.querySelectorAll('#starPicker i').forEach(star => {
                star.style.color = parseInt(star.dataset.val) <= val ? '#F59E0B' : '#D1D5DB';
            });
            document.getElementById('ratingLabel').textContent = val + ' / 5';
        });
    });

    document.getElementById('customer_image').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const wrap = document.getElementById('imgPreviewWrap');
        const img  = document.getElementById('imgPreview');
        img.src = URL.createObjectURL(file);
        wrap.style.display = 'block';
    });
</script>
@endsection


@section('content')

<div class="row">
<div class="col-lg-7">

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">Edit Testimonial</h2>
        <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline dash-btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.testimonials.update', $testimonial) }}">
        @csrf
        @method('PUT')

        <div class="dash-form-group">
            <label class="dash-form-label" for="website_id">Website <span style="color:#DC2626;">*</span></label>
            <select id="website_id" name="website_id"
                    class="dash-form-input {{ $errors->has('website_id') ? 'is-invalid' : '' }}" required>
                @foreach($websites as $site)
                    <option value="{{ $site->id }}" {{ old('website_id', $testimonial->website_id) == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
            @error('website_id') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        <div class="row g-3">
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="author_name">Author Name <span style="color:#DC2626;">*</span></label>
                    <input type="text" id="author_name" name="author_name"
                           value="{{ old('author_name', $testimonial->author_name) }}"
                           class="dash-form-input {{ $errors->has('author_name') ? 'is-invalid' : '' }}"
                           required>
                    @error('author_name') <div class="dash-form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="author_email">Author Email</label>
                    <input type="email" id="author_email" name="author_email"
                           value="{{ old('author_email', $testimonial->author_email) }}"
                           class="dash-form-input {{ $errors->has('author_email') ? 'is-invalid' : '' }}">
                    @error('author_email') <div class="dash-form-error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="dash-form-group">
            <label class="dash-form-label" for="content">Testimonial Content <span style="color:#DC2626;">*</span></label>
            <textarea id="content" name="content" rows="4"
                      class="dash-form-input {{ $errors->has('content') ? 'is-invalid' : '' }}"
                      required>{{ old('content', $testimonial->content) }}</textarea>
            @error('content') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        <div class="row g-3">
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="rating">Rating</label>
                    <select id="rating" name="rating" class="dash-form-input">
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                {{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }} ({{ $i }})
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label" for="status">Status</label>
                    <select id="status" name="status" class="dash-form-input">
                        @foreach(['approved' => 'Approved', 'pending' => 'Pending', 'rejected' => 'Rejected'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('status', $testimonial->status) === $val ? 'selected' : '' }}>
                                {{ $lbl }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="dash-form-group">
            <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                <input type="checkbox" name="is_featured" value="1" id="is_featured"
                       {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:var(--tcn-green);cursor:pointer;">
                <span class="dash-form-label" style="margin:0;">Mark as Featured</span>
            </label>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="dash-btn dash-btn-primary">
                <i class="bi bi-check-lg"></i> Save Changes
            </button>
            <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline">Cancel</a>
        </div>
    </form>
</div>

</div>
</div>

@endsection
