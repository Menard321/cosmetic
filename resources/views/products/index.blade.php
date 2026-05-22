@extends('layouts.master')

@section('content')
<section class="py-stack-lg bg-surface-container-low min-h-screen">
    <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-stack-lg border-b border-outline-variant/30 pb-6">
            <div>
                <h1 class="font-headline-md text-headline-md text-on-surface">Luxury Collections</h1>
                <p class="font-body-md text-on-surface-variant">Explore our curated beauty essentials.</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                <a href="{{ route('products.index') }}" class="px-4 py-2 text-xs font-bold uppercase rounded-none border border-outline-variant hover:bg-primary hover:text-white transition-all {{ !request('category') ? 'bg-primary text-white' : 'bg-white text-on-surface' }}">All</a>
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="px-4 py-2 text-xs font-bold uppercase rounded-none border border-outline-variant hover:bg-primary hover:text-white transition-all {{ request('category') == $category->slug ? 'bg-primary text-white' : 'bg-white text-on-surface' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
            @foreach($products as $product)
                <div class="group relative bg-white border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative overflow-hidden aspect-[4/5] bg-surface-container-low group/img">
                        @if($product->image_url)
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ $product->image_url }}" alt="{{ $product->name }}"/>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <span class="material-symbols-outlined text-gray-300 text-6xl">image</span>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                            @csrf
                            <button type="submit" class="w-full bg-on-background text-white p-4 font-label-md uppercase tracking-widest flex justify-between items-center hover:bg-primary transition-all">
                                <span>Quick Add</span>
                                <span class="material-symbols-outlined">add_shopping_cart</span>
                            </button>
                        </form>
                    </div>
                    
                    <div class="p-6">
                        <p class="font-label-sm text-secondary uppercase tracking-[0.2em] mb-1">{{ $product->brand }}</p>
                        <a href="{{ route('products.show', $product->id) }}">
                            <h3 class="font-body-lg text-body-lg text-on-surface hover:text-primary transition-colors cursor-pointer">{{ $product->name }}</h3>
                        </a>
                        <div class="mt-4 flex justify-between items-center">
                            <p class="font-headline-sm text-primary font-bold">{{ number_format($product->price) }} <span class="text-xs uppercase">TZS</span></p>
                            <span class="text-[10px] px-2 py-1 bg-primary-container/20 text-primary font-bold uppercase">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection
