@extends('layouts.master')

@section('content')
<section class="py-12 bg-[#FFF9FB] min-h-screen">
    <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop">
        
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-black text-[#2D1415] mb-2 uppercase tracking-tighter">My Rewards</h1>
                <p class="text-pink-500 font-bold uppercase tracking-widest text-[10px]">Angels Beauty VIP Program</p>
            </div>
            <div class="flex gap-4">
                 <div class="bg-white p-4 rounded-3xl border border-pink-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-pink-600">stars</span>
                    </div>
                    <div>
                        <p class="text-[8px] font-black uppercase text-pink-400">Total Points</p>
                        <p class="text-xl font-black text-on-surface">{{ number_format($user->loyalty_points) }}</p>
                    </div>
                 </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Stats & Progress -->
            <div class="lg:col-span-1 space-y-8">
                
                <!-- VIP Card (Glassmorphism) -->
                <div class="relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-600 to-pink-400 opacity-90 rounded-[2.5rem]"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full translate-x-10 -translate-y-10 blur-2xl"></div>
                    
                    <div class="relative p-10 text-white z-10">
                        <div class="flex justify-between items-start mb-16">
                            <h2 class="text-2xl font-black italic">ANGELS</h2>
                            <div class="px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-[10px] font-black uppercase tracking-widest">
                                {{ $user->loyalty_level }}
                            </div>
                        </div>

                        <div>
                            <p class="text-white/60 text-[10px] font-black uppercase tracking-widest mb-1">Member Name</p>
                            <p class="text-xl font-bold tracking-wider">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Progress to Next Level -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-pink-50 shadow-xl shadow-pink-500/5">
                    <h3 class="font-black text-xs uppercase tracking-widest mb-6 flex justify-between">
                        <span>Level Progress</span>
                        <span class="text-pink-500">{{ round($progress) }}%</span>
                    </h3>
                    
                    <div class="w-full h-3 bg-pink-50 rounded-full mb-4 overflow-hidden">
                        <div class="h-full bg-pink-500 transition-all duration-1000" style="width: {{ $progress }}%"></div>
                    </div>
                    
                    <p class="text-[10px] text-on-surface-variant leading-relaxed">
                        You need <span class="font-black text-pink-600 tracking-tighter">{{ number_format($nextLevelPoints - $user->loyalty_points) }}</span> more points to reach 
                        <span class="font-black text-pink-600">{{ $currentLevelInfo['next'] }}</span>.
                    </p>
                </div>

                <!-- Circular Growth Chart -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-pink-50 shadow-xl shadow-pink-500/5">
                     <h3 class="font-black text-xs uppercase tracking-widest mb-6">Reward Velocity</h3>
                     <div id="velocity-chart"></div>
                </div>
            </div>

            <!-- Right Column: Analytics & Rewards -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main Analytics Graph -->
                <div class="bg-white p-8 rounded-[3rem] border border-pink-50 shadow-xl shadow-pink-500/5">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="font-black text-lg uppercase tracking-tighter">Point Earnings Trend</h3>
                            <p class="text-[10px] text-pink-500 font-bold uppercase tracking-widest">Last 7 Days Activity</p>
                        </div>
                        <div class="flex gap-2">
                             <span class="w-3 h-3 rounded-full bg-pink-500"></span>
                             <span class="text-[8px] font-black uppercase text-on-surface-variant">Points Earned</span>
                        </div>
                    </div>
                    
                    <div id="earnings-chart" class="h-64"></div>
                </div>

                <!-- Rewards Shop -->
                <div>
                    <h3 class="font-black text-lg uppercase tracking-tighter mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-pink-600">redeem</span>
                        Exclusive Rewards
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($availableRewards as $reward)
                        <div class="bg-white p-6 rounded-[2rem] border border-pink-50 shadow-sm flex items-center gap-4 group hover:border-pink-300 transition-all">
                            <div class="w-20 h-20 bg-[#FFF5F8] rounded-2xl flex items-center justify-center shrink-0">
                                @if($reward->image)
                                    <img src="{{ $reward->image }}" class="w-12 h-12 object-contain">
                                @else
                                    <span class="material-symbols-outlined text-3xl text-pink-300">spa</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-black text-sm uppercase tracking-tight">{{ $reward->name }}</h4>
                                <p class="text-[10px] text-pink-600 font-bold tracking-widest">{{ number_format($reward->points_required) }} POINTS</p>
                                
                                <form action="{{ route('customer.loyalty.redeem', $reward->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="mt-3 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest transition-all
                                            {{ $user->loyalty_points >= $reward->points_required ? 'bg-on-background text-white hover:bg-pink-600' : 'bg-surface-variant text-on-surface-variant opacity-50 cursor-not-allowed' }}"
                                            {{ $user->loyalty_points < $reward->points_required ? 'disabled' : '' }}>
                                        Redeem Now
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 p-12 bg-white rounded-[2rem] border border-dashed border-pink-200 text-center text-pink-300">
                             <span class="material-symbols-outlined text-4xl mb-2">inventory_2</span>
                             <p class="text-xs font-bold uppercase">No rewards currently available</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="bg-white rounded-[2.5rem] border border-pink-50 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-pink-50">
                        <h3 class="font-black text-lg uppercase tracking-tighter">Point Ledger</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-pink-50/50 text-[9px] font-black uppercase tracking-widest text-pink-400">
                                <tr>
                                    <th class="px-8 py-4">Transaction</th>
                                    <th class="px-8 py-4">Points</th>
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-pink-50">
                                @forelse($recentTransactions as $tx)
                                <tr class="text-xs hover:bg-pink-50/20 transition-colors">
                                    <td class="px-8 py-5">
                                        <p class="font-bold text-on-surface">{{ $tx->description }}</p>
                                        <p class="text-[9px] text-on-surface-variant opacity-60 uppercase">{{ $tx->type }}</p>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="font-black {{ $tx->points > 0 ? 'text-green-500' : 'text-pink-500' }}">
                                            {{ $tx->points > 0 ? '+' : '' }}{{ number_format($tx->points) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-on-surface-variant">
                                        {{ $tx->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="px-2 py-0.5 rounded shadow-sm text-[8px] font-black uppercase bg-green-100 text-green-700">Completed</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-on-surface-variant italic">No activity recorded yet.</td>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Earnings Chart ---
        const earningsOptions = {
            series: [{
                name: 'Points Earned',
                data: @json($weeklyData->pluck('total_points'))
            }],
            chart: {
                type: 'area',
                height: 250,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#EC4899'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($weeklyData->pluck('date')),
                labels: { style: { colors: '#94a3b8', fontSize: '10px' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { show: false },
            grid: { show: false },
            tooltip: {
                theme: 'dark',
                x: { format: 'dd MMM' }
            }
        };

        const earningsChart = new ApexCharts(document.querySelector("#earnings-chart"), earningsOptions);
        earningsChart.render();

        // --- 2. Velocity Chart (Radial) ---
        const velocityOptions = {
            series: [{{ $progress }}],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: { size: '60%' },
                    dataLabels: {
                        name: { show: false },
                        value: {
                            offsetY: 10,
                            fontSize: '22px',
                            fontWeight: 'bold',
                            color: '#1a1c1c'
                        }
                    },
                    track: { background: '#FFF1F5' }
                }
            },
            colors: ['#EC4899'],
            stroke: { lineCap: 'round' }
        };

        const velocityChart = new ApexCharts(document.querySelector("#velocity-chart"), velocityOptions);
        velocityChart.render();
    });
</script>
@endpush
@endsection
