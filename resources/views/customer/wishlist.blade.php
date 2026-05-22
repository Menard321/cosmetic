<x-app-layout>
    <div class="p-6 border-b border-outline-variant/30 mb-6">
        <h4 class="font-headline-sm text-headline-sm text-on-surface">My Wishlist</h4>
        <p class="text-on-surface-variant text-sm mt-1">Products you've saved for later.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
        <!-- Item 1 -->
        <div class="bg-surface-container rounded-2xl border border-outline-variant/30 overflow-hidden group">
            <div class="relative h-48 bg-white flex items-center justify-center p-4">
                <span class="material-symbols-outlined text-[80px] text-pink-100 group-hover:scale-110 transition-transform">spa</span>
                <button class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-pink-600 hover:bg-pink-600 hover:text-white transition-all shadow-sm">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
            <div class="p-6">
                <h5 class="font-bold text-on-surface">Advanced Glow Serum</h5>
                <p class="text-xs text-on-surface-variant mt-1">Luxury Collection</p>
                <div class="flex justify-between items-center mt-6">
                    <span class="font-bold text-primary">65,000 TZS</span>
                    <button class="bg-primary text-white text-[10px] font-bold px-4 py-2 rounded-lg uppercase tracking-wider hover:bg-secondary transition-colors">Add to Cart</button>
                </div>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="bg-surface-container rounded-2xl border border-outline-variant/30 overflow-hidden group">
            <div class="relative h-48 bg-white flex items-center justify-center p-4">
                <span class="material-symbols-outlined text-[80px] text-pink-100 group-hover:scale-110 transition-transform">sanitizer</span>
                <button class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-pink-600 hover:bg-pink-600 hover:text-white transition-all shadow-sm">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
            <div class="p-6">
                <h5 class="font-bold text-on-surface">Hydrating Moisturizer</h5>
                <p class="text-xs text-on-surface-variant mt-1">Skin Repair</p>
                <div class="flex justify-between items-center mt-6">
                    <span class="font-bold text-primary">45,000 TZS</span>
                    <button class="bg-primary text-white text-[10px] font-bold px-4 py-2 rounded-lg uppercase tracking-wider hover:bg-secondary transition-colors">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
