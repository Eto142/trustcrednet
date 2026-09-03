@extends('dashboard.layouts.app')
@section('title', 'Add Testimonials – TrustCredNet')
@section('page-title', 'Add Testimonials')

@section('content')

<div class="row">
<div class="col-lg-9">

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">New Testimonials</h2>
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
        <form method="POST" action="{{ route('dashboard.testimonials.store') }}" enctype="multipart/form-data" id="batchForm">
            @csrf

            {{-- Website (shared by the whole batch) --}}
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
                <div class="dash-form-help">All testimonials below will be added to this website.</div>
            </div>

            {{-- Bulk paste --}}
            <div class="dash-form-group" style="background:var(--tcn-bg-soft,#F9FAFB);border:1px solid var(--tcn-border);border-radius:10px;padding:1rem;">
                <label class="dash-form-label" for="bulkPasteInput">
                    <i class="bi bi-clipboard2-plus"></i> Bulk Paste
                    <span style="color:var(--tcn-gray);font-weight:400;">(optional — fill every row below in one go)</span>
                </label>
                <div class="dash-form-help" style="margin-top:-4px;margin-bottom:8px;">
                    Paste rows copied from a spreadsheet (columns in order: Name, Role, Email, Rating, Date, Content — separated by tabs),
                    <u>or</u> loose paragraphs (one testimonial per paragraph, blank line between each, first line = name). Either style is auto-detected.
                </div>
                <textarea id="bulkPasteInput" class="dash-form-input" rows="5"
                          placeholder="Jane Smith&#9;CEO at Acme&#9;jane@acme.com&#9;5&#9;2026-01-01&#9;Amazing product, saved us hours every week.
John Doe&#9;Founder&#9;&#9;4&#9;&#9;Really solid support team, highly recommend.

— or —

Jane Smith
Amazing product, saved us hours every week.

John Doe
Really solid support team, highly recommend."></textarea>
                <div class="d-flex align-items-center gap-2 mt-2">
                    <button type="button" id="bulkParseBtn" class="dash-btn dash-btn-primary dash-btn-sm">
                        <i class="bi bi-magic"></i> Parse &amp; Fill Rows
                    </button>
                    <span id="bulkParseMsg" style="font-size:.82rem;color:var(--tcn-gray);"></span>
                </div>
                <div class="dash-form-help">This replaces the rows below with what you paste. You can still edit, add or remove rows manually afterwards.</div>
            </div>

            <div id="testimonialRows"></div>

            <button type="button" id="addRowBtn" class="dash-btn dash-btn-outline mb-3">
                <i class="bi bi-plus-lg"></i> Add Another Testimonial
            </button>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="dash-btn dash-btn-primary">
                    <i class="bi bi-check-lg"></i> Save Testimonial<span class="saveCountLabel"></span>
                </button>
                <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline">Cancel</a>
            </div>
        </form>
    @endif
</div>

</div>
</div>

