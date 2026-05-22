@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.inventory.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Inventory
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface">Supplier Management</h2>
    <p class="font-body-md text-on-surface-variant">Track your international and local beauty product sources.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
    <!-- Add Supplier Form -->
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30 h-fit">
        <h4 class="font-label-md text-on-surface uppercase font-bold mb-6">New Supplier</h4>
        <form action="{{ route('admin.inventory.suppliers.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="label-premium block mb-1">Company Name</label>
                <input type="text" name="name" class="form-input-premium w-full" required>
            </div>
            <div>
                <label class="label-premium block mb-1">Contact Person</label>
                <input type="text" name="contact_person" class="form-input-premium w-full">
            </div>
            <div>
                <label class="label-premium block mb-1">Phone</label>
                <input type="text" name="phone" class="form-input-premium w-full">
            </div>
            <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-secondary transition-colors mt-4">
                Register Supplier
            </button>
        </form>
    </div>

    <!-- Suppliers List -->
    <div class="lg:col-span-2 glass-card rounded-xl border border-outline-variant/30 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-surface-container-low text-on-surface-variant font-label-sm uppercase tracking-widest">
                <tr>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4">Contact</th>
                    <th class="px-6 py-4 text-right">Registered</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                @foreach($suppliers as $supplier)
                <tr class="hover:bg-surface-container-low/20 transition-colors">
                    <td class="px-6 py-4 font-bold">{{ $supplier->name }}</td>
                    <td class="px-6 py-4 text-sm text-on-surface-variant">
                        {{ $supplier->contact_person }}<br>
                        {{ $supplier->phone }}
                    </td>
                    <td class="px-6 py-4 text-right text-xs text-on-surface-variant">
                        {{ $supplier->created_at->format('M d, Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-outline-variant/30">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection
