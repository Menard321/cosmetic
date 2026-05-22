<x-app-layout>
    <div class="p-6 border-b border-outline-variant/30 mb-6 flex justify-between items-center">
        <div>
            <h4 class="font-headline-sm text-headline-sm text-on-surface">Notifications</h4>
            <p class="text-on-surface-variant text-sm mt-1">Stay updated on your orders and offers.</p>
        </div>
        <button class="text-primary text-xs font-bold hover:underline">Mark all as read</button>
    </div>

    <div class="bg-surface-container rounded-2xl border border-outline-variant/30 overflow-hidden">
        <div class="divide-y divide-outline-variant/20">
            <!-- Unread Notification -->
            <div class="p-6 flex gap-4 bg-primary-container/5 hover:bg-primary-container/10 transition-colors">
                <div class="w-10 h-10 bg-primary-container text-primary rounded-full flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">local_shipping</span>
                </div>
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <h5 class="font-bold text-on-surface">Order Out for Delivery</h5>
                        <span class="text-[10px] text-primary font-bold">JUST NOW</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Your order #54921 is out for delivery! Our rider is on the way.</p>
                </div>
                <div class="w-2 h-2 bg-primary rounded-full mt-2"></div>
            </div>

            <!-- Read Notification -->
            <div class="p-6 flex gap-4 hover:bg-surface-variant/10 transition-colors">
                <div class="w-10 h-10 bg-surface-variant text-on-surface-variant rounded-full flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">redeem</span>
                </div>
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <h5 class="font-bold text-on-surface">Loyalty Points Earned</h5>
                        <span class="text-[10px] text-on-surface-variant">2 DAYS AGO</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">You earned 50 points from your last purchase! Keep going to reach Gold status.</p>
                </div>
            </div>

            <!-- Promotion -->
            <div class="p-6 flex gap-4 hover:bg-surface-variant/10 transition-colors">
                <div class="w-10 h-10 bg-secondary-container text-secondary rounded-full flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">percent</span>
                </div>
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <h5 class="font-bold text-on-surface">Weekend Flash Sale!</h5>
                        <span class="text-[10px] text-on-surface-variant">5 DAYS AGO</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Get up to 30% off on all luxury collections this weekend only.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
