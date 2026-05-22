@extends('layouts.master')

@section('content')
<section class="py-stack-lg bg-surface min-h-screen">
    <div class="px-margin-mobile md:px-margin-desktop max-w-[1000px] mx-auto">
        <h1 class="font-headline-md text-headline-md text-on-surface mb-stack-lg">Shopping Bag</h1>

        @if(session('cart'))
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
                <div class="lg:col-span-2 space-y-gutter">
                    @foreach(session('cart') as $id => $details)
                        <div class="flex gap-6 bg-white p-6 border border-outline-variant/20 shadow-sm relative group">
                            <div class="w-32 h-40 bg-surface-container-low shrink-0 overflow-hidden">
                                <img src="{{ $details['image'] }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between">
                                        <p class="font-label-sm text-secondary uppercase tracking-widest">{{ $details['brand'] }}</p>
                                        <button class="remove-from-cart text-on-surface-variant hover:text-error transition-colors" data-id="{{ $id }}">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>
                                    <h3 class="font-body-lg text-body-lg text-on-surface mt-1">{{ $details['name'] }}</h3>
                                </div>
                                <div class="flex justify-between items-end mt-4">
                                    <div class="flex items-center border border-outline-variant/30">
                                        <input type="number" value="{{ $details['quantity'] }}" class="update-cart w-16 border-none text-center focus:ring-0" data-id="{{ $id }}" min="1">
                                    </div>
                                    <p class="font-bold text-primary">{{ number_format($details['price']) }} TZS</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-surface-container p-8 sticky top-24">
                        <h2 class="font-label-md text-on-surface uppercase font-bold border-b border-outline-variant pb-4 mb-6">Summary</h2>
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between">
                                <span class="text-on-surface-variant">Subtotal</span>
                                <span class="font-bold text-on-surface">{{ number_format($total) }} TZS</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-on-surface-variant">Shipping (Dar)</span>
                                <span class="font-bold text-on-surface">15,000 TZS</span>
                            </div>
                        </div>
                        <div class="border-t border-outline-variant pt-4 mb-8 flex justify-between">
                            <span class="font-headline-sm text-headline-sm">Total</span>
                            <span class="font-headline-sm text-headline-sm text-primary">{{ number_format($total + 15000) }} TZS</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="w-full inline-block bg-on-background text-white text-center py-4 font-label-md uppercase tracking-widest hover:bg-primary transition-all duration-500 shadow-xl">
                            Proceed to Checkout
                        </a>
                        <p class="text-[10px] text-on-surface-variant mt-4 text-center italic">Taxes and additional delivery fees calculated at checkout.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-24 bg-surface-container-low border border-dashed border-outline-variant rounded-none">
                <span class="material-symbols-outlined text-[100px] text-outline-variant/40 mb-6 font-thin">shopping_bag</span>
                <p class="font-headline-sm text-on-surface mb-6">Your bag is currently empty.</p>
                <a href="{{ route('products.index') }}" class="bg-primary text-white px-12 py-4 font-label-md uppercase tracking-widest hover:bg-secondary transition-all shadow-lg">Start Shopping</a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script type="text/javascript">
    $(".update-cart").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.attr("data-id"), 
                quantity: ele.val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Are you sure you want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
@endpush
@endsection
