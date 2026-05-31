<!-- Search Overlay -->
<div id="searchOverlay" class="fixed inset-0 z-[100]" style="display:none;">
    <!-- Backdrop -->
    <div id="searchBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300" onclick="closeSearchOverlay()"></div>
    
    <!-- Search Panel -->
    <div class="absolute top-0 left-0 right-0 z-10 bg-heritage-white shadow-2xl transition-all duration-400" id="searchPanel" style="transform: translateY(-100%); opacity: 0;">
        <div class="container mx-auto px-6 py-8 relative">
            <!-- Close Button -->
            <button onclick="closeSearchOverlay()" class="absolute top-4 right-6 text-deep-maroon/60 hover:text-deep-maroon transition-colors" aria-label="Close search">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Search Input -->
            <div class="max-w-3xl mx-auto">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-deep-maroon/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Search for sarees, collections, fabrics..." 
                        class="w-full pl-14 pr-4 py-5 text-xl border-b-2 border-royal-gold/30 focus:border-royal-gold bg-transparent text-deep-maroon placeholder-deep-maroon/40 outline-none font-serif transition-colors"
                        autocomplete="off"
                    >
                    <!-- Loading Spinner -->
                    <div id="searchSpinner" class="absolute right-4 top-1/2 -translate-y-1/2 hidden">
                        <svg class="animate-spin w-5 h-5 text-royal-gold" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Search Results -->
                <div id="searchResults" class="mt-6 max-h-[60vh] overflow-y-auto hidden">
                    <!-- Results will be injected here -->
                </div>

                <!-- Default State -->
                <div id="searchDefault" class="mt-8 text-center">
                    <p class="text-deep-maroon/50 text-sm">Start typing to search across our entire collection</p>
                    <div class="flex flex-wrap justify-center gap-2 mt-4">
                        <button onclick="quickSearch('Silk')" class="px-4 py-2 bg-soft-cream text-deep-maroon/70 rounded-full text-sm hover:bg-royal-gold/10 hover:text-deep-maroon transition-colors">Silk</button>
                        <button onclick="quickSearch('Kanchipuram')" class="px-4 py-2 bg-soft-cream text-deep-maroon/70 rounded-full text-sm hover:bg-royal-gold/10 hover:text-deep-maroon transition-colors">Kanchipuram</button>
                        <button onclick="quickSearch('Wedding')" class="px-4 py-2 bg-soft-cream text-deep-maroon/70 rounded-full text-sm hover:bg-royal-gold/10 hover:text-deep-maroon transition-colors">Wedding</button>
                        <button onclick="quickSearch('Cotton')" class="px-4 py-2 bg-soft-cream text-deep-maroon/70 rounded-full text-sm hover:bg-royal-gold/10 hover:text-deep-maroon transition-colors">Cotton</button>
                        <button onclick="quickSearch('Banarasi')" class="px-4 py-2 bg-soft-cream text-deep-maroon/70 rounded-full text-sm hover:bg-royal-gold/10 hover:text-deep-maroon transition-colors">Banarasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let searchTimeout;

function openSearchOverlay() {
    const overlay = document.getElementById('searchOverlay');
    const panel = document.getElementById('searchPanel');
    const backdrop = document.getElementById('searchBackdrop');
    
    // Show overlay container
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Force browser repaint before animating
    void overlay.offsetHeight;
    
    // Animate backdrop and panel in
    backdrop.style.opacity = '1';
    panel.style.transform = 'translateY(0)';
    panel.style.opacity = '1';
    
    // Focus input after animation
    setTimeout(() => {
        document.getElementById('searchInput').focus();
    }, 350);
}

function closeSearchOverlay() {
    const overlay = document.getElementById('searchOverlay');
    const panel = document.getElementById('searchPanel');
    const backdrop = document.getElementById('searchBackdrop');
    
    // Animate out
    backdrop.style.opacity = '0';
    panel.style.transform = 'translateY(-100%)';
    panel.style.opacity = '0';
    
    setTimeout(() => {
        overlay.style.display = 'none';
        document.body.style.overflow = '';
        document.getElementById('searchInput').value = '';
        document.getElementById('searchResults').classList.add('hidden');
        document.getElementById('searchResults').innerHTML = '';
        document.getElementById('searchDefault').classList.remove('hidden');
    }, 400);
}

