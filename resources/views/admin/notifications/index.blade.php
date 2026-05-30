@extends('layouts.admin')

@section('content')
<div class="space-y-gutter">
    <!-- Header -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Notification Hub</h2>
            <p class="font-body-md text-on-surface-variant text-label-md uppercase tracking-widest italic">SMS Campaigns & Customer Alerts</p>
        </div>
        <div class="flex gap-4">
            <span class="flex items-center gap-2 text-xs font-bold text-primary italic">
                <span class="w-3 h-3 rounded-full bg-primary animate-pulse"></span> NextSMS Gateway Connected
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <!-- Send Campaign Form -->
        <div class="lg:col-span-2 glass-card p-10 rounded-full border border-outline-variant/30 relative overflow-hidden group">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl transition-all duration-1000 group-hover:bg-primary/10"></div>
            
            <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em] mb-8">Launch Premium Campaign</h4>
            
            <form action="{{ route('admin.notifications.send') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-on-surface-variant px-1">Audience Segment</label>
                        <select name="audience" class="w-full bg-white border border-outline-variant rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none appearance-none cursor-pointer">
                            <option value="all">Global Customers (All Branches)</option>
                            <option value="loyalty">Loyalty Members (Silver+)</option>
                            <option value="branch_sinza">Sinza Branch Only</option>
                            <option value="branch_kigamboni">Kigamboni Branch Only</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-on-surface-variant px-1">Message Branding</label>
                        <input type="text" value="NIFFER" disabled class="w-full bg-surface-variant/30 border border-outline-variant/50 rounded-2xl px-5 py-3 text-sm font-bold text-primary"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[10px] uppercase font-bold text-on-surface-variant">Message Content</label>
                        <span class="text-[9px] font-bold text-outline uppercase tracking-tighter" id="charCount">0 / 160 Characters</span>
                    </div>
                    <textarea name="message" id="messageArea" rows="4" maxlength="160" placeholder="Type your professional beauty update here..." 
                              class="w-full bg-white border border-outline-variant rounded-3xl px-6 py-5 text-sm focus:ring-2 focus:ring-primary/20 outline-none resize-none transition-all placeholder:italic"></textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-on-background text-white px-10 py-3 rounded-full font-label-md flex items-center gap-3 hover:bg-primary hover:shadow-xl transition-all group/btn">
                        <span>Execute Campaign</span>
                        <span class="material-symbols-outlined text-[20px] group-hover/btn:translate-x-1 transition-transform">send</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- System Alerts & Stats -->
        <div class="space-y-gutter">
            <div class="glass-card p-8 rounded-full border border-outline-variant/30 bg-primary-container/5 relative group">
                <h4 class="text-xs uppercase font-bold text-primary tracking-[0.2em] mb-6">Delivery Analytics</h4>
                <div class="space-y-6">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Monthly Sent</p>
                            <h3 class="text-3xl font-headline-sm">12,482</h3>
                        </div>
                        <span class="text-green-600 text-xs font-bold">+18% WoW</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Open rate (Est.)</p>
                            <h3 class="text-3xl font-headline-sm">94.2%</h3>
                        </div>
                        <span class="text-primary text-xs font-bold italic">Industry Lead</span>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-full border border-outline-variant/30 flex-grow border-primary/20">
                <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em] mb-4 italic leading-none">Low Balance Warning</h4>
                <div class="flex items-center gap-4 mb-4">
                    <span class="material-symbols-outlined text-error text-3xl">warning</span>
                    <div>
                        <p class="text-sm font-bold">142 Credits Remaining</p>
                        <p class="text-[10px] text-on-surface-variant italic leading-none">Your account is below threshold.</p>
                    </div>
                </div>
                <button class="w-full border border-error text-error text-[10px] font-bold uppercase py-2.5 rounded-xl hover:bg-error/5 transition-all">Top Up NextSMS Balance</button>
            </div>
        </div>
    </div>

    <!-- History -->
    <div class="glass-card rounded-full border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-low">
            <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em]">Communication Logs</h4>
            <span class="text-[10px] text-outline uppercase font-bold tracking-widest">Last 50 Entries</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-lowest text-on-surface-variant">
                    <tr>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Recipient</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Message Trace</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Timestamp</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-center">Gateway Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 italic font-body-md">
                    @foreach($history as $item)
                    <tr class="hover:bg-primary-container/5 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-outline-variant/20 flex items-center justify-center text-[10px] font-bold text-outline">
                                    <span class="material-symbols-outlined text-[16px]">person</span>
                                </div>
                                <span class="text-sm font-bold text-on-surface tabular-nums">{{ $item['to'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-xs text-on-surface-variant line-clamp-1 max-w-md group-hover:text-on-surface transition-colors">
                                "{{ $item['message'] }}"
                            </p>
                        </td>
                        <td class="px-8 py-6 text-[11px] text-on-surface-variant font-bold tabular-nums">
                            {{ $item['sent_at']->diffForHumans() }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1 bg-green-500/10 text-green-600 text-[9px] uppercase font-bold rounded-full border border-green-500/20 italic leading-none">
                                {{ $item['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const area = document.getElementById('messageArea');
    const count = document.getElementById('charCount');
    area.addEventListener('input', () => {
        count.innerText = `${area.value.length} / 160 Characters`;
        if(area.value.length >= 150) count.className = 'text-[9px] font-bold text-error uppercase tracking-tighter';
        else count.className = 'text-[9px] font-bold text-outline uppercase tracking-tighter';
    });
</script>
@endsection
