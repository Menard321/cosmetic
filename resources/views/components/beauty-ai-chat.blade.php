<style>
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #888888 #f1f1f1;
}
.custom-scrollbar::-webkit-scrollbar {
    width: 14px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-left: 1px solid #e5e7eb;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #999999;
    border-radius: 10px;
    border: 3px solid #f1f1f1;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #666666;
}
/* Up and down arrows for the scrollbar */
.custom-scrollbar::-webkit-scrollbar-button:single-button:vertical:decrement {
    height: 14px;
    width: 14px;
    background-color: #f1f1f1;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' fill='gray'><polygon points='50,20 10,80 90,80'/></svg>");
    background-size: 8px;
    background-position: center;
    background-repeat: no-repeat;
}
.custom-scrollbar::-webkit-scrollbar-button:single-button:vertical:increment {
    height: 14px;
    width: 14px;
    background-color: #f1f1f1;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' fill='gray'><polygon points='10,20 90,20 50,80'/></svg>");
    background-size: 8px;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
<div id="beauty-ai-container" class="fixed bottom-6 right-6 z-[999] font-body-md">
    <!-- Luxury Chat Button -->
    <button id="beauty-ai-btn" class="group relative w-16 h-16 flex items-center justify-center transition-all duration-500 outline-none">
        <div class="absolute inset-0 bg-primary/30 rounded-full blur-xl group-hover:bg-primary/50 transition-all duration-700 animate-pulse"></div>
        <div class="relative w-full h-full bg-on-background text-white rounded-2xl flex flex-col items-center justify-center shadow-2xl border border-white/10 group-hover:bg-primary transition-all duration-500">
            <span class="material-symbols-outlined text-[24px]">auto_awesome</span>
            <span class="text-[8px] font-black uppercase tracking-widest mt-0.5">Advice</span>
        </div>
    </button>

    <!-- Premium Chat Window -->
    <div id="beauty-ai-window" class="fixed bottom-24 right-6 w-96 bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-outline-variant/30 flex flex-col z-[1000] transform translate-y-[120%] opacity-0 transition-all duration-500 overflow-hidden pointer-events-none">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-on-background to-primary p-5 text-white flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/20">
                    <span class="material-symbols-outlined text-white text-[20px]">face_retouching_natural</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm leading-tight">Niffer Beauty AI</h3>
                    <p class="text-[9px] uppercase font-black tracking-widest opacity-70">Personal Consultant</p>
                </div>
            </div>
            <button id="beauty-ai-close" class="w-8 h-8 flex items-center justify-center hover:bg-white/10 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        {{-- Messages Area --}}
        <div id="beauty-ai-messages" class="h-[400px] overflow-y-auto p-5 space-y-4 bg-surface-container-lowest/50 custom-scrollbar flex flex-col">
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-lg bg-primary-container flex-shrink-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary-container text-[14px]">smart_toy</span>
                </div>
                <div class="bg-white border border-outline-variant/20 p-3 rounded-2xl rounded-tl-none shadow-sm text-xs leading-relaxed text-on-surface">
                    Welcome to Niffer Cosmetic! ✨ I am your dedicated beauty consultant. Whether you need a skincare routine, product recommendations, or help with an order, I am here to elevate your experience.
                </div>
            </div>

            {{-- Suggestions --}}
            <div id="customer-suggestions" class="grid grid-cols-1 gap-2 mt-2">
                <button onclick="window.sendSuggestion('Recommend a skincare routine for dry skin')" class="text-left p-3 bg-white border border-outline-variant/20 rounded-xl text-[11px] text-on-surface-variant hover:border-primary hover:text-primary transition-all shadow-sm">
                    ✨ Recommend a routine for dry skin
                </button>
                <button onclick="window.sendSuggestion('How can I track my order?')" class="text-left p-3 bg-white border border-outline-variant/20 rounded-xl text-[11px] text-on-surface-variant hover:border-primary hover:text-primary transition-all shadow-sm">
                    📦 How can I track my order?
                </button>
                <button onclick="window.sendSuggestion('Who is Niffer?')" class="text-left p-3 bg-white border border-outline-variant/20 rounded-xl text-[11px] text-on-surface-variant hover:border-primary hover:text-primary transition-all shadow-sm">
                    👑 Tell me about the founder
                </button>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="p-4 border-t border-outline-variant/20 bg-white">
            <form id="beauty-ai-form" class="relative">
                <textarea id="beauty-ai-input" rows="1" class="w-full bg-surface-container-low border-none rounded-2xl py-3 pl-4 pr-12 text-sm focus:ring-2 focus:ring-primary/20 resize-none overflow-hidden" placeholder="Ask anything beauty..."></textarea>
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-on-background text-white rounded-xl flex items-center justify-center hover:bg-primary transition-all shadow-md">
                    <span class="material-symbols-outlined text-[16px]">send</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('beauty-ai-btn');
    const windowEl = document.getElementById('beauty-ai-window');
    const closeBtn = document.getElementById('beauty-ai-close');
    const form = document.getElementById('beauty-ai-form');
    const input = document.getElementById('beauty-ai-input');
    const messagesEl = document.getElementById('beauty-ai-messages');

    function toggleChat() {
        const isOpen = windowEl.classList.contains('translate-y-0');
        if (isOpen) {
            windowEl.classList.add('translate-y-[120%]', 'opacity-0');
            windowEl.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
        } else {
            windowEl.classList.remove('translate-y-[120%]', 'opacity-0');
            windowEl.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
            input.focus();
        }
    }

    btn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);

    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    window.sendSuggestion = function(text) {
        input.value = text;
        const suggestions = document.getElementById('customer-suggestions');
        if (suggestions) suggestions.style.display = 'none';
        form.dispatchEvent(new Event('submit'));
    };

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        const suggestions = document.getElementById('customer-suggestions');
        if (suggestions) suggestions.style.display = 'none';

        // Add user message
        appendMessage('user', message);
        input.value = '';
        input.style.height = 'auto';

        // Typing indicator
        const typingId = 'typing-' + Date.now();
        appendMessage('ai', 'Thinking...', typingId);

        try {
            const response = await fetch('{{ route("beauty-ai.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            const typingEl = document.getElementById(typingId);
            if (typingEl) typingEl.remove();
            
            if (data.reply) {
                appendMessage('ai', data.reply);
            } else {
                appendMessage('ai', 'I apologize, I am experiencing a temporary connection issue. Please try again.');
            }
        } catch (error) {
            const typingEl = document.getElementById(typingId);
            if (typingEl) typingEl.remove();
            appendMessage('ai', 'Connection error. Please try again later.');
        }
    });

    function appendMessage(role, text, id = null) {
        const div = document.createElement('div');
        div.className = 'flex gap-3 ' + (role === 'user' ? 'flex-row-reverse' : '');
        if (id) div.id = id;

        const icon = role === 'user' ? 'person' : 'smart_toy';
        const color = role === 'user' ? 'bg-surface-container-highest' : 'bg-primary-container';
        const textColor = role === 'user' ? 'text-on-surface' : 'text-on-primary-container';
        const radius = role === 'user' ? 'rounded-tr-none' : 'rounded-tl-none';

        div.innerHTML = `
            <div class="w-8 h-8 rounded-lg ${color} flex-shrink-0 flex items-center justify-center">
                <span class="material-symbols-outlined ${textColor} text-[14px]">${icon}</span>
            </div>
            <div class="bg-white border border-outline-variant/20 p-3 rounded-2xl ${radius} shadow-sm text-xs leading-relaxed text-on-surface max-w-[80%]">
                ${text.replace(/\n/g, '<br>')}
            </div>
        `;
        messagesEl.appendChild(div);
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }
});
</script>