{{-- Row template --}}
<template id="rowTemplate">
    <div class="testimonial-row dash-card" style="border:1px dashed var(--tcn-border);margin-bottom:1.25rem;padding:1.25rem;position:relative;">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="row-number" style="font-weight:600;color:var(--tcn-gray);"></span>
            <button type="button" class="dash-btn dash-btn-outline dash-btn-sm remove-row-btn" style="color:#DC2626;border-color:#DC2626;">
                <i class="bi bi-trash"></i> Remove
            </button>
        </div>

        {{-- Customer Name + Role --}}
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label">Customer Name <span style="color:#DC2626;">*</span></label>
                    <input type="text" class="dash-form-input field-author_name" placeholder="e.g. Jane Smith" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label">Role / Company <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span></label>
                    <input type="text" class="dash-form-input field-author_role" placeholder="e.g. CEO at Acme Inc.">
                </div>
            </div>
        </div>

        {{-- Email + Date --}}
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label">Customer Email <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span></label>
                    <input type="email" class="dash-form-input field-author_email" placeholder="jane@example.com">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dash-form-group">
                    <label class="dash-form-label">Date of Review <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span></label>
                    <input type="date" class="dash-form-input field-reviewed_at">
                </div>
            </div>
        </div>

        {{-- Rating --}}
        <div class="dash-form-group">
            <label class="dash-form-label">Rating <span style="color:#DC2626;">*</span></label>
            <div class="d-flex align-items-center gap-2 star-picker">
                @for($i = 1; $i <= 5; $i++)
                <label style="cursor:pointer;">
                    <input type="radio" class="star-radio field-rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} style="display:none;">
                    <i class="bi bi-star-fill" style="font-size:1.75rem;color:{{ $i <= 5 ? '#F59E0B' : '#D1D5DB' }};transition:color .15s;" data-val="{{ $i }}"></i>
                </label>
                @endfor
                <span class="rating-label" style="font-size:.85rem;font-weight:600;color:var(--tcn-gray);margin-left:8px;">5 / 5</span>
            </div>
        </div>

        {{-- Content --}}
        <div class="dash-form-group">
            <label class="dash-form-label">Testimonial Text <span style="color:#DC2626;">*</span></label>
            <textarea class="dash-form-input field-content" rows="4" placeholder="What did the customer say about your product or service?" required></textarea>
        </div>

        {{-- Customer Image --}}
        <div class="dash-form-group">
            <label class="dash-form-label">Customer Photo <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span></label>
            <div class="d-flex align-items-center gap-3">
                <div class="img-preview-wrap" style="display:none;">
                    <img class="img-preview" style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid var(--tcn-border);">
                </div>
                <input type="file" class="dash-form-input field-customer_image" accept="image/*" style="padding:8px 14px;">
            </div>
            <div class="dash-form-help">JPG, PNG or WEBP · Max 2 MB.</div>
        </div>

        {{-- Featured --}}
        <div class="dash-form-group mb-0">
            <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                <input type="checkbox" class="field-is_featured" style="width:16px;height:16px;accent-color:var(--tcn-green);cursor:pointer;">
                <span class="dash-form-label" style="margin:0;">Mark as Featured</span>
            </label>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
