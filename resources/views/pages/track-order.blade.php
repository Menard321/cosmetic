@extends('layouts.master')

@section('content')
<section class="py-24 bg-on-background min-h-screen relative overflow-hidden">
    <!-- Luxury Background Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 blur-[100px] rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary/5 blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-black text-white mb-4">Track Your Bag</h1>
            <p class="text-primary tracking-[0.2em] uppercase font-bold text-sm">Real-Time Luxury Delivery Tracking</p>
        </div>
        
        @if(session('error'))
            <div class="mb-8 p-4 bg-red-500/20 border border-red-500/50 rounded-2xl text-red-200 text-center text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white/5 backdrop-blur-xl p-10 rounded-[3rem] border border-white/10 shadow-2xl">
            <div class="max-w-md mx-auto space-y-8">
                @if(!isset($order))
                <form action="{{ route('pages.track-order.search') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="text-center">
                        <p class="text-white/60 text-sm mb-6">Enter your Order ID or Tracking Number found in your confirmation email.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="relative">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-primary mb-2">Order Identification</label>
                            <input type="text" name="tracking_code" value="{{ old('tracking_code') }}" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-white/20 focus:border-primary focus:ring-0 transition-all" placeholder="e.g. SB-54921" required>
                        </div>
                        
                        <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-primary/80 transition-all shadow-xl shadow-primary/20">
                            Locate My Order
                        </button>
                    </div>
                </form>
                @else
                <!-- Results Display -->
                <div class="animate-slide-up">
                    <div class="text-center mb-10">
                        <span class="bg-primary/20 text-primary px-4 py-1 rounded-full text-[10px] font-black tracking-widest uppercase">Result Found</span>
                        <h2 class="text-white text-3xl font-black mt-4 uppercase tracking-tighter">Order SB-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
                        <p class="text-white/40 text-xs mt-2 uppercase tracking-widest">Current Status: <span class="text-white">{{ $order->status }}</span></p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="relative flex justify-between items-center px-4 mb-12">
                        <div class="absolute left-8 right-8 top-1/2 -translate-y-1/2 h-0.5 bg-white/10"></div>
                        <div class="absolute left-8 {{ $order->status === 'delivered' ? 'right-8' : ($order->status === 'shipped' ? 'right-1/2' : 'right-[80%]') }} top-1/2 -translate-y-1/2 h-0.5 bg-primary transition-all duration-1000"></div>

                        <!-- Step 1 -->
                        <div class="relative z-10 text-center">
                            <div class="w-10 h-10 rounded-full {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'bg-primary text-white' : 'bg-white/10 text-white/40' }} flex items-center justify-center mx-auto mb-2 shadow-lg">
                                <span class="material-symbols-outlined text-sm">inventory_2</span>
                            </div>
                            <p class="text-[8px] font-bold text-white uppercase">Pending</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative z-10 text-center">
                            <div class="w-10 h-10 rounded-full {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-primary text-white' : 'bg-white/10 text-white/40' }} flex items-center justify-center mx-auto mb-2 shadow-lg">
                                <span class="material-symbols-outlined text-sm">precision_manufacturing</span>
                            </div>
                            <p class="text-[8px] font-bold {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'text-white' : 'text-white/40' }} uppercase">Processing</p>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative z-10 text-center">
                            <div class="w-10 h-10 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-primary text-white' : 'bg-white/10 text-white/40' }} flex items-center justify-center mx-auto mb-2 shadow-lg">
                                <span class="material-symbols-outlined text-sm">local_shipping</span>
                            </div>
                            <p class="text-[8px] font-bold {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-white' : 'text-white/40' }} uppercase">Shipped</p>
                        </div>

                        <!-- Step 4 -->
                        <div class="relative z-10 text-center">
                            <div class="w-10 h-10 rounded-full {{ $order->status === 'delivered' ? 'bg-primary text-white' : 'bg-white/10 text-white/40' }} flex items-center justify-center mx-auto mb-2 shadow-lg">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                            </div>
                            <p class="text-[8px] font-bold {{ $order->status === 'delivered' ? 'text-white' : 'text-white/40' }} uppercase">Delivered</p>
                        </div>
                    </div>

                    <div class="space-y-4 p-6 bg-white/5 rounded-3xl border border-white/10">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-white/40 font-bold uppercase text-[10px]">Payment Status</span>
                            <span class="text-white font-black {{ $order->payment_status === 'paid' ? 'text-green-400' : 'text-yellow-400' }} tracking-widest uppercase text-[10px] italic">{{ $order->payment_status }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-white/40 font-bold uppercase text-[10px]">Last Update</span>
                            <span class="text-white font-medium text-[10px]">{{ $order->updated_at->format('M d, Y - H:i') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('pages.track-order') }}" class="block text-center mt-8 text-[10px] font-black text-primary uppercase tracking-[0.3em] hover:text-white transition-colors">Search Another Order</a>
                </div>
                @endif

                <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/5 {{ isset($order) ? 'hidden' : '' }}">
                    <div class="text-center group">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-2 group-hover:bg-primary/20 transition-all">
                            <span class="material-symbols-outlined text-primary">inventory_2</span>
                        </div>
                        <p class="text-[8px] font-bold text-white/40 uppercase">Processing</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-2 group-hover:bg-primary/20 transition-all">
                            <span class="material-symbols-outlined text-primary">local_shipping</span>
                        </div>
                        <p class="text-[8px] font-bold text-white/40 uppercase">In Transit</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-2 group-hover:bg-primary/20 transition-all">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                        </div>
                        <p class="text-[8px] font-bold text-white/40 uppercase">Delivered</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-white/40 text-[10px] uppercase tracking-widest leading-loose">
                Need assistance? <a href="{{ route('pages.contact') }}" class="text-primary hover:underline">Contact Support</a><br>
                Available 24/7 for Niffer Cosmetic Members
            </p>
        </div>
    </div>
</section>
@endsection
