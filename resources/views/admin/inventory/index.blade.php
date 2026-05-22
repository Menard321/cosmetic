@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Inventory Control</h2>
        <p class="font-body-md text-on-surface-variant">Real-time stock monitoring, batch tracking, and expiry watch.</p>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('admin.inventory.suppliers') }}" class="border border-outline text-on-surface px-6 py-3 rounded-xl font-label-md flex items-center gap-2 hover:bg-surface-container transition-all">
            <span class="material-symbols-outlined">conveyor_belt</span> Suppliers
        </a>
        <a href="{{ route('admin.inventory.history') }}" class="bg-on-background text-white px-6 py-3 rounded-xl font-label-md flex items-center gap-2 hover:opacity-90 transition-all">
            <span class="material-symbols-outlined">history</span> Restock History
        </a>
    </div>
</div>

<!-- Alerts Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter mb-stack-lg">
    <!-- Low Stock Alert Panel -->
    <div class="glass-card p-6 rounded-xl border border-error/20 bg-error-container/5 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-error">warning</span>
            <h4 class="font-label-md text-on-surface uppercase font-bold">Low Stock Watchlist</h4>
        </div>
        <div class="space-y-3">
            @forelse($lowStockProducts as $p)
                <div class="flex justify-between items-center bg-white/50 p-3 rounded-lg border border-outline-variant/30">
                    <div>
                        <p class="font-bold text-sm">{{ $p->name }}</p>
                        <p class="text-[10px] text-error font-medium">Currently: {{ $p->stock_quantity }} units</p>
                    </div>
                    <a href="{{ route('admin.inventory.restock', $p->id) }}" class="text-primary text-xs font-bold hover:underline">Restock</a>
                </div>
            @empty
                <p class="text-sm text-secondary italic">All shelves are perfectly stocked.</p>
            @endforelse
        </div>
    </div>

    <!-- Expiry Alert Panel -->
    <div class="glass-card p-6 rounded-xl border border-primary/20 bg-primary-container/5 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-primary">event_busy</span>
            <h4 class="font-label-md text-on-surface uppercase font-bold">Batch Expiry Watch</h4>
        </div>
        <div class="space-y-3">
            @forelse($expiredBatches as $batch)
                <div class="flex justify-between items-center bg-white/50 p-3 rounded-lg border border-outline-variant/30">
                    <div>
                        <p class="font-bold text-sm">{{ $batch->product->name }}</p>
                        <p class="text-[10px] text-primary font-medium">Batch #{{ $batch->batch_number }} | Expired: {{ $batch->expiry_date }}</p>
                    </div>
                    <span class="px-2 py-1 bg-error text-white text-[8px] rounded uppercase">Remove</span>
                </div>
            @empty
                <p class="text-sm text-secondary italic">No expired cosmetic batches detected.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Stock Table -->
<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-surface-container-low text-on-surface-variant font-label-sm uppercase tracking-widest">
                <tr>
                    <th class="px-6 py-4">Product Detail</th>
                    <th class="px-6 py-4">Total Stock</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Latest Batches</th>
                    <th class="px-6 py-4 text-right">Operation</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4">
                        <p class="font-bold text-on-surface">{{ $product->name }}</p>
                        <p class="text-[10px] text-on-surface-variant uppercase">{{ $product->brand }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-headline-sm text-headline-sm text-primary">{{ $product->stock_quantity }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->stock_quantity == 0)
                            <span class="px-2 py-1 bg-error text-white text-[10px] rounded font-bold">OUT OF STOCK (AUTO-DISABLED)</span>
                        @elseif($product->stock_quantity < 10)
                            <span class="px-2 py-1 bg-error-container text-on-error-container text-[10px] rounded font-bold uppercase">Critical</span>
                        @else
                            <span class="px-2 py-1 bg-primary-container/20 text-primary text-[10px] rounded font-bold uppercase">Healthy</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs text-on-surface-variant">
                        @foreach($product->batches->take(2) as $batch)
                            <div class="mb-1">• #{{ $batch->batch_number }} (Exp: {{ $batch->expiry_date }})</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.inventory.restock', $product->id) }}" class="inline-flex items-center gap-1 text-primary hover:bg-primary/10 px-3 py-1 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-sm">add_box</span> Restock
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
