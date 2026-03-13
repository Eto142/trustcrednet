@extends('dashboard.layouts.app')
@section('title', 'Add Testimonial – TrustCredNet')
@section('page-title', 'Add Testimonial')

@section('content')

<div class="row">
<div class="col-lg-8">

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">New Testimonial</h2>
        <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline dash-btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if($websites->isEmpty())
        <div class="dash-empty">
            <i class="bi bi-globe2"></i>
            <div class="dash-empty-title">No active websites yet</div>
            <p class="dash-empty-sub">Add and activate a website before adding testimonials.</p>
            <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
                <i class="bi bi-plus-lg"></i> Add a Website
            </a>
        </div>
    @else
        <form method="POST" action="{{ route('dashboard.testimonials.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Website --}}
            <div class="dash-form-group">
                <label class="dash-form-label" for="website_id">Website <span style="color:#DC2626;">*</span></label>
                <select id="website_id" name="website_id"
                        class="dash-form-input {{ $errors->has('website_id') ? 'is-invalid' : '' }}" required>
                    <option value="">— Select a website —</option>
                    @foreach($websites as $site)
                        <option value="{{ $site->id }}" {{ old('website_id') == $site->id ? 'selected' : '' }}>
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
                               value="{{ old('author_name') }}"
                               class="dash-form-input {{ $errors->has('author_name') ? 'is-invalid' : '' }}"
                               placeholder="e.g. Jane Smith" required>
                        @error('author_name') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dash-form-group">
                        <label class="dash-form-label" for="author_role">
                            Role / Company <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span>
                        </label>
                        <input type="text" id="author_role" name="author_role"
                               value="{{ old('author_role') }}"
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
                               value="{{ old('author_email') }}"
                               class="dash-form-input {{ $errors->has('author_email') ? 'is-invalid' : '' }}"
                               placeholder="jane@example.com">
                        @error('author_email') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dash-form-group">
                        <label class="dash-form-label" for="reviewed_at">
                            Date of Review <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span>
                        </label>
                        <input type="date" id="reviewed_at" name="reviewed_at"
                               value="{{ old('reviewed_at', now()->toDateString()) }}"
                               class="dash-form-input {{ $errors->has('reviewed_at') ? 'is-invalid' : '' }}">
                        @error('reviewed_at') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Rating --}}
            <div class="dash-form-group">
                <label class="dash-form-label">Rating <span style="color:#DC2626;">*</span></label>
                <div class="d-flex align-items-center gap-2" id="starPicker">
                    @for($i = 1; $i <= 5; $i++)
                    <label style="cursor:pointer;">
                        <input type="radio" name="rating" value="{{ $i }}"
                               {{ old('rating', 5) == $i ? 'checked' : '' }}
                               style="display:none;" class="star-radio">
                        <i class="bi bi-star-fill"
                           style="font-size:2rem;color:{{ old('rating', 5) >= $i ? '#F59E0B' : '#D1D5DB' }};transition:color .15s;"
                           data-val="{{ $i }}"></i>
                    </label>
                    @endfor
                    <span id="ratingLabel" style="font-size:.85rem;font-weight:600;color:var(--tcn-gray);margin-left:8px;">
                        {{ old('rating', 5) }} / 5
                    </span>
                </div>
                @error('rating') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            {{-- Testimonial Text --}}
            <div class="dash-form-group">
                <label class="dash-form-label" for="content">
                    Testimonial Text <span style="color:#DC2626;">*</span>
                </label>
                <textarea id="content" name="content" rows="5"
                          class="dash-form-input {{ $errors->has('content') ? 'is-invalid' : '' }}"
                          placeholder="What did the customer say about your product or service?" required>{{ old('content') }}</textarea>
                @error('content') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            {{-- Customer Image --}}
            <div class="dash-form-group">
                <label class="dash-form-label" for="customer_image">
                    Customer Photo <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span>
                </label>
                <div class="d-flex align-items-center gap-3">
                    <div id="imgPreviewWrap" style="display:none;">
                        <img id="imgPreview"
                             style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid var(--tcn-border);">
                    </div>
                    <input type="file" id="customer_image" name="customer_image" accept="image/*"
                           class="dash-form-input {{ $errors->has('customer_image') ? 'is-invalid' : '' }}"
                           style="padding:8px 14px;">
                </div>
                <div class="dash-form-help">JPG, PNG or WEBP · Max 2 MB. Displayed as a round avatar next to the testimonial.</div>
                @error('customer_image') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            {{-- Featured --}}
            <div class="dash-form-group">
                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured"
                           {{ old('is_featured') ? 'checked' : '' }}
                           style="width:16px;height:16px;accent-color:var(--tcn-green);cursor:pointer;">
                    <span class="dash-form-label" style="margin:0;">Mark as Featured</span>
                </label>
                <div class="dash-form-help">Featured testimonials are highlighted in your widget.</div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="dash-btn dash-btn-primary">
                    <i class="bi bi-check-lg"></i> Save Testimonial
                </button>
                <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline">Cancel</a>
            </div>
        </form>
    @endif