function quickSearch(term) {
    const input = document.getElementById('searchInput');
    input.value = term;
    performSearch(term);
}

function performSearch(query) {
    const resultsContainer = document.getElementById('searchResults');
    const defaultState = document.getElementById('searchDefault');
    const spinner = document.getElementById('searchSpinner');

    if (query.length < 2) {
        resultsContainer.classList.add('hidden');
        resultsContainer.innerHTML = '';
        defaultState.classList.remove('hidden');
        return;
    }

    defaultState.classList.add('hidden');
    spinner.classList.remove('hidden');

    fetch(`{{ route('products.search') }}?q=${encodeURIComponent(query)}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        spinner.classList.add('hidden');
        resultsContainer.classList.remove('hidden');

        if (data.products.length === 0) {
            resultsContainer.innerHTML = `
                <div class="text-center py-10">
                    <svg class="w-16 h-16 text-deep-maroon/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-deep-maroon/60 text-lg">No results found for "<strong>${query}</strong>"</p>
                    <p class="text-deep-maroon/40 text-sm mt-2">Try a different search term or browse our collections</p>
                </div>
            `;
            return;
        }

        let html = `<div class="flex items-center justify-between mb-4">
            <p class="text-deep-maroon/60 text-sm">${data.total} result${data.total !== 1 ? 's' : ''} found</p>
            <a href="${data.view_all_url}" class="text-royal-gold hover:text-deep-maroon text-sm font-semibold transition-colors">View All Results &rarr;</a>
        </div>`;

        html += '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">';
        data.products.forEach(product => {
            html += `
                <a href="${product.url}" class="group flex sm:block items-center gap-4 p-3 rounded-lg hover:bg-soft-cream transition-colors border border-transparent hover:border-royal-gold/10">
                    <div class="w-16 h-16 sm:w-full sm:h-48 flex-shrink-0 rounded-md overflow-hidden bg-soft-cream">
                        ${product.image 
                            ? `<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">` 
                            : `<div class="w-full h-full flex items-center justify-center"><svg class="w-8 h-8 text-deep-maroon/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
                        }
                    </div>
                    <div class="sm:mt-3 min-w-0">
                        ${product.category ? `<span class="text-xs text-royal-gold font-medium uppercase tracking-wider">${product.category}</span>` : ''}
                        <h4 class="font-serif text-deep-maroon text-sm sm:text-base truncate group-hover:text-royal-gold transition-colors">${product.name}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            ${product.original_price ? `<span class="text-deep-maroon/40 line-through text-xs">${product.original_price}</span>` : ''}
                            <span class="text-royal-gold font-semibold">${product.price}</span>
                            ${product.discount ? `<span class="text-xs bg-red-500 text-white px-1.5 py-0.5 rounded-full">${product.discount}</span>` : ''}
                        </div>
                    </div>
                </a>
            `;
        });
        html += '</div>';

        if (data.total >= 8) {
            html += `<div class="text-center mt-6 pb-2">
                <a href="${data.view_all_url}" class="cta-premium inline-block bg-deep-maroon text-heritage-white px-8 py-3 font-semibold rounded-sm shadow-lg text-sm">
                    View All Results
                </a>
            </div>`;
        }

        resultsContainer.innerHTML = html;
    })
    .catch(() => {
        spinner.classList.add('hidden');
        resultsContainer.classList.remove('hidden');
        resultsContainer.innerHTML = '<p class="text-center text-deep-maroon/50 py-8">Something went wrong. Please try again.</p>';
    });
}

// Live search with debounce
document.getElementById('searchInput')?.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value.trim();
    searchTimeout = setTimeout(() => performSearch(query), 300);
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('searchOverlay').classList.contains('hidden')) {
        closeSearchOverlay();
    }
});

// Allow Enter to go to full results
document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && this.value.trim().length >= 2) {
        window.location.href = `{{ route('products') }}?search=${encodeURIComponent(this.value.trim())}`;
    }
});
</script>
