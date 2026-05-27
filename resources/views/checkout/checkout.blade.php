@extends('layouts.master')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet Search (Optional but good) - We will use Nominatim directly -->
<style>
    #delivery-map {
        height: 400px;
        width: 100%;
        border-radius: 1rem;
        border: 2px solid rgba(236, 72, 153, 0.1);
        z-index: 1;
    }
    .map-card-premium {
        background: white;
        border: 1px solid rgba(236, 72, 153, 0.1);
        box-shadow: 0 10px 30px -10px rgba(236, 72, 153, 0.1);
        transition: all 0.5s ease;
    }
    .map-card-premium:hover {
        box-shadow: 0 20px 40px -10px rgba(236, 72, 153, 0.15);
    }
    .search-results-container {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        z-index: 1000;
        border-radius: 0.5rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        display: none;
        max-height: 200px;
        overflow-y: auto;
    }
    .search-result-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.875rem;
    }
    .search-result-item:hover {
        background: #fdf2f8;
    }
    .payment-card.selected {
        border-color: #ec4899;
        background-color: #fdf2f8;
    }
    .payment-card.selected .selection-indicator {
        border-color: #ec4899;
    }
    .payment-card.selected .selection-indicator div {
        transform: scale(1);
    }
    .payment-card.selected img {
        filter: grayscale(0) !important;
    }
    .bank-pill.active {
        border-color: #ec4899;
        background-color: #fdf2f8;
        box-shadow: 0 4px 12px rgba(236,72,153,0.1);
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up { animation: slideUp 0.4s ease-out forwards; }
</style>

<section class="py-stack-lg bg-surface-container-low min-h-screen">
    <div class="px-margin-mobile md:px-margin-desktop max-w-[1200px] mx-auto">
        <h1 class="font-headline-md text-headline-md text-pink-600 mb-stack-lg">Angels Beauty <span class="text-on-surface font-light">| Checkout</span></h1>

        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <!-- Hidden Fields for Location Data -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
                <!-- Shipping & Payment Info -->
                <div class="lg:col-span-12 xl:col-span-8 space-y-gutter">
                    
                    <!-- 1. Delivery & Location -->
                    <div class="map-card-premium p-6 md:p-8 rounded-3xl">
                        <div class="flex items-center gap-4 mb-8">
                            <span class="w-10 h-10 rounded-2xl bg-pink-500 text-white flex items-center justify-center font-bold shadow-lg shadow-pink-200">1</span>
                            <div>
                                <h2 class="font-bold text-on-surface text-lg">Delivery Exact Location</h2>
                                <p class="text-xs text-on-surface-variant italic">Pinpoint your house/office for the Angels rider</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Address Input & Map Search -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <label class="label-premium block mb-2 text-pink-600 uppercase text-[10px] font-bold tracking-widest">Search Street / Landmark</label>
                                    <div class="relative">
                                        <input type="text" id="address-search" class="form-input-premium w-full pr-10" placeholder="e.g. Masaki, Posta, Mikocheni...">
                                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-pink-400">search</span>
                                        <div id="search-results" class="search-results-container"></div>
                                    </div>
                                </div>
                                <div>
                                    <label class="label-premium block mb-2 text-pink-600 uppercase text-[10px] font-bold tracking-widest">Full Delivery Address</label>
                                    <input type="text" name="address" id="full-address" class="form-input-premium w-full" placeholder="House/Apartment Number, Floor..." required>
                                </div>
                            </div>

                            <!-- Interactive Map Area -->
                            <div class="relative">
                                <div id="delivery-map"></div>
                                
                                <!-- Map Overlay Controls -->
                                <div class="absolute top-4 right-4 z-[1000] flex flex-col gap-2">
                                    <button type="button" id="locate-me" class="bg-white text-pink-600 p-3 rounded-2xl shadow-xl border border-pink-50 hover:bg-pink-50 transition-all flex items-center gap-2 font-bold text-xs uppercase tracking-tight">
                                        <span class="material-symbols-outlined text-sm">my_location</span>
                                        Locate Me
                                    </button>
                                </div>

                                <div class="absolute bottom-4 left-4 right-4 z-[1000] lg:hidden">
                                     <div class="bg-white/90 backdrop-blur-md p-3 rounded-xl border border-pink-100 text-[10px] text-pink-600 font-bold text-center">
                                        Drag the Pink Pin to your exact door
                                     </div>
                                </div>
                            </div>

                            <div>
                                <label class="label-premium block mb-2 text-pink-600 uppercase text-[10px] font-bold tracking-widest">Delivery Notes (Optional)</label>
                                <textarea name="delivery_notes" rows="2" class="form-input-premium w-full" placeholder="e.g. Ring the bell, Gate is blue..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-pink-50">
                                <div>
                                    <label class="label-premium block mb-2 text-pink-600 uppercase text-[10px] font-bold tracking-widest">Receiver Name</label>
                                    <input type="text" class="form-input-premium w-full bg-pink-50/30" value="{{ auth()->user()->name }}" required>
                                </div>
                                <div>
                                    <label class="label-premium block mb-2 text-pink-600 uppercase text-[10px] font-bold tracking-widest">Receiver Phone</label>
                                    <input type="text" name="delivery_phone" class="form-input-premium w-full bg-pink-50/30" placeholder="+255..." required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Payment Gateway -->
                    <div class="bg-white p-8 border border-outline-variant/20 shadow-sm rounded-[2rem]">
                        <div class="flex items-center gap-4 mb-8">
                            <span class="w-10 h-10 rounded-2xl bg-pink-600 text-white flex items-center justify-center font-bold shadow-lg shadow-pink-100 italic">2</span>
                            <div>
                                <h2 class="font-bold text-on-surface text-lg uppercase tracking-widest">Select Payment Method</h2>
                                <p class="text-[10px] text-pink-500 font-bold uppercase tracking-tighter">Automatic STK Push Supported for Mobile Money</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- M-Pesa Card -->
                            <label class="payment-card relative flex flex-col p-5 border-2 border-outline-variant/20 rounded-3xl cursor-pointer transition-all duration-500 hover:border-pink-300 hover:bg-pink-50/10 group">
                                <input type="radio" name="payment_method" value="mpesa" class="hidden-radio absolute top-4 right-4" required>
                                <div class="flex justify-between items-start mb-4">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/M-Pesa_Logo.svg/1024px-M-Pesa_Logo.svg.png" class="h-8 object-contain transition-all" alt="M-Pesa" onerror="this.src='https://placehold.co/100x40/ED1C24/white?text=M-Pesa'">
                                    <div class="selection-indicator w-5 h-5 rounded-full border-2 border-outline-variant/30 flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-pink-500 rounded-full scale-0 transition-transform"></div>
                                    </div>
                                </div>
                                <span class="font-black text-on-surface text-sm">Vodacom M-Pesa</span>
                                <p class="text-[10px] text-on-surface-variant mt-1">Pay instantly with your Vodacom number</p>
                            </label>

                            <!-- Tigo Pesa Card -->
                            <label class="payment-card relative flex flex-col p-5 border-2 border-outline-variant/20 rounded-3xl cursor-pointer transition-all duration-500 hover:border-pink-300 hover:bg-pink-50/10 group">
                                <input type="radio" name="payment_method" value="tigopesa" class="hidden-radio absolute top-4 right-4">
                                <div class="flex justify-between items-start mb-4">
                                    <img src="https://upload.wikimedia.org/wikipedia/en/2/23/Tigo_Logo_2016.svg" class="h-8 object-contain transition-all" alt="Tigo Pesa" onerror="this.src='https://placehold.co/100x40/0054A6/white?text=Tigo+Pesa'">
                                    <div class="selection-indicator w-5 h-5 rounded-full border-2 border-outline-variant/30 flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-pink-500 rounded-full scale-0 transition-transform"></div>
                                    </div>
                                </div>
                                <span class="font-black text-on-surface text-sm">Tigo Pesa</span>
                                <p class="text-[10px] text-on-surface-variant mt-1">Safe and fast Tigo mobile payments</p>
                            </label>

                            <!-- Airtel Money Card -->
                            <label class="payment-card relative flex flex-col p-5 border-2 border-outline-variant/20 rounded-3xl cursor-pointer transition-all duration-500 hover:border-pink-300 hover:bg-pink-50/10 group">
                                <input type="radio" name="payment_method" value="airtelmoney" class="hidden-radio absolute top-4 right-4">
                                <div class="flex justify-between items-start mb-4">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Airtel_logo_2010.svg/1024px-Airtel_logo_2010.svg.png" class="h-6 object-contain transition-all" alt="Airtel Money" onerror="this.src='https://placehold.co/100x40/FF0000/white?text=Airtel'">
                                    <div class="selection-indicator w-5 h-5 rounded-full border-2 border-outline-variant/30 flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-pink-500 rounded-full scale-0 transition-transform"></div>
                                    </div>
                                </div>
                                <span class="font-black text-on-surface text-sm mt-1">Airtel Money</span>
                                <p class="text-[10px] text-on-surface-variant mt-1">Secure payments for Airtel customers</p>
                            </label>

                            <!-- Bank Transfer Card -->
                            <label class="payment-card relative flex flex-col p-5 border-2 border-outline-variant/20 rounded-3xl cursor-pointer transition-all duration-500 hover:border-pink-300 hover:bg-pink-50/10 group">
                                <input type="radio" name="payment_method" value="bank" class="hidden-radio absolute top-4 right-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex gap-2">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b3/CRDB_Bank_Logo.png" class="h-6 object-contain transition-all" onerror="this.src='https://placehold.co/60x30/1A8C34/white?text=CRDB'">
                                        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/4/4e/NMB_Bank_logo.svg/1024px-NMB_Bank_logo.svg.png" class="h-6 object-contain transition-all" onerror="this.src='https://placehold.co/60x30/0054A6/white?text=NMB'">
                                    </div>
                                    <div class="selection-indicator w-5 h-5 rounded-full border-2 border-outline-variant/30 flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-pink-500 rounded-full scale-0 transition-transform"></div>
                                    </div>
                                </div>
                                <span class="font-black text-on-surface text-sm">TZ Local Bank</span>
                                <p class="text-[10px] text-on-surface-variant mt-1">Manual transfer via CRDB, NMB, or NBC</p>
                            </label>
                        </div>

                        <!-- Payment Phone Number Inputs -->
                        <div id="payment_phone_container" class="mt-8 hidden p-6 bg-pink-50/50 rounded-3xl border border-pink-100 animate-slide-up">
                            <label class="label-premium block mb-3 text-pink-600 uppercase text-[10px] font-black tracking-widest">Phone Number for STK Push</label>
                            <div class="relative">
                                <input type="text" name="payment_phone_number" id="payment_phone_number" class="form-input-premium w-full pl-12 text-lg font-bold tracking-widest" placeholder="07XXXXXXXX">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-bold text-sm">+255</span>
                            </div>
                            <div class="flex items-center gap-2 mt-4 text-[10px] text-pink-500 font-bold italic">
                                <span class="material-symbols-outlined text-sm">lock</span>
                                Secure direct payment prompt will appear on your phone
                            </div>
                        </div>

                        <!-- Bank Selection Inputs -->
                        <div id="bank_details_container" class="mt-8 hidden p-8 bg-surface-variant/10 rounded-[2rem] border-2 border-dashed border-outline-variant/30 animate-scale-in">
                            <h3 class="font-black text-on-surface text-sm uppercase tracking-wider mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-pink-500">account_balance</span>
                                Select Your Preferred Bank
                            </h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-8">
                                <button type="button" onclick="selectBank('CRDB')" class="bank-pill flex items-center justify-center p-4 border border-outline-variant/30 rounded-2xl hover:border-pink-500 transition-all group">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b3/CRDB_Bank_Logo.png" class="h-6 object-contain" onerror="this.src='https://placehold.co/60x30/1A8C34/white?text=CRDB'">
                                </button>
                                <button type="button" onclick="selectBank('NMB')" class="bank-pill flex items-center justify-center p-4 border border-outline-variant/30 rounded-2xl hover:border-pink-500 transition-all group">
                                    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/4/4e/NMB_Bank_logo.svg/1024px-NMB_Bank_logo.svg.png" class="h-6 object-contain" onerror="this.src='https://placehold.co/60x30/0054A6/white?text=NMB'">
                                </button>
                                <button type="button" onclick="selectBank('NBC')" class="bank-pill flex items-center justify-center p-4 border border-outline-variant/30 rounded-2xl hover:border-pink-500 transition-all group">
                                    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/5/5e/NBC_Bank_Logo.png/640px-NBC_Bank_Logo.png" class="h-6 object-contain" onerror="this.src='https://placehold.co/60x30/0054A6/white?text=NBC'">
                                </button>
                            </div>

                            <input type="hidden" name="bank_name" id="selected_bank">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-4">
                                    <label class="label-premium block text-[10px] font-black uppercase tracking-widest text-pink-600">Account Name</label>
                                    <input type="text" name="bank_account_name" id="bank_account_name" class="form-input-premium w-full" placeholder="Full name on account">
                                </div>
                                <div class="space-y-4">
                                    <label class="label-premium block text-[10px] font-black uppercase tracking-widest text-pink-600">Account Number</label>
                                    <input type="text" name="bank_account_number" id="bank_account_number" class="form-input-premium w-full" placeholder="015xxxxxxxxx">
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex items-start gap-4">
                             <span class="material-symbols-outlined text-pink-600">info</span>
                             <p class="text-[10px] text-on-surface-variant leading-relaxed">
                                <span class="font-black text-pink-600 italic">IMPORTANT:</span> 
                                Please ensure your payment phone has enough balance.Angels Beauty processes mobile money instantly to prioritize your delivery slot.
                             </p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-12 xl:col-span-4">
                    <div class="bg-on-background p-8 sticky top-24 border border-outline-variant/20 shadow-2xl rounded-3xl text-white">
                        <h2 class="font-bold uppercase tracking-widest text-pink-400 border-b border-white/10 pb-4 mb-6">Review Angels Bag</h2>
                        
                        <div class="max-h-60 overflow-y-auto mb-6 pr-2 space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between items-center gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-white/10 rounded-xl shrink-0 overflow-hidden border border-white/5">
                                            <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold line-clamp-1 capitalize">{{ $item['name'] }}</p>
                                            <p class="text-[10px] text-white/50">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                    </div>
                                    <p class="text-xs font-bold">{{ number_format($item['price'] * $item['quantity']) }} TZS</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 mb-8 pt-6 border-t border-white/10">
                            <div class="flex justify-between text-sm">
                                <span class="text-white/60">Subtotal</span>
                                <span class="font-bold text-white">{{ number_format($subtotal) }} TZS</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-white/60">Shipping (Dar)</span>
                                <span class="font-bold text-white">{{ number_format($shipping) }} TZS</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-white/60">VAT (18%)</span>
                                <span class="font-bold text-white">{{ number_format($vat) }} TZS</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-pink-500/30 pt-6 mb-8 flex justify-between items-baseline">
                            <span class="text-xl font-bold">Total</span>
                            <span class="text-2xl font-black text-pink-400">{{ number_format($total) }} TZS</span>
                        </div>

                        <button type="submit" id="place-order-btn" class="w-full bg-pink-500 text-white text-center py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-pink-400 shadow-xl shadow-pink-500/20 transition-all active:scale-95">
                            Place Beauty Order
                        </button>

                        <div class="mt-6 flex items-center justify-center gap-4 opacity-40">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            <span class="text-[8px] font-bold uppercase tracking-[0.3em]">Encrypted Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Map Initialization (Dar es Salaam) ---
        const defaultLat = -6.7924;
        const defaultLng = 39.2083;
        
        const map = L.map('delivery-map', {
            zoomControl: false // Customizing zoom position
        }).setView([defaultLat, defaultLng], 13);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // --- 2. Marker Setup (Pink Elegant Pin) ---
        const pinkIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `
                <div style="background-color: #ec4899; width: 30px; height: 300px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; position: relative; border: 3px solid white; box-shadow: 0 5px 15px rgba(236,72,153,0.4);">
                    <div style="width: 10px; height: 10px; background: white; border-radius: 50%; transform: rotate(45deg);"></div>
                </div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 30]
        });

        const marker = L.marker([defaultLat, defaultLng], {
            draggable: true,
            icon: pinkIcon
        }).addTo(map);

        // Update hidden inputs and address when marker moves
        const updateCoords = (lat, lng) => {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
        };

        marker.on('dragend', function(e) {
            const pos = marker.getLatLng();
            updateCoords(pos.lat, pos.lng);
            reverseGeocode(pos.lat, pos.lng);
        });

        // Click map to move marker
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoords(e.latlng.lat, e.latlng.lng);
            reverseGeocode(e.latlng.lat, e.latlng.lng);
        });

        // Initialize with default
        updateCoords(defaultLat, defaultLng);

        // --- 3. Geolocation (Locate Me) ---
        document.getElementById('locate-me').addEventListener('click', function() {
            if (navigator.geolocation) {
                const btn = this;
                btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span> Locating...';
                
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    map.setView([lat, lng], 17);
                    marker.setLatLng([lat, lng]);
                    updateCoords(lat, lng);
                    reverseGeocode(lat, lng);
                    
                    btn.innerHTML = '<span class="material-symbols-outlined text-sm">my_location</span> Locate Me';
                }, function(err) {
                    alert('Could not detect location. Please select manually on map.');
                    btn.innerHTML = '<span class="material-symbols-outlined text-sm">my_location</span> Locate Me';
                });
            }
        });

        // --- 4. Address Search (Nominatim) ---
        const searchInput = document.getElementById('address-search');
        const resultsContainer = document.getElementById('search-results');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;
            
            if (query.length < 3) {
                resultsContainer.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=5&countrycodes=tz`)
                    .then(res => res.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        if (data.length > 0) {
                            resultsContainer.style.display = 'block';
                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'search-result-item';
                                div.innerText = item.display_name;
                                div.onclick = () => {
                                    const lat = parseFloat(item.lat);
                                    const lon = parseFloat(item.lon);
                                    map.setView([lat, lon], 16);
                                    marker.setLatLng([lat, lon]);
                                    updateCoords(lat, lon);
                                    document.getElementById('full-address').value = item.display_name;
                                    resultsContainer.style.display = 'none';
                                    searchInput.value = '';
                                };
                                resultsContainer.appendChild(div);
                            });
                        }
                    });
            }, 300);
        });

        // Close search results on outside click
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target)) resultsContainer.style.display = 'none';
        });

        // Reverse Geocoding (Lat/Lng to Address)
        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('full-address').value = data.display_name;
                    }
                });
        }

        // --- 5. Payment Logic ---
        const paymentCards = document.querySelectorAll('.payment-card');
        const phoneContainer = document.getElementById('payment_phone_container');
        const bankContainer = document.getElementById('bank_details_container');
        const phoneInput = document.getElementById('payment_phone_number');
        const mobileMethods = ['mpesa', 'tigopesa', 'airtelmoney'];
        
        paymentCards.forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            
            card.addEventListener('click', function() {
                // Clear all selected states
                paymentCards.forEach(c => c.classList.remove('selected'));
                // Add selected state to this card
                card.classList.add('selected');
                radio.checked = true;

                // Toggle visibility based on value
                if (mobileMethods.includes(radio.value)) {
                    phoneContainer.classList.remove('hidden');
                    bankContainer.classList.add('hidden');
                    phoneInput.setAttribute('required', 'required');
                } else if (radio.value === 'bank') {
                    bankContainer.classList.remove('hidden');
                    phoneContainer.classList.add('hidden');
                    phoneInput.removeAttribute('required');
                } else {
                    phoneContainer.classList.add('hidden');
                    bankContainer.classList.add('hidden');
                }
            });
        });

        // Bank Selection Helper
        window.selectBank = function(bank) {
            document.getElementById('selected_bank').value = bank;
            const pills = document.querySelectorAll('.bank-pill');
            pills.forEach(p => p.classList.remove('active'));
            event.currentTarget.classList.add('active');
            
            // Set Placeholder based on bank
            const accNum = document.getElementById('bank_account_number');
            if(bank === 'CRDB') accNum.placeholder = 'e.g. 0152XXXXXXXX';
            if(bank === 'NMB') accNum.placeholder = 'e.g. 211XXXXXXXX';
        };

        // Form Validation before submit
        document.getElementById('place-order-btn').addEventListener('click', function(e) {
            const lat = document.getElementById('latitude').value;
            if (!lat || lat == defaultLat.toFixed(6)) {
                // We allow default but maybe warn?
            }
        });
    });
</script>
@endsection
