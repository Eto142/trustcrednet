@include('admin.header')
@include('admin.navbar')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <nav class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <span class="current">Payment Settings</span>
        </nav>
        <h1 class="page-title">Payment Settings</h1>
        <p class="page-subtitle">Global payment details shown to users in the activation modal</p>
    </div>
</div>

@if(session('message'))
<div class="admin-alert admin-alert-success" style="margin-bottom:20px;padding:12px 18px;border-radius:8px;background:#D1FAE5;border:1px solid #6EE7B7;color:#065F46;display:flex;align-items:center;gap:10px;">
    <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
</div>
@endif

<form method="POST" action="{{ route('admin.settings.payment.update') }}">
    @csrf
    @method('PUT')

    <div class="row g-4">

        {{-- ── Pricing ── --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="bi bi-tag-fill"></i> Pricing</h3>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Plan Price (USD / year)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" min="1" step="0.01" name="price_usd" class="form-control @error('price_usd') is-invalid @enderror"
                                       value="{{ old('price_usd', $settings['price_usd']) }}" required>
                            </div>
                            @error('price_usd')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <small class="text-muted">Displayed in the activation modal to all users.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Crypto ── --}}
        <div class="col-lg-6">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="bi bi-currency-bitcoin"></i> Crypto (USDT TRC20)</h3>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Wallet Address</label>
                        <input type="text" name="crypto_address" class="form-control font-monospace @error('crypto_address') is-invalid @enderror"
                               value="{{ old('crypto_address', $settings['crypto_address']) }}"
                               placeholder="TXxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                        @error('crypto_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Users will see this address and can copy it.</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Moniffy ── --}}
        <div class="col-lg-6">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="bi bi-wallet2"></i> Moniffy</h3>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username / Tag</label>
                        <input type="text" name="moniffy_tag" class="form-control font-monospace @error('moniffy_tag') is-invalid @enderror"
                               value="{{ old('moniffy_tag', $settings['moniffy_tag']) }}"
                               placeholder="@trustcrednet">
                        @error('moniffy_tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Moniffy payment tag shown to users.</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Bank Transfer ── --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="bi bi-bank"></i> Bank Transfer</h3>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror"
                                   value="{{ old('bank_name', $settings['bank_name']) }}"
                                   placeholder="Opay (OPay Digital Services)">
                            @error('bank_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Account Number</label>
                            <input type="text" name="bank_account_number" class="form-control font-monospace @error('bank_account_number') is-invalid @enderror"
                                   value="{{ old('bank_account_number', $settings['bank_account_number']) }}"
                                   placeholder="0000000000" maxlength="20">
                            @error('bank_account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Account Name</label>
                            <input type="text" name="bank_account_name" class="form-control @error('bank_account_name') is-invalid @enderror"
                                   value="{{ old('bank_account_name', $settings['bank_account_name']) }}"
                                   placeholder="TrustCredNet Technologies">
                            @error('bank_account_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── WhatsApp ── --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="bi bi-whatsapp"></i> WhatsApp Support</h3>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">WhatsApp Number <small class="text-muted">(international format, no + or spaces)</small></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                <input type="text" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                       value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}"
                                       placeholder="2348000000000">
                            </div>
                            @error('whatsapp_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <small class="text-muted">Users tap this to send their payment receipt. Example: <code>2348012345678</code></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Preview ── --}}
        <div class="col-12">
            <div class="admin-card" style="border:2px dashed var(--admin-border);background:var(--admin-bg);">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="bi bi-eye"></i> Live Preview — User Activation Modal</h3>
                </div>
                <div class="admin-card-body">
                    <p style="color:var(--admin-text-muted);font-size:.85rem;margin-bottom:12px;">
                        This is exactly how the payment tab will appear to users. Save settings to update.
                    </p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <div class="preview-tab-box">
                            <div class="preview-tab-title"><i class="bi bi-currency-bitcoin"></i> Crypto</div>
                            <div class="preview-row"><span>Network</span><span>USDT (TRC20)</span></div>
                            <div class="preview-row"><span>Address</span><span class="font-monospace">{{ $settings['crypto_address'] ?: '—' }}</span></div>
                            <div class="preview-row"><span>Amount</span><span style="color:#059669;font-weight:700;">${{ $settings['price_usd'] }} USDT/yr</span></div>
                        </div>
                        <div class="preview-tab-box">
                            <div class="preview-tab-title"><i class="bi bi-wallet2"></i> Moniffy</div>
                            <div class="preview-row"><span>Tag</span><span class="font-monospace">{{ $settings['moniffy_tag'] ?: '—' }}</span></div>
                            <div class="preview-row"><span>Amount</span><span style="color:#059669;font-weight:700;">₦[live rate] /yr</span></div>
                        </div>
                        <div class="preview-tab-box">
                            <div class="preview-tab-title"><i class="bi bi-bank"></i> Bank</div>
                            <div class="preview-row"><span>Bank</span><span>{{ $settings['bank_name'] ?: '—' }}</span></div>
                            <div class="preview-row"><span>Acct No.</span><span class="font-monospace">{{ $settings['bank_account_number'] ?: '—' }}</span></div>
                            <div class="preview-row"><span>Acct Name</span><span>{{ $settings['bank_account_name'] ?: '—' }}</span></div>
                            <div class="preview-row"><span>Amount</span><span style="color:#059669;font-weight:700;">₦[live rate] /yr</span></div>
                        </div>
                        <div class="preview-tab-box" style="flex:1;min-width:200px;">
                            <div class="preview-tab-title"><i class="bi bi-whatsapp" style="color:#25D366;"></i> WhatsApp</div>
                            <div class="preview-row"><span>Number</span><span class="font-monospace">+{{ $settings['whatsapp_number'] ?: '—' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /row --}}

    <div style="margin-top:24px;">
        <button type="submit" class="btn-admin btn-admin-primary">
            <i class="bi bi-floppy-fill"></i> Save Payment Settings
        </button>
    </div>
</form>

@push('styles')
<style>
.preview-tab-box{background:#fff;border:1px solid var(--admin-border);border-radius:10px;padding:14px 16px;min-width:180px;flex:1;}
.preview-tab-title{font-size:.8rem;font-weight:700;color:var(--admin-text);margin-bottom:10px;display:flex;align-items:center;gap:6px;}
.preview-row{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;font-size:.76rem;padding:5px 0;border-bottom:1px solid #F3F4F6;}
.preview-row:last-child{border-bottom:none;}
.preview-row span:first-child{color:var(--admin-text-muted);flex-shrink:0;}
.preview-row span:last-child{color:var(--admin-text);text-align:right;word-break:break-all;}
</style>
@endpush

@include('admin.footer')
