@extends('dashboard.layouts.app')
@section('title', 'Widget / Embed – TrustCredNet')
@section('page-title', 'Widget / Embed')

@section('content')

<div class="row g-4">

    {{-- Config panel --}}
    <div class="col-lg-5">
        <div class="dash-card">
            <h2 class="dash-card-title" style="margin-bottom:20px;">Configure Widget</h2>

            @if($websites->isEmpty())
                <div class="dash-empty">
                    <i class="bi bi-globe2"></i>
                    <div class="dash-empty-title">No active websites</div>
                    <p class="dash-empty-sub">Add and activate a website to generate an embed code.</p>
                    <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Website
                    </a>
                </div>
            @else

                <div class="dash-form-group">
                    <label class="dash-form-label" for="widgetSite">Select Website</label>
                    <select id="widgetSite" class="dash-form-input" onchange="updateCode()">
                        @foreach($websites as $site)
                            <option value="{{ $site->id }}" data-name="{{ $site->name }}">{{ $site->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="dash-form-group">
                    <label class="dash-form-label">Widget Style</label>
                    <div class="row g-2">
                        @foreach([
                            ['id' => 'slider',  'icon' => 'bi-layout-three-columns', 'label' => 'Slider',  'desc' => 'Horizontal carousel'],
                            ['id' => 'grid',    'icon' => 'bi-grid-3x3',             'label' => 'Grid',    'desc' => 'Card grid layout'],
                            ['id' => 'compact', 'icon' => 'bi-list-ul',              'label' => 'Compact', 'desc' => 'Simple list view'],
                        ] as $style)
                        <div class="col-4">
                            <div class="widget-style-card {{ $loop->first ? 'selected' : '' }}"
                                 id="style-{{ $style['id'] }}"
                                 onclick="selectStyle('{{ $style['id'] }}')">
                                <i class="bi {{ $style['icon'] }}"></i>
                                <div class="wsc-label">{{ $style['label'] }}</div>
                                <div class="wsc-desc">{{ $style['desc'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="dash-form-group" style="margin-bottom:0;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="dash-form-label" style="margin:0;">Primary Color</label>
                        <input type="color" id="widgetColor" value="#00B67A"
                               style="width:32px;height:32px;border:none;background:none;cursor:pointer;padding:0;"
                               onchange="updateCode()">
                    </div>
                </div>

            @endif
        </div>
    </div>

    {{-- Embed code --}}
    <div class="col-lg-7">
        <div class="dash-card">
            <h2 class="dash-card-title" style="margin-bottom:6px;">Embed Code</h2>
            <p style="font-size:.84rem;color:var(--tcn-gray);margin-bottom:16px;">
                Paste this snippet anywhere in your website's HTML to display testimonials.
            </p>

            @if($websites->isNotEmpty())
                <div class="dash-code-block" id="embedBlock">
                    <button class="dash-copy-btn" onclick="copyCode()">Copy</button>
                    <pre id="embedCode" style="margin:0;white-space:pre-wrap;word-break:break-all;"></pre>
                </div>

                <div class="dash-alert dash-alert-success" style="margin-top:16px;margin-bottom:0;">
                    <i class="bi bi-info-circle-fill"></i>
                    The snippet loads your approved testimonials automatically. No page token required.
                </div>
            @else
                <div class="dash-empty">
                    <i class="bi bi-code-slash"></i>
                    <div class="dash-empty-title">No code yet</div>
                    <p class="dash-empty-sub">Add a website first to generate an embed snippet.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@section('scripts')
@if($websites->isNotEmpty())
<script>
    const BASE = "{{ config('app.url') }}";
    let activeStyle = 'slider';

    const sites = @json($websites->map(fn($s) => ['id' => $s->id, 'name' => $s->name]));

    function selectStyle(style) {
        activeStyle = style;
        document.querySelectorAll('.widget-style-card').forEach(c => c.classList.remove('selected'));
        document.getElementById('style-' + style).classList.add('selected');
        updateCode();
    }

    function updateCode() {
        const siteEl  = document.getElementById('widgetSite');
        const colorEl = document.getElementById('widgetColor');
        const siteId  = siteEl ? siteEl.value : '';
        const color   = colorEl ? colorEl.value : '#00B67A';

        const code =
`<!-- TrustCredNet Widget -->
<div id="tcn-widget"
     data-site="${siteId}"
     data-style="${activeStyle}"
     data-color="${color}">
</div>
<script src="${BASE}/widget/tcn-widget.js"><\/script>`;

        document.getElementById('embedCode').textContent = code;
    }

    function copyCode() {
        const code = document.getElementById('embedCode').textContent;
        navigator.clipboard.writeText(code).then(() => {
            const btn = document.querySelector('.dash-copy-btn');
            btn.textContent = 'Copied!';
            setTimeout(() => btn.textContent = 'Copy', 2000);
        }).catch(() => {
            const el = document.createElement('textarea');
            el.value = code;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        });
    }

    updateCode();
</script>
@endif
@endsection
