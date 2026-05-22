@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.inventory.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Inventory
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface">Restock History</h2>
    <p class="font-body-md text-on-surface-variant">Trace every stock movement and replenishment activity.</p>
</div>

<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-surface-container-low text-on-surface-variant font-label-sm uppercase tracking-widest">
            <tr>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4">Product</th>
                <th class="px-6 py-4">Type</th>
                <th class="px-6 py-4 text-center">Change</th>
                <th class="px-6 py-4">Performed By</th>
                <th class="px-6 py-4">Reason</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant/20">
            @foreach($logs as $log)
            <tr class="hover:bg-surface-container-low/20 transition-colors">
                <td class="px-6 py-4 text-sm">{{ $log->created_at->format('M d, H:i') }}</td>
                <td class="px-6 py-4 font-bold text-on-surface">{{ $log->product->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $log->type == 'restock' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-variant' }}">
                        {{ $log->type }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center font-bold {{ $log->quantity > 0 ? 'text-primary' : 'text-error' }}">
                    {{ $log->quantity > 0 ? '+' : '' }}{{ $log->quantity }}
                </td>
                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $log->user->name ?? 'System' }}</td>
                <td class="px-6 py-4 text-sm italic text-on-surface-variant">{{ $log->reason }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
