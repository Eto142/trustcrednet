<section id="hero">
    <div id="particles-js" aria-hidden="true"></div>

    <div class="hero-center fade-up">

        {{-- Live badge --}}
        <div class="hero-badge">
            <span class="live-dot"></span>
            Trusted by 12,000+ businesses
        </div>

        {{-- Headline --}}
        <h1 class="hero-h1">
            Discover businesses<br>worth <span class="gradient-text">believing in</span>.
        </h1>

        {{-- Subtitle --}}
        <p class="hero-sub">
            Genuine reviews from verified customers. Zero paid placements, zero fake ratings.
        </p>

        {{-- Big search bar --}}
        <form class="hero-search-form" role="search" onsubmit="event.preventDefault(); heroRunSearch();">
            <div class="hero-search-bar">
                <i class="bi bi-search"></i>
                <input
                    type="search"
                    id="heroSearchInput"
                    class="hero-search-input"
                    placeholder="Search for a company or website…"
                    autocomplete="off"
                    aria-label="Search for a company"
                    oninput="heroDebounce()"
                    onkeydown="if(event.key==='Enter'){ event.preventDefault(); heroRunSearch(); }"
                >
                <button type="submit" class="hero-search-btn" id="heroSearchBtn">Search</button>
            </div>
        </form>

        {{-- Result preview --}}
        <div class="hero-result-wrap" id="heroResultWrap"></div>

        {{-- Category chips --}}
        <div class="hero-cats">
            <span class="hero-cat" onclick="heroFillSearch('Technology')"><i class="bi bi-cpu"></i> Technology</span>
            <span class="hero-cat" onclick="heroFillSearch('Retail')"><i class="bi bi-shop"></i> Retail</span>
            <span class="hero-cat" onclick="heroFillSearch('Healthcare')"><i class="bi bi-heart-pulse"></i> Healthcare</span>
            <span class="hero-cat" onclick="heroFillSearch('Finance')"><i class="bi bi-bank"></i> Finance</span>
            <span class="hero-cat" onclick="heroFillSearch('Legal')"><i class="bi bi-briefcase"></i> Legal</span>
            <span class="hero-cat" onclick="heroFillSearch('Real Estate')"><i class="bi bi-house"></i> Real Estate</span>
        </div>

    </div>
</section>

<script>
const _heroSearchEndpoint = "{{ route('search') }}";
let _heroTimer = null;

function heroDebounce() {
    clearTimeout(_heroTimer);
    const q = document.getElementById('heroSearchInput').value.trim();
    if (q.length < 2) { heroRenderResult(null); return; }
    _heroTimer = setTimeout(heroRunSearch, 300);
}

function heroRunSearch() {
    const q   = document.getElementById('heroSearchInput').value.trim();
    const btn = document.getElementById('heroSearchBtn');
    if (q.length < 2) { heroRenderResult(null); return; }

    btn.textContent = '…';
    btn.disabled    = true;

    fetch(_heroSearchEndpoint + '?q=' + encodeURIComponent(q))
        .then(r => r.json())
        .then(data => heroRenderResult(data, q))
        .catch(() => heroRenderResult([], q))
        .finally(() => { btn.textContent = 'Search'; btn.disabled = false; });
}

function heroFillSearch(val) {
    document.getElementById('heroSearchInput').value = val;
    heroRunSearch();
}

function _heroEsc(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(String(str)));
    return d.innerHTML;
}

function heroRenderResult(results, q) {
    const wrap = document.getElementById('heroResultWrap');
    wrap.innerHTML = '';

    if (!results) { wrap.classList.remove('active'); return; }
    wrap.classList.add('active');

    if (results.length === 0) {
        wrap.innerHTML = `<div class="hr-empty">No businesses found for "<strong>${_heroEsc(q)}</strong>". <a href="{{ route('register') }}">Add yours free →</a></div>`;
        return;
    }

    // Show top result prominently, rest as smaller rows
    results.forEach((biz, idx) => {
        const initials = biz.name.replace(/[^a-zA-Z0-9 ]/g,'').split(' ').slice(0,2).map(w=>w[0]||'').join('').toUpperCase() || '?';
        const stars    = biz.rating ? Math.round(biz.rating) : 0;
        const starsHtml = '<span style="color:#F5A623;">' + '★'.repeat(stars) + '<span style="opacity:.3;">★</span>'.repeat(5 - stars) + '</span>';

        const card = document.createElement('div');
        card.className = idx === 0 ? 'hr-card hr-card-main' : 'hr-card hr-card-sub';
        card.innerHTML = `
            ${biz.logo
                ? `<img src="${_heroEsc(biz.logo)}" class="hr-avatar hr-avatar-img" alt="${_heroEsc(biz.name)}">`
                : `<div class="hr-avatar">${_heroEsc(initials)}</div>`}
            <div style="min-width:0;flex:1;">
                <div class="hr-name">${_heroEsc(biz.name)}</div>
                <div class="hr-stars">${starsHtml}</div>
                <div class="hr-count">${biz.rating ? biz.rating + ' · ' : ''}${biz.total} ${biz.total === 1 ? 'review' : 'reviews'}</div>
            </div>
            <a href="${_heroEsc(biz.url)}" class="hr-view-btn">View <i class="bi bi-arrow-right"></i></a>`;
        wrap.appendChild(card);
    });
}
</script>
