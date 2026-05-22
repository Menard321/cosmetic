@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Product Catalog</h2>
    <div class="flex gap-4">
        <a href="{{ route('admin.products.bulk') }}" class="border border-primary text-primary px-6 py-3 rounded-xl font-label-md flex items-center gap-2 hover:bg-primary hover:text-white transition-all">
            <span class="material-symbols-outlined">dataset_linked</span> Bulk Add
        </a>
        <a href="{{ route('admin.products.create') }}" class="bg-primary text-white px-6 py-3 rounded-xl font-label-md flex items-center gap-2 hover:bg-secondary transition-all">
            <span class="material-symbols-outlined">add</span> New Product
        </a>
    </div>

<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-surface-container-low text-on-surface-variant font-label-sm uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Product</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Price (TZS)</th>
                    <th class="px-6 py-4">Stock</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                @foreach($products as $product)
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-surface-variant overflow-hidden shrink-0">
                                <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-on-surface">{{ $product->name }}</p>
                                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest">{{ $product->brand }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-secondary-container text-on-secondary-container text-[10px] rounded font-bold uppercase tracking-widest">{{ $product->category->name ?? 'None' }}</span>
                    </td>
                    <td class="px-6 py-4 font-bold text-primary">{{ number_format($product->price) }}</td>
                    <td class="px-6 py-4">
                        @if($product->stock_quantity < 10)
                            <span class="text-error font-bold text-sm">{{ $product->stock_quantity }} Low</span>
                        @else
                            <span class="text-on-surface-variant text-sm">{{ $product->stock_quantity }} In Stock</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 hover:bg-primary/10 rounded-lg text-primary transition-colors">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-error/10 rounded-lg text-error transition-colors">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-outline-variant/30">
        {{ $products->links() }}
    </div>
</div>
@endsection
