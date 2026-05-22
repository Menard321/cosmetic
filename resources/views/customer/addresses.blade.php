<x-app-layout>
    <div class="p-6 border-b border-outline-variant/30 mb-6 flex justify-between items-center">
        <div>
            <h4 class="font-headline-sm text-headline-sm text-on-surface">Saved Addresses</h4>
            <p class="text-on-surface-variant text-sm mt-1">Manage your delivery locations.</p>
        </div>
        <button class="bg-primary text-white px-6 py-2 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-secondary transition-all">
            <span class="material-symbols-outlined text-sm">add</span> New Address
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
        <!-- Home Address -->
        <div class="bg-surface-container rounded-2xl border-2 border-primary-container p-6 relative">
            <div class="flex justify-between items-start">
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-primary">home</span>
                    <div>
                        <h5 class="font-bold text-on-surface">Home</h5>
                        <p class="text-sm text-on-surface-variant mt-2 leading-relaxed">
                            Plot 42, Mikocheni B,<br>
                            Dar Es Salaam, Tanzania<br>
                            Phone: +255 712 345 678
                        </p>
                    </div>
                </div>
                <div class="bg-primary-container text-primary text-[10px] font-bold px-2 py-1 rounded">DEFAULT</div>
            </div>
            <div class="mt-6 flex gap-4 border-t border-outline-variant/20 pt-4">
                <button class="text-on-surface-variant hover:text-primary text-xs font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">edit</span> Edit
                </button>
                <button class="text-on-surface-variant hover:text-error text-xs font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">delete</span> Delete
                </button>
            </div>
        </div>

        <!-- Office Address -->
        <div class="bg-surface-container rounded-2xl border border-outline-variant/30 p-6 relative">
            <div class="flex justify-between items-start">
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-on-surface-variant">business</span>
                    <div>
                        <h5 class="font-bold text-on-surface">Office</h5>
                        <p class="text-sm text-on-surface-variant mt-2 leading-relaxed">
                            Mlimani City, Office North Wing,<br>
                            Sam Nujoma Rd, Dar Es Salaam<br>
                            Phone: +255 688 888 888
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex gap-4 border-t border-outline-variant/20 pt-4">
                <button class="text-on-surface-variant hover:text-primary text-xs font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">edit</span> Edit
                </button>
                <button class="text-on-surface-variant hover:text-error text-xs font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">delete</span> Delete
                </button>
                <button class="ml-auto text-primary text-xs font-bold hover:underline">Set as Default</button>
            </div>
        </div>
    </div>
</x-app-layout>
