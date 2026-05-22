<x-app-layout>
    <div class="p-6 border-b border-outline-variant/30 mb-6">
        <h4 class="font-headline-sm text-headline-sm text-on-surface">Loyalty Rewards</h4>
        <p class="text-on-surface-variant text-sm mt-1">Earn points on every purchase and unlock exclusive perks.</p>
    </div>

    <!-- Main Score Card -->
    <div class="bg-gradient-to-br from-primary to-secondary rounded-3xl p-8 text-white mb-stack-lg relative overflow-hidden shadow-xl shadow-primary/20">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <p class="uppercase text-xs tracking-[0.2em] opacity-80 font-bold mb-2">Current Tier</p>
                <h3 class="font-headline-md text-headline-md italic">Gold Member</h3>
                <div class="mt-6 flex items-center justify-center md:justify-start gap-4">
                    <div class="text-4xl font-bold">250</div>
                    <div class="text-sm opacity-80 leading-tight">Total Points<br>Available</div>
                </div>
            </div>
            
            <div class="w-full max-w-xs bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20">
                <p class="text-xs font-bold mb-4">NEXT TIER: PLATINUM (500 PTS)</p>
                <div class="w-full bg-white/20 h-3 rounded-full mb-2">
                    <div class="bg-white h-full rounded-full shadow-[0_0_10px_white]" style="width: 50%"></div>
                </div>
                <p class="text-[10px] text-right font-bold italic">250 points left to unlock free shipping on all orders!</p>
            </div>
        </div>
        <!-- Decorative elements -->
        <span class="material-symbols-outlined absolute -left-10 -bottom-10 text-[200px] text-white/5 rotate-12">stars</span>
        <span class="material-symbols-outlined absolute -right-4 top-0 text-[120px] text-white/10 -rotate-12">auto_awesome</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
        <!-- How to Earn -->
        <div class="bg-surface-container rounded-2xl border border-outline-variant/30 p-8">
            <h4 class="font-label-md text-on-surface uppercase font-bold mb-8">How to earn points</h4>
            <div class="space-y-6">
                <div class="flex gap-4 items-start">
                    <div class="w-10 h-10 bg-primary-container text-primary rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">Shop & Earn</p>
                        <p class="text-xs text-on-surface-variant mt-1">Earn 1 point for every 1,000 TZS spent on any product.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="w-10 h-10 bg-primary-container text-primary rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">rate_review</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">Review Products</p>
                        <p class="text-xs text-on-surface-variant mt-1">Get 10 points for every verified purchase review you post.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="w-10 h-10 bg-primary-container text-primary rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">celebration</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">Birthday Gift</p>
                        <p class="text-xs text-on-surface-variant mt-1">Receive 100 bonus points on your birthday every year.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tier Perks -->
        <div class="bg-surface-container rounded-2xl border border-outline-variant/30 p-8">
            <h4 class="font-label-md text-on-surface uppercase font-bold mb-8">Gold Tier Perks</h4>
            <div class="space-y-4">
                <div class="flex items-center gap-3 text-sm text-on-surface bg-white/50 p-3 rounded-lg border border-outline-variant/10">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span>10% Discount on all Luxury sets</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-on-surface bg-white/50 p-3 rounded-lg border border-outline-variant/10">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span>Early access to new product launches</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-on-surface bg-white/50 p-3 rounded-lg border border-outline-variant/10">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span>Priority customer support</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-on-surface opacity-40 p-3 rounded-lg border border-dashed border-outline-variant/30">
                    <span class="material-symbols-outlined">lock</span>
                    <span>Free Shipping (Platinum only)</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