</div>

</div>
</div>

@endsection

@section('scripts')
<script>
    // Star picker
    const stars = document.querySelectorAll('.star-radio');
    stars.forEach(radio => {
        radio.addEventListener('change', () => {
            const val = parseInt(radio.value);
            document.querySelectorAll('#starPicker i').forEach(star => {
                star.style.color = parseInt(star.dataset.val) <= val ? '#F59E0B' : '#D1D5DB';
            });
            document.getElementById('ratingLabel').textContent = val + ' / 5';
        });
    });

    // Image preview
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
        <h2 class="dash-card-title">New Testimonial</h2>
        <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline dash-btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if($websites->isEmpty())
        <div class="dash-empty">
            <i class="bi bi-globe2"></i>
            <div class="dash-empty-title">No websites yet</div>
            <p class="dash-empty-sub">You need to add a website before you can add testimonials.</p>
            <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
                <i class="bi bi-plus-lg"></i> Add a Website
            </a>
        </div>
    @else
        <form method="POST" action="{{ route('dashboard.testimonials.store') }}">
            @csrf

            <div class="dash-form-group">
                <label class="dash-form-label" for="website_id">Website <span style="color:#DC2626;">*</span></label>
                <select id="website_id" name="website_id"
                        class="dash-form-input {{ $errors->has('website_id') ? 'is-invalid' : '' }}" required>
                    <option value="">— Select a website —</option>
                    @foreach($websites as $site)
                        <option value="{{ $site->id }}" {{ old('website_id') == $site->id ? 'selected' : '' }}>
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
                        <input type="text" id="author_name" name="author_name" value="{{ old('author_name') }}"
                               class="dash-form-input {{ $errors->has('author_name') ? 'is-invalid' : '' }}"
                               placeholder="Jane Smith" required>
                        @error('author_name') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dash-form-group">
                        <label class="dash-form-label" for="author_email">Author Email <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span></label>
                        <input type="email" id="author_email" name="author_email" value="{{ old('author_email') }}"
                               class="dash-form-input {{ $errors->has('author_email') ? 'is-invalid' : '' }}"
                               placeholder="jane@example.com">
                        @error('author_email') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="dash-form-group">
                <label class="dash-form-label" for="content">Testimonial Content <span style="color:#DC2626;">*</span></label>
                <textarea id="content" name="content" rows="4"
                          class="dash-form-input {{ $errors->has('content') ? 'is-invalid' : '' }}"
                          placeholder="What did the customer say?" required>{{ old('content') }}</textarea>
                @error('content') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            <div class="dash-form-group">
                <label class="dash-form-label">Rating <span style="color:#DC2626;">*</span></label>
                <div class="d-flex gap-2" id="starPicker">
                    @for($i = 5; $i >= 1; $i--)
                    <label style="cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <input type="radio" name="rating" value="{{ $i }}"
                               {{ old('rating', 5) == $i ? 'checked' : '' }}
                               style="display:none;" class="star-radio">
                        <i class="bi bi-star-fill" style="font-size:1.6rem;color:{{ old('rating', 5) >= $i ? '#F59E0B' : '#D1D5DB' }};transition:color .15s;"
                           data-val="{{ $i }}"></i>
                        <span style="font-size:.72rem;color:var(--tcn-gray);">{{ $i }}</span>
                    </label>
                    @endfor
                </div>
                @error('rating') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            <div class="dash-form-group">
                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured"
                           {{ old('is_featured') ? 'checked' : '' }}
                           style="width:16px;height:16px;accent-color:var(--tcn-green);cursor:pointer;">
                    <span class="dash-form-label" style="margin:0;">Mark as Featured</span>
                </label>
                <div class="dash-form-help">Featured testimonials are highlighted in your widget.</div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="dash-btn dash-btn-primary">
                    <i class="bi bi-check-lg"></i> Save Testimonial
                </button>
                <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline">Cancel</a>
            </div>
        </form>
    @endif
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
        });
    });
</script>
@endsection
