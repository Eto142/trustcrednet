<section id="search">
    <div class="container position-relative" style="z-index:2;">
        <div class="text-center fade-up">
            <div class="section-eyebrow eyebrow-green" style="margin-bottom:16px;">
                <i class="bi bi-search"></i> Find Trusted Businesses
            </div>
            <h2 class="search-section-headline">Search for a Business or Website</h2>
            <p class="search-section-sub mx-auto" style="max-width:480px;">
                Access authentic reviews from real customers across thousands of businesses and websites.
            </p>
        </div>

        {{-- Main Search Bar --}}
        <div class="fade-up d1">
            <form role="search" onsubmit="event.preventDefault(); runSearch();">
                <div class="main-search-wrap">
                    <input
                        type="search"
                        class="main-search-input"
                        id="mainSearchInput"
                        placeholder="Enter business name, website, or industry…"
                        autocomplete="off"
                        aria-label="Search businesses"
                        oninput="debounceSearch()"
                        onkeydown="if(event.key==='Enter'){ event.preventDefault(); runSearch(); }"
                    >
                    <div class="main-search-divider d-none d-md-block"></div>
                    <button type="submit" class="main-search-btn" id="mainSearchBtn">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>

            {{-- Live result area --}}
            <div class="search-result-area" id="mainResultArea"></div>
        </div>

        {{-- Category quick-links --}}
        <div class="search-categories fade-up d2">
            <span class="cat-chip" onclick="quickSearch('Software')"><i class="bi bi-cpu"></i>Software</span>
            <span class="cat-chip" onclick="quickSearch('Health')"><i class="bi bi-heart-pulse"></i>Health</span>
            <span class="cat-chip" onclick="quickSearch('Fitness')"><i class="bi bi-activity"></i>Fitness</span>
            <span class="cat-chip" onclick="quickSearch('Legal')"><i class="bi bi-briefcase"></i>Legal</span>
            <span class="cat-chip" onclick="quickSearch('Home')"><i class="bi bi-house"></i>Home &amp; Design</span>
            <span class="cat-chip" onclick="quickSearch('Finance')"><i class="bi bi-cash-stack"></i>Finance</span>
            <span class="cat-chip" onclick="quickSearch('Education')"><i class="bi bi-book"></i>Education</span>
        </div>

        {{-- Trust Stats Strip --}}
        <div class="search-stats-strip fade-up d3">
            <div class="ss-stat">
                <div class="ss-val">284K+</div>
                <div class="ss-lbl">Verified Reviews</div>
            </div>
            <div class="ss-stat">
                <div class="ss-val">12K+</div>
                <div class="ss-lbl">Businesses Listed</div>
            </div>
            <div class="ss-stat">
                <div class="ss-val">98%</div>
                <div class="ss-lbl">Authenticity Rate</div>
            </div>
            <div class="ss-stat">
                <div class="ss-val">50+</div>
                <div class="ss-lbl">Industries</div>
            </div>
        </div>
    </div>
</section>

<script>
const _searchEndpoint = "{{ route('search') }}";
let _searchTimer = null;

function debounceSearch() {
    clearTimeout(_searchTimer);
    const q = document.getElementById('mainSearchInput').value.trim();
    if (q.length < 2) {
        renderResults(null);
        return;
    }
    _searchTimer = setTimeout(runSearch, 300);
}

function runSearch() {
    const q = document.getElementById('mainSearchInput').value.trim();
    if (q.length < 2) { renderResults(null); return; }

    const btn = document.getElementById('mainSearchBtn');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    btn.disabled = true;

    fetch(_searchEndpoint + '?q=' + encodeURIComponent(q))
        .then(r => r.json())
        .then(data => renderResults(data, q))
        .catch(() => renderResults([], q))
        .finally(() => {
            btn.innerHTML = '<i class="bi bi-search"></i> Search';
            btn.disabled = false;
        });
}

function quickSearch(cat) {
    const input = document.getElementById('mainSearchInput');
    input.value = cat;
    runSearch();
}

function starHtml(rating) {
    if (!rating) return '';
    const full  = Math.round(rating);
    const empty = 5 - full;
    return '<span style="color:#F5A623;font-size:.85rem;">'
         + '★'.repeat(full) + '<span style="opacity:.3;">★</span>'.repeat(empty)
         + '</span>';
}

function renderResults(results, q) {
    const area = document.getElementById('mainResultArea');
    area.innerHTML = '';

    if (!results) { area.classList.remove('active'); return; }

    area.classList.add('active');

    if (results.length === 0) {
        area.innerHTML = `
            <div class="s-result-empty">
                <i class="bi bi-search" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:8px;"></i>
                No businesses found for "<strong>${_esc(q)}</strong>".
                <br><small>Try a different name or <a href="{{ route('register') }}" style="color:var(--tcn-green);">add yours free</a>.</small>
            </div>`;
        return;
    }

    results.forEach(biz => {
        const initials = biz.name.replace(/[^a-zA-Z0-9 ]/g,'').split(' ').slice(0,2).map(w => w[0]||'').join('').toUpperCase() || '?';
        const card = document.createElement('div');
        card.className = 's-result-card';
        card.innerHTML = `
            ${biz.logo
                ? `<img src="${_esc(biz.logo)}" class="s-result-avatar s-result-avatar-img" alt="${_esc(biz.name)}">`
                : `<div class="s-result-avatar">${_esc(initials)}</div>`}
            <div style="min-width:0;flex:1;">
                <div class="s-result-name">${_esc(biz.name)}</div>
                <div class="s-result-meta">
                    ${biz.rating ? starHtml(biz.rating) : ''}
                    ${biz.rating ? `<span class="s-result-rating">${biz.rating}</span>` : ''}
                    <span class="s-result-count">${biz.total} ${biz.total === 1 ? 'review' : 'reviews'}</span>
                    <span class="s-result-badge"><i class="bi bi-patch-check-fill"></i> Verified</span>
                </div>
            </div>
            <div class="s-result-actions">
                <a href="${_esc(biz.url)}" class="s-result-link">
                    <i class="bi bi-eye me-1"></i>View Reviews
                </a>
            </div>`;
        area.appendChild(card);
    });
}

function _esc(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(String(str)));
    return d.innerHTML;
}
</script>
