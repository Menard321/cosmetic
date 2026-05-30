@extends('layouts.master')

@section('content')
<section class="py-12 bg-background min-h-screen">
    <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop">
        
        <!-- Premium Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-8">
            <div>
                <h1 class="font-display-lg text-display-lg text-on-surface uppercase tracking-tighter leading-none mb-3">Niffer Rewards</h1>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-primary">Intelligence • Loyalty • Beauty</p>
            </div>
            <div class="flex gap-4">
                <div class="bg-white p-5 rounded-[2rem] border border-outline-variant/30 shadow-xl shadow-primary/5 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-primary-container/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[28px]">stars</span>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase text-on-surface-variant tracking-widest opacity-60">Beauty Wallet</p>
                        <p class="text-2xl font-black text-on-surface tabular-nums">{{ number_format($user->loyalty_points) }} <span class="text-xs font-medium text-on-surface-variant">PTS</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Side: Membership Card & Tiers -->
            <div class="lg:col-span-1 space-y-10">
                
                <!-- Digital Membership Card (Sephora Style) -->
                <div class="relative group perspective-1000">
                    <div class="relative w-full aspect-[1.6/1] rounded-[2.5rem] bg-on-background overflow-hidden p-8 text-white shadow-2xl transition-all duration-700 group-hover:rotate-y-12">
                        <!-- Abstract Patterns -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 blur-[100px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-primary/10 blur-[80px] rounded-full -translate-x-1/4 translate-y-1/4"></div>
                        
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="font-display-lg text-2xl italic tracking-tighter">Niffer</h2>
                                    <p class="text-[8px] uppercase tracking-[0.3em] opacity-60">Cosmetic Tanzania</p>
                                </div>
                                <div class="px-5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-black uppercase tracking-widest" style="color: {{ $currentTier->color_hex ?? '#fff' }}">
                                    {{ $currentTier->name ?? 'Member' }}
                                </div>
                            </div>

                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[8px] uppercase font-black tracking-widest opacity-40 mb-1">Account Holder</p>
                                    <p class="text-lg font-bold tracking-wider">{{ $user->name }}</p>
                                </div>
                                <div id="membership-qr" class="w-16 h-16 bg-white p-1 rounded-xl"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tier Progression Gamification -->
                <div class="bg-white p-10 rounded-[3rem] border border-outline-variant/20 shadow-2xl shadow-primary/5">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="font-black text-xs uppercase tracking-widest text-on-surface">Tier Status</h3>
                        @if($nextTier)
                            <span class="text-[10px] font-bold text-primary px-3 py-1 bg-primary-container/10 rounded-full italic">{{ round($progress) }}% to {{ $nextTier->name }}</span>
                        @endif
                    </div>
                    
                    <div class="relative h-2 bg-surface-container-low rounded-full mb-6 overflow-hidden">
                        <div class="absolute inset-y-0 left-0 bg-primary transition-all duration-1000" style="width: {{ $progress }}%">
                            <div class="absolute top-0 right-0 w-4 h-full bg-white/30 skew-x-12 animate-shimmer"></div>
                        </div>
                    </div>
                    
                    @if($nextTier)
                        <p class="text-[11px] text-on-surface-variant leading-relaxed text-center italic">
                            Elevate your status! Earn <span class="font-black text-primary">{{ number_format($pointsToNext) }}</span> more points to unlock <span class="text-on-surface font-black">{{ $nextTier->name }}</span> privileges.
                        </p>
                    @else
                        <p class="text-[11px] text-primary font-black uppercase tracking-widest text-center">Elite Diamond Status Reached</p>
                    @endif
                </div>

                <!-- Referral Program -->
                <div class="bg-gradient-to-br from-primary to-primary-fixed p-10 rounded-[3rem] text-on-primary-container shadow-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                            <span class="material-symbols-outlined text-white">group_add</span>
                        </div>
                        <h3 class="font-black text-xs uppercase tracking-widest text-white">Gift Radiance</h3>
                    </div>
                    <p class="text-xs leading-relaxed text-white/80 mb-6 font-medium">Invite friends to join our community. Each successful referral earns you <span class="font-black text-white">500 Bonus Points</span>.</p>
                    
                    <div class="relative flex items-center">
                        <input type="text" readonly value="{{ $user->referralLink() }}" id="referral-link" class="w-full bg-white/10 border border-white/20 rounded-2xl py-4 pl-4 pr-16 text-[10px] text-white font-medium focus:ring-0 outline-none">
                        <button onclick="copyReferral()" class="absolute right-2 bg-white text-primary px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-transform">Copy</button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Analytics & Content -->
            <div class="lg:col-span-2 space-y-10">
                
                <!-- Experience Grid (Events & Rewards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Events -->
                    <div class="bg-white p-10 rounded-[3rem] border border-outline-variant/20 shadow-xl shadow-primary/5">
                        <div class="flex justify-between items-center mb-10">
                            <h3 class="font-black text-sm uppercase tracking-tighter flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">confirmation_number</span>
                                My Tickets
                            </h3>
                            <span class="text-[10px] font-bold text-primary px-3 py-1 bg-primary-container/10 rounded-full">{{ $user->tickets->count() }} Tickets</span>
                        </div>
                        
                        <div class="space-y-6">
                            @forelse($user->tickets as $ticket)
                                <div class="flex items-center gap-5 p-4 bg-surface-container-low rounded-[2rem] border border-outline-variant/10">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 shadow-sm border border-outline-variant/10">
                                        <span class="material-symbols-outlined text-primary">qr_code_2</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-xs font-black uppercase tracking-tight text-on-surface line-clamp-1">{{ $ticket->event->title }}</h4>
                                        <p class="text-[9px] text-on-surface-variant font-bold opacity-60">{{ $ticket->event->event_date->format('d M, Y') }}</p>
                                    </div>
                                    <button class="w-8 h-8 rounded-full bg-on-background text-white flex items-center justify-center hover:bg-primary transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    </button>
                                </div>
                            @empty
                                <div class="text-center py-10 opacity-40">
                                    <span class="material-symbols-outlined text-4xl mb-4">event_busy</span>
                                    <p class="text-[10px] font-bold uppercase tracking-widest">No Active Tickets</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-10 pt-10 border-t border-outline-variant/10">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-6">Upcoming Events</h4>
                            <div class="space-y-4">
                                @foreach($activeEvents as $evt)
                                    @unless($user->tickets->contains('beauty_event_id', $evt->id))
                                        <div class="p-4 rounded-2xl bg-surface-container-lowest border border-outline-variant/20">
                                            <div class="flex justify-between items-start mb-2">
                                                <p class="text-xs font-bold text-on-surface">{{ $evt->title }}</p>
                                                <p class="text-[10px] font-black text-primary">{{ $evt->points_required }} PTS</p>
                                            </div>
                                            <p class="text-[10px] text-on-surface-variant mb-4">{{ $evt->event_date->format('M d, H:i') }} • {{ $evt->location }}</p>
                                            <form action="{{ route('customer.loyalty.book-event', $evt->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full py-2 bg-on-background text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-primary transition-all">Book Seat</button>
                                            </form>
                                        </div>
                                    @endunless
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tier Benefits -->
                    <div class="bg-surface-container-low p-10 rounded-[3rem] border border-outline-variant/20">
                        <h3 class="font-black text-sm uppercase tracking-tighter mb-10 flex items-center gap-3 text-on-surface">
                            <span class="material-symbols-outlined text-primary">diamond</span>
                            {{ $currentTier->name ?? 'Silver' }} Perks
                        </h3>
                        <ul class="space-y-6">
                            @foreach($currentTier->perks ?? ['Birthday bonus', 'Monthly newsletter'] as $perk)
                                <li class="flex items-center gap-4">
                                    <div class="w-2 h-2 rounded-full bg-primary ring-4 ring-primary-container/20"></div>
                                    <span class="text-xs font-medium text-on-surface-variant">{{ $perk }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Reward Redemption Redesign -->
                <div>
                    <h3 class="font-display-lg text-lg uppercase tracking-tighter mb-8 flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">redeem</span>
                        Curated Rewards
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($availableRewards as $reward)
                        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/20 shadow-xl shadow-primary/5 flex items-center gap-6 group hover:scale-[1.02] transition-transform">
                            <div class="w-24 h-24 bg-surface-container-low rounded-3xl flex items-center justify-center shrink-0 border border-outline-variant/10 overflow-hidden relative">
                                @if($reward->image)
                                    <img src="{{ $reward->image }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-4xl text-primary/30">spa</span>
                                @endif
                                <div class="absolute inset-x-0 bottom-0 py-1.5 bg-on-background/80 backdrop-blur-md text-white text-[9px] font-black uppercase text-center tracking-widest transform translate-y-full group-hover:translate-y-0 transition-transform">
                                    Redeem
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-black text-[13px] uppercase tracking-tight text-on-surface mb-1">{{ $reward->name }}</h4>
                                <p class="text-[10px] text-primary font-black tracking-widest mb-4">{{ number_format($reward->points_required) }} PTS</p>
                                
                                <form action="{{ route('customer.loyalty.redeem', $reward->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest border border-outline-variant transition-all
                                            {{ $user->loyalty_points >= $reward->points_required ? 'bg-on-background text-white border-on-background hover:bg-primary hover:border-primary' : 'bg-surface-variant text-on-surface-variant opacity-30 cursor-not-allowed border-transparent' }}"
                                            {{ $user->loyalty_points < $reward->points_required ? 'disabled' : '' }}>
                                        Confirm
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 p-20 bg-surface-container-low rounded-[3rem] border border-dashed border-outline-variant/30 text-center text-outline">
                             <span class="material-symbols-outlined text-5xl mb-6">inventory_2</span>
                             <p class="text-xs font-black uppercase tracking-[0.3em]">The Rewards Vault Is Empty</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Transaction Ledger Redesign -->
                <div class="bg-white rounded-[3rem] border border-outline-variant/20 shadow-2xl shadow-primary/5 overflow-hidden">
                    <div class="p-10 border-b border-outline-variant/10 bg-surface-container-low/30">
                        <h3 class="font-black text-lg uppercase tracking-tighter">Point Intelligence Ledger</h3>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mt-1 opacity-60">Verified Activity Log</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-surface-container-lowest text-[9px] font-black uppercase tracking-[0.2em] text-on-surface-variant border-b border-outline-variant/10">
                                <tr>
                                    <th class="px-10 py-6">Intelligence source</th>
                                    <th class="px-10 py-6">Points</th>
                                    <th class="px-10 py-6">Timestamp</th>
                                    <th class="px-10 py-6 text-right">Verification</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($recentTransactions as $tx)
                                <tr class="text-xs hover:bg-surface-container-low/50 transition-colors">
                                    <td class="px-10 py-6">
                                        <p class="font-bold text-on-surface mb-0.5">{{ $tx->description }}</p>
                                        <p class="text-[9px] text-primary font-black uppercase tracking-tighter">{{ $tx->type }}</p>
                                    </td>
                                    <td class="px-10 py-6">
                                        <span class="font-black text-sm tabular-nums {{ $tx->points > 0 ? 'text-green-500' : 'text-primary' }}">
                                            {{ $tx->points > 0 ? '+' : '' }}{{ number_format($tx->points) }}
                                        </span>
                                    </td>
                                    <td class="px-10 py-6 text-on-surface-variant font-medium opacity-70">
                                        {{ $tx->created_at->format('M d, H:i') }}
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-500/10 text-green-600 text-[8px] font-black uppercase tracking-widest">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            Verified
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-20 text-center text-on-surface-variant italic">No intelligence logs found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate Membership QR
        const qrContainer = document.getElementById("membership-qr");
        if (qrContainer) {
            new QRCode(qrContainer, {
                text: "NIFFER-{{ $user->id }}-{{ $user->loyalty_level }}",
                width: 56,
                height: 56,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    });

    function copyReferral() {
        const copyText = document.getElementById("referral-link");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        
        // Visual Feedback
        const btn = event.target;
        const originalText = btn.innerText;
        btn.innerText = "COPIED!";
        btn.classList.replace('bg-white', 'bg-green-400');
        btn.classList.replace('text-primary', 'text-white');
        
        setTimeout(() => {
            btn.innerText = originalText;
            btn.classList.replace('bg-green-400', 'bg-white');
            btn.classList.replace('text-white', 'text-primary');
        }, 2000);
    }
</script>
@endpush
@endsection
