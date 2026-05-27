<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Back Button -->
        <a href="{{ route('customer.orders') }}" class="flex items-center gap-2 text-pink-600 font-bold hover:gap-3 transition-all duration-300">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to My Bag
        </a>

        <!-- Header Card -->
        <div class="bg-white p-8 rounded-3xl border border-pink-100 shadow-xl shadow-pink-500/5">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-black text-on-surface">Order SB-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-on-surface-variant font-medium">Placed on {{ $order->created_at->format('F d, Y') }} at {{ $order->created_at->format('H:i') }}</p>
                </div>
                <div class="px-6 py-2 rounded-2xl bg-pink-50 text-pink-600 font-black uppercase tracking-widest text-xs border border-pink-100">
                    {{ $order->status }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Items Card -->
            <div class="bg-white p-8 rounded-3xl border border-outline-variant/30">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-pink-600">shopping_bag</span>
                    Your Beauty Selection
                </h3>
                <div class="space-y-6">
                    @foreach($order->items as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-surface-container rounded-xl overflow-hidden border border-outline-variant/20">
                                <img src="{{ $item->product->image }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-on-surface capitalize">{{ $item->product->name }}</p>
                                <p class="text-xs text-on-surface-variant">Qty: {{ $item->quantity }} × {{ number_format($item->price) }} TZS</p>
                            </div>
                            <p class="font-bold text-pink-600">{{ number_format($item->price * $item->quantity) }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 pt-6 border-t border-outline-variant/20 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-on-surface-variant">Shipping Fee</span>
                        <span class="font-bold">15,000 TZS</span>
                    </div>
                    <div class="flex justify-between text-xl font-black">
                        <span>Total Paid</span>
                        <span class="text-pink-600">{{ number_format($order->total_amount) }} TZS</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Details Card -->
            <div class="bg-white p-8 rounded-3xl border border-outline-variant/30 flex flex-col">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-pink-600">location_on</span>
                    Delivery Point
                </h3>
                
                <div class="space-y-6 flex-1">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-pink-600 mb-1">Shipping Address</p>
                        <p class="text-on-surface leading-snug font-medium">{{ $order->delivery_address }}</p>
                    </div>

                    @if($order->delivery_notes)
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-pink-600 mb-1">Rider Instructions</p>
                        <p class="text-on-surface italic text-sm">"{{ $order->delivery_notes }}"</p>
                    </div>
                    @endif

                    <!-- Map Display -->
                    <div class="relative overflow-hidden rounded-2xl border border-pink-50 h-48 w-full mt-4">
                        @if($order->latitude && $order->longitude)
                            <div id="order-map" class="h-full w-full"></div>
                        @else
                            <div class="h-full w-full bg-pink-50 flex flex-col items-center justify-center text-pink-300 gap-2">
                                <span class="material-symbols-outlined text-4xl">map</span>
                                <p class="text-[10px] font-bold uppercase">No GPS coordinates</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($order->latitude && $order->longitude)
    <!-- Leaflet Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $order->latitude }};
            const lng = {{ $order->longitude }};
            
            const map = L.map('order-map', {
                zoomControl: false,
                dragging: false,
                touchZoom: false,
                scrollWheelZoom: false,
                doubleClickZoom: false
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const pinkIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color: #ec4899; width: 24px; height: 24px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 2px solid white; box-shadow: 0 4px 10px rgba(236,72,153,0.3);"></div>`,
                iconSize: [24, 24],
                iconAnchor: [12, 24]
            });

            L.marker([lat, lng], { icon: pinkIcon }).addTo(map);
        });
    </script>
    @endif
</x-app-layout>