(function () {
    const rowsWrap   = document.getElementById('testimonialRows');
    const template   = document.getElementById('rowTemplate');
    const addRowBtn  = document.getElementById('addRowBtn');
    const form       = document.getElementById('batchForm');
    if (!form) return;

    let rowCount = 0;

    function addRow(data) {
        data = data || {};
        const index = rowCount++;
        const frag = template.content.cloneNode(true);
        const row  = frag.querySelector('.testimonial-row');
        row.dataset.index = index;

        row.querySelectorAll('[class*="field-"]').forEach(el => {
            const fieldClass = Array.from(el.classList).find(c => c.startsWith('field-'));
            const field = fieldClass.replace('field-', '');
            el.name = `testimonials[${index}][${field}]`;
            if (el.type === 'checkbox') {
                el.value = '1';
            }
        });

        if (data.author_name)  row.querySelector('.field-author_name').value  = data.author_name;
        if (data.author_role)  row.querySelector('.field-author_role').value  = data.author_role;
        if (data.author_email) row.querySelector('.field-author_email').value = data.author_email;
        if (data.reviewed_at)  row.querySelector('.field-reviewed_at').value  = data.reviewed_at;
        if (data.content)      row.querySelector('.field-content').value      = data.content;

        if (data.rating) {
            const radio = row.querySelector(`.field-rating[value="${data.rating}"]`);
            if (radio) {
                radio.checked = true;
                const picker = row.querySelector('.star-picker');
                picker.querySelectorAll('i').forEach(star => {
                    star.style.color = parseInt(star.dataset.val) <= data.rating ? '#F59E0B' : '#D1D5DB';
                });
                picker.querySelector('.rating-label').textContent = data.rating + ' / 5';
            }
        }

        rowsWrap.appendChild(frag);
        renumberRows();
        updateRemoveButtons();
        updateSaveLabel();
    }

    function renumberRows() {
        rowsWrap.querySelectorAll('.testimonial-row').forEach((row, i) => {
            row.querySelector('.row-number').textContent = 'Testimonial #' + (i + 1);
        });
    }

    function updateRemoveButtons() {
        const rows = rowsWrap.querySelectorAll('.testimonial-row');
        rows.forEach(row => {
            row.querySelector('.remove-row-btn').style.display = rows.length > 1 ? '' : 'none';
        });
    }

    function updateSaveLabel() {
        const count = rowsWrap.querySelectorAll('.testimonial-row').length;
        document.querySelector('.saveCountLabel').textContent = count > 1 ? ` (${count})` : '';
    }

    // Star picker (event delegation)
    rowsWrap.addEventListener('change', function (e) {
        if (e.target.classList.contains('star-radio')) {
            const picker = e.target.closest('.star-picker');
            const val = parseInt(e.target.value);
            picker.querySelectorAll('i').forEach(star => {
                star.style.color = parseInt(star.dataset.val) <= val ? '#F59E0B' : '#D1D5DB';
            });
            picker.querySelector('.rating-label').textContent = val + ' / 5';
        }

        if (e.target.classList.contains('field-customer_image')) {
            const file = e.target.files[0];
            if (!file) return;
            const row  = e.target.closest('.testimonial-row');
            const wrap = row.querySelector('.img-preview-wrap');
            const img  = row.querySelector('.img-preview');
            img.src = URL.createObjectURL(file);
            wrap.style.display = 'block';
        }
    });

    // Remove row
    rowsWrap.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-row-btn');
        if (!btn) return;
        const rows = rowsWrap.querySelectorAll('.testimonial-row');
        if (rows.length <= 1) return;
        btn.closest('.testimonial-row').remove();
        renumberRows();
        updateRemoveButtons();
        updateSaveLabel();
    });

    addRowBtn.addEventListener('click', () => addRow());

    // --- Bulk paste parsing ---
    const bulkInput   = document.getElementById('bulkPasteInput');
    const bulkBtn     = document.getElementById('bulkParseBtn');
    const bulkMsg     = document.getElementById('bulkParseMsg');
    const DATE_RE     = /^\d{4}-\d{2}-\d{2}$/;

    function parseSpreadsheet(text) {
        return text.split('\n')
            .map(line => line.replace(/\r$/, ''))
            .filter(line => line.trim() !== '')
            .map(line => {
                const cols = line.split('\t').map(c => c.trim());
                const name = cols[0] || '';
                const content = cols.length > 1 ? cols[cols.length - 1] : '';
                const middle = cols.slice(1, cols.length - 1);
                const row = { author_name: name, content: content };

                // Middle columns map positionally onto [role, email, rating, date],
                // but a value is only accepted into the slot it actually looks like.
                const slots = ['author_role', 'author_email', 'rating', 'reviewed_at'];
                let s = 0;
                middle.forEach(val => {
                    if (!val) { s++; return; }
                    while (s < slots.length) {
                        const slot = slots[s];
                        if (slot === 'rating' && /^[1-5]$/.test(val)) { row.rating = parseInt(val); s++; return; }
                        if (slot === 'reviewed_at' && DATE_RE.test(val)) { row.reviewed_at = val; s++; return; }
                        if (slot === 'author_email' && val.indexOf('@') !== -1) { row.author_email = val; s++; return; }
                        if (slot === 'author_role') { row.author_role = val; s++; return; }
                        s++;
                    }
                });
                return row;
            })
            .filter(row => row.author_name && row.content);
    }

    function parseParagraphs(text) {
        return text.split(/\n\s*\n/)
            .map(block => block.trim())
            .filter(block => block !== '')
            .map(block => {
                const lines = block.split('\n').map(l => l.trim()).filter(l => l !== '');
                return {
                    author_name: lines[0] || '',
                    content: lines.slice(1).join(' '),
                };
            })
            .filter(row => row.author_name && row.content);
    }

    function parseBulkText(text) {
        return text.indexOf('\t') !== -1 ? parseSpreadsheet(text) : parseParagraphs(text);
    }

    bulkBtn.addEventListener('click', function () {
        const text = bulkInput.value;
        if (!text.trim()) {
            bulkMsg.textContent = 'Paste something first.';
            bulkMsg.style.color = '#DC2626';
            return;
        }

        const rows = parseBulkText(text);
        if (rows.length === 0) {
            bulkMsg.textContent = "Couldn't find any testimonials in that — check the format and try again.";
            bulkMsg.style.color = '#DC2626';
            return;
        }

        rowsWrap.innerHTML = '';
        rowCount = 0;
        rows.forEach(row => addRow(row));

        bulkMsg.textContent = `Filled ${rows.length} testimonial${rows.length > 1 ? 's' : ''} below — review and save.`;
        bulkMsg.style.color = 'var(--tcn-green)';
    });

    // Start with one row
    addRow();
})();
</script>
@endsection
