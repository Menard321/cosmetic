<x-app-layout>
    <div class="bg-surface-container rounded-2xl border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
            <h4 class="font-headline-sm text-headline-sm text-on-surface">Order History</h4>
            <div class="flex gap-2">
                <p class="text-sm text-on-surface-variant">View and track your recent beauty purchases.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 mx-6 mt-6 bg-green-100 text-green-700 rounded-xl border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mx-6 mt-6 bg-red-100 text-red-700 rounded-xl border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 mx-6 mt-6 bg-blue-100 text-blue-700 rounded-xl border border-blue-200">
                {{ session('info') }}
            </div>
        @endif
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-variant/20 text-on-surface-variant font-label-sm uppercase">
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Items</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($orders as $order)
                        <tr class="hover:bg-surface-variant/10 transition-colors">
                            <td class="px-6 py-4">
                                <span class="bg-surface-container-high px-3 py-1 rounded-lg text-primary font-black tracking-widest text-xs border border-outline-variant/30">
                                    SB-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @foreach($order->items as $item)
                                    {{ $item->product->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 font-bold text-primary">{{ number_format($order->total_amount) }} TZS</td>
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'paid')
                                    <span class="text-[10px] px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold uppercase">Paid</span>
                                @else
                                    <span class="text-[10px] px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full font-bold uppercase">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'shipped' => 'bg-purple-100 text-purple-700',
                                        'delivered' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="text-[10px] px-2 py-0.5 {{ $statusColors[$order->status] ?? 'bg-surface-variant text-on-surface-variant' }} rounded-full font-bold uppercase">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-2 flex items-center">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </a>
                                
                                @if($order->payment_status === 'unpaid' && $order->payment_reference)
                                    <form action="{{ route('order.verify-payment', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-primary text-white text-[10px] px-3 py-1 rounded-lg font-bold uppercase hover:bg-primary/90 transition-all">
                                            Check Payment
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl mb-2">shopping_bag</span>
                                <p>You haven't placed any orders yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
