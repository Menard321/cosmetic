<x-app-layout>
    <div class="bg-surface-container rounded-2xl border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
            <h4 class="font-headline-sm text-headline-sm text-on-surface">Order History</h4>
            <div class="flex gap-2">
                <input type="text" placeholder="Search orders..." class="bg-surface-container-high border border-outline-variant/30 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-variant/20 text-on-surface-variant font-label-sm uppercase">
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Items</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    <tr class="hover:bg-surface-variant/10 transition-colors">
                        <td class="px-6 py-4 font-bold text-on-surface">#54921</td>
                        <td class="px-6 py-4 text-sm text-on-surface-variant">May 15, 2026</td>
                        <td class="px-6 py-4 text-sm">Glow Serum, Moisturizer</td>
                        <td class="px-6 py-4 font-bold text-primary">85,000 TZS</td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold uppercase">Delivered</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-primary hover:underline text-xs font-bold">Details</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-variant/10 transition-colors">
                        <td class="px-6 py-4 font-bold text-on-surface">#53812</td>
                        <td class="px-6 py-4 text-sm text-on-surface-variant">May 10, 2026</td>
                        <td class="px-6 py-4 text-sm">Night Cream</td>
                        <td class="px-6 py-4 font-bold text-primary">45,000 TZS</td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-bold uppercase">Shipped</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-primary hover:underline text-xs font-bold">Details</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
