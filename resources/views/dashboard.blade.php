<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-stack-lg">
        <!-- Loyalty Card -->
        <div class="bg-primary-container/20 border border-primary-container p-6 rounded-2xl relative overflow-hidden">
            <div class="z-10 relative">
                <p class="font-label-sm text-primary uppercase tracking-widest">Loyalty Status</p>
                <h3 class="font-headline-sm text-headline-sm mt-2 text-on-surface">Gold Member</h3>
                <p class="text-label-md mt-4 text-on-surface-variant font-bold">250 Points</p>
                <div class="w-full bg-surface-container-high h-2 rounded-full mt-2">
                    <div class="bg-primary h-full rounded-full" style="width: 65%"></div>
                </div>
                <p class="text-[10px] mt-1 text-on-surface-variant">50 more points to Platinum</p>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-primary/10 text-[120px] rotate-12">auto_awesome</span>
        </div>

        <!-- Recent Activity -->
        <div class="bg-surface-container p-6 rounded-2xl border border-outline-variant/30 flex flex-col justify-between">
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-widest">Active Orders</p>
                <h3 class="font-headline-sm text-headline-sm mt-2 text-on-surface">02</h3>
            </div>
            <a href="{{ route('customer.orders') }}" class="text-primary font-bold text-label-md flex items-center gap-2 mt-4 hover:gap-3 transition-all">
                Track Deliveries <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <!-- Savings -->
        <div class="bg-surface-container p-6 rounded-2xl border border-outline-variant/30 flex flex-col justify-between">
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-widest">Total Savings</p>
                <h3 class="font-headline-sm text-headline-sm mt-2 text-on-surface">15,000 TZS</h3>
            </div>
            <p class="text-on-surface-variant text-label-sm mt-4 italic">You've saved 5% this month!</p>
        </div>
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <!-- Order History -->
        <div class="lg:col-span-2 bg-surface-container rounded-2xl border border-outline-variant/30 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
                <h4 class="font-label-md text-on-surface uppercase font-bold">Recent Orders</h4>
                <a href="{{ route('customer.orders') }}" class="text-primary text-xs font-bold hover:underline">View All</a>
            </div>
            <div class="divide-y divide-outline-variant/20">
                <div class="p-6 flex justify-between items-center hover:bg-surface-variant/10 transition-colors">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-white rounded-lg border border-outline-variant/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary">shopping_basket</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">Order #54921</p>
                            <p class="text-xs text-on-surface-variant italic">Placed on May 15, 2026</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-primary">85,000 TZS</p>
                        <span class="text-[10px] px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold uppercase">Delivered</span>
                    </div>
                </div>
                <div class="p-6 flex justify-between items-center hover:bg-surface-variant/10 transition-colors opacity-60">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-white rounded-lg border border-outline-variant/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary">shopping_basket</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">Order #52184</p>
                            <p class="text-xs text-on-surface-variant italic">Placed on April 28, 2026</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-on-surface">120,000 TZS</p>
                        <span class="text-[10px] px-2 py-0.5 bg-gray-200 text-gray-700 rounded-full font-bold uppercase">Delivered</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist / Sidebar -->
        <div class="space-y-gutter">
            <!-- Wishlist Summary -->
            <div class="bg-surface-container rounded-2xl border border-outline-variant/30 p-6">
                <h4 class="font-label-md text-on-surface uppercase font-bold mb-6">Saved in Wishlist</h4>
                <div class="space-y-4 text-center">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-3">
                            <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center text-pink-600">
                                <span class="material-symbols-outlined text-sm">favorite</span>
                            </div>
                            <span class="text-label-md text-on-surface pt-2">Glow Serum</span>
                        </div>
                        <button class="text-primary font-bold text-xs">Add to Cart</button>
                    </div>
                    <a href="{{ route('customer.wishlist') }}" class="w-full inline-block text-center mt-4 bg-outline-variant/20 text-on-surface py-3 rounded-xl font-bold text-xs hover:bg-outline-variant/40 transition-all">Explore Wishlist</a>
                </div>
            </div>

            <!-- Saved Addresses -->
            <div class="bg-surface-container rounded-2xl border border-outline-variant/30 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-label-md text-on-surface uppercase font-bold">Shipping Address</h4>
                    <a href="{{ route('customer.addresses') }}" class="material-symbols-outlined text-primary cursor-pointer hover:rotate-90 transition-transform">edit</a>
                </div>
                <div class="p-4 bg-white/50 border border-outline-variant/10 rounded-xl">
                    <p class="font-bold text-on-surface">Home</p>
                    <p class="text-xs text-on-surface-variant mt-1">Plot 42, Mikocheni B,<br>Dar Es Salaam, Tanzania</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
