@extends('layouts.master')

@section('content')
<!-- Category Header -->
<div class="bg-surface-container-low py-16 text-center border-b border-outline-variant/30">
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="font-display-lg text-display-lg text-on-surface mb-2">
            @isset($subcategorySlug)
                {{ ucwords(str_replace('-', ' ', $subcategorySlug)) }}
            @else
                {{ $category->name }}
            @endisset
        </h1>
        <p class="font-body-lg text-on-surface-variant text-label-md">
            @isset($subcategorySlug)
                Discover our exclusive {{ str_replace('-', ' ', $subcategorySlug) }} collection within {{ $category->name }}.
            @else
                {{ $category->description }}
            @endisset
        </p>
    </div>
</div>

<!-- Product Grid -->
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-lg min-h-[50vh]">
    @if($products->isEmpty())
        <div class="text-center py-16">
            <h2 class="font-headline-sm text-headline-sm text-secondary mb-2">No Products Found</h2>
            <p class="font-body-md text-on-surface-variant">We are currently curating new additions for this collection. Please check back later.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-gutter">
            @foreach($products as $product)
                <!-- Product Card -->
                <div class="group relative flex flex-col">
                    <div class="relative overflow-hidden aspect-[4/5] mb-stack-sm bg-surface-container-low group/img">
                        <img 
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="absolute bottom-0 left-0 right-0 glass p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                            @csrf
                            <button type="submit" class="flex justify-between items-center w-full">
                                <span class="font-label-md text-on-surface">Quick Add</span>
                                <span class="material-symbols-outlined text-primary">add</span>
                            </button>
                        </form>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <p class="font-label-sm text-secondary uppercase tracking-widest">{{ $product->brand }}</p>
                        <h3 class="font-body-lg text-body-lg text-on-surface group-hover:text-primary transition-colors flex-grow">{{ $product->name }}</h3>
                        <p class="font-label-md text-primary font-bold mt-2">{{ number_format($product->price) }} TZS</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
