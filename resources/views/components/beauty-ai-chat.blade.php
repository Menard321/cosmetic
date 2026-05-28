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
<div id="beauty-ai-container" class="fixed bottom-6 right-6 z-[999] font-body-md pl-4 pb-4 pr-1">
    <!-- Chat Button -->
    <button id="beauty-ai-btn" class="w-14 h-14 bg-pink-600 rounded-full shadow-lg shadow-pink-500/30 flex items-center justify-center text-white hover:bg-pink-700 hover:scale-105 active:scale-95 transition-all outline-none border-2 border-white focus:ring-4 focus:ring-pink-200">
        <span class="material-symbols-outlined text-[28px]">smart_toy</span>
    </button>

    <!-- Chat Window -->
    <div id="beauty-ai-window" class="hidden absolute bottom-20 right-0 w-[350px] sm:w-[400px] h-[550px] max-h-[calc(100vh-120px)] bg-white border border-pink-100 rounded-2xl shadow-2xl flex-col overflow-hidden origin-bottom-right transition-all duration-300 transform scale-95 opacity-0 pointer-events-none">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-600 to-pink-500 p-4 text-white flex justify-between items-center relative overflow-hidden shrink-0">
            <div class="absolute inset-0 bg-white/10 translate-x-10 -translate-y-10 blur-xl rounded-full w-32 h-32"></div>
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30">
                    <span class="material-symbols-outlined text-[24px]">face_retouching_natural</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm">Beauty AI</h3>
                    <p class="text-[10px] text-pink-100 flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Online
                    </p>
                </div>
            </div>
            <button id="beauty-ai-close" class="relative z-10 text-white/80 hover:text-white transition-colors p-1 hover:bg-white/10 rounded-full">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div id="beauty-ai-messages" class="flex-1 min-h-0 p-4 bg-[#FFF9FB] overflow-y-auto space-y-4 text-sm relative scroll-smooth flex flex-col gap-3 custom-scrollbar">
            
            <!-- Default Welcome Message -->
            <div class="flex items-end gap-2 max-w-[85%] self-start">
                <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center shrink-0 border border-pink-200">
                    <span class="material-symbols-outlined text-pink-600 text-[18px]">face_retouching_natural</span>
                </div>
                <div class="bg-white p-3 rounded-2xl rounded-bl-sm shadow-sm border border-pink-50 text-on-surface text-[13px] leading-relaxed relative">
                    Hey! 👋 What beauty help are you looking for today? Skincare, makeup, fragrance — I've got you! 
                    <br><br>
                    I can also help you track your orders or check your loyalty points.
                </div>
            </div>

            <!-- Suggested Questions Section -->
            <div id="beauty-ai-suggestions" class="space-y-2 mt-4 px-2">
                <p class="text-[10px] uppercase font-bold text-pink-400 tracking-widest ml-1 mb-2">Frequently Asked</p>
                <div class="flex flex-col gap-2">
                    <button onclick="window.sendSuggestion('How should I use our products?')" class="suggest-btn text-left bg-white p-3 rounded-xl border border-pink-50 text-[12px] text-on-surface hover:border-pink-300 hover:bg-pink-50 transition-all shadow-sm">
                        How should I use this product
                    </button>
                    <button onclick="window.sendSuggestion('What are my loyalty rewards?')" class="suggest-btn text-left bg-white p-3 rounded-xl border border-pink-50 text-[12px] text-on-surface hover:border-pink-300 hover:bg-pink-50 transition-all shadow-sm">
                        What are the benefits of my loyalty points
                    </button>
                    <button onclick="window.sendSuggestion('Recommend a long-wearing foundation')" class="suggest-btn text-left bg-white p-3 rounded-xl border border-pink-50 text-[12px] text-on-surface hover:border-pink-300 hover:bg-pink-50 transition-all shadow-sm">
                        Is this product long-wearing
                    </button>
                    <button onclick="window.sendSuggestion('What products are best for dry skin?')" class="suggest-btn text-left bg-white p-3 rounded-xl border border-pink-50 text-[12px] text-on-surface hover:border-pink-300 hover:bg-pink-50 transition-all shadow-sm">
                        What skin type is this product good for
                    </button>
                </div>
            </div>
            
        </div>

        <!-- Typing Indicator (Hidden by default) -->
        <div id="beauty-ai-typing" class="hidden px-4 pb-2 bg-[#FFF9FB] flex items-end gap-2">
            <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-pink-600 text-[18px]">more_horiz</span>
            </div>
            <div class="bg-white p-3 rounded-2xl rounded-bl-sm shadow-sm border border-pink-50 text-pink-400 flex gap-1 items-center justify-center h-10 w-16">
                <span class="w-1.5 h-1.5 bg-pink-400 rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                <span class="w-1.5 h-1.5 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
            </div>
        </div>

        <!-- Input Area -->
        <form id="beauty-ai-form" class="p-3 bg-white border-t border-pink-50 flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <input type="text" id="beauty-ai-input" autocomplete="off" placeholder="Message..." class="flex-1 bg-surface py-2.5 px-4 rounded-full text-sm border-none focus:ring-1 focus:ring-pink-300 outline-none text-on-surface placeholder:text-on-surface-variant/50">
                <button type="submit" class="w-10 h-10 rounded-full bg-on-background text-white flex items-center justify-center hover:bg-pink-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">arrow_upward</span>
                </button>
            </div>
        </form>
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
    const typingIndicator = document.getElementById('beauty-ai-typing');

    let isOpen = false;

    // Toggle Chat
    function toggleChat() {
        isOpen = !isOpen;
        if (isOpen) {
            windowEl.classList.remove('hidden');
            // Small delay to allow display:block to apply before animating opacity/transform
            setTimeout(() => {
                windowEl.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                windowEl.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
                input.focus();
            }, 10);
        } else {
            windowEl.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            windowEl.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
            setTimeout(() => {
                windowEl.classList.add('hidden');
            }, 300);
        }
    }

    btn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);

    function formatResponse(text) {
        // Simple markdown formatting (bold and newlines)
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br/>')
            .replace(/\* (.*?)(<br\/>|$)/g, '<li class="ml-4 list-disc">$1</li>');
    }

    function addMessage(text, isUser = false) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `flex items-start gap-2 max-w-[90%] ${isUser ? 'self-end flex-row-reverse' : 'self-start'}`;
        
        const avatarHtml = isUser 
            ? `<div class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center shrink-0 border border-outline-variant/30">
                 <span class="material-symbols-outlined text-on-surface text-[18px]">person</span>
               </div>`
            : `<div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center shrink-0 border border-pink-200">
                 <span class="material-symbols-outlined text-pink-600 text-[18px]">face_retouching_natural</span>
               </div>`;

        const bubbleClasses = isUser
            ? `bg-on-background text-white p-3 rounded-2xl rounded-br-sm shadow-sm text-[13px] leading-relaxed break-words`
            : `bg-white p-3 rounded-2xl rounded-bl-sm shadow-sm border border-pink-50 text-on-surface text-[13px] leading-relaxed relative break-words`;

        msgDiv.innerHTML = `
            ${avatarHtml}
            <div class="${bubbleClasses}">${isUser ? text : formatResponse(text)}</div>
        `;
        
        messagesEl.appendChild(msgDiv);
        
        // Smart scrolling logic:
        if (isUser) {
            // User messages: snap to absolute bottom to see your own message
            scrollToBottom();
        } else {
            // AI explanations: Smoothly scroll to the START of the new explanation
            // so the user can read from beginning to end
            setTimeout(() => {
                msgDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 50);
        }
    }

    function scrollToBottom() {
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    // Global function for suggestions
    window.sendSuggestion = function(text) {
        input.value = text;
        form.dispatchEvent(new Event('submit'));
        // Hide suggestions after first interaction
        const suggestions = document.getElementById('beauty-ai-suggestions');
        if (suggestions) suggestions.style.display = 'none';
    };

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = input.value.trim();
        if (!message) return;

        // Hide suggestions if they exist
        const suggestions = document.getElementById('beauty-ai-suggestions');
        if (suggestions) suggestions.style.display = 'none';

        // Display user message
        addMessage(message, true);
        input.value = '';
        input.disabled = true;
        
        // Show typing indicator
        typingIndicator.classList.remove('hidden');
        scrollToBottom();

        try {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };
            if (tokenMeta) {
                headers['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
            }

            const response = await fetch('{{ route("beauty-ai.chat") }}', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            
            typingIndicator.classList.add('hidden');
            
            if (response.ok && data.reply) {
                addMessage(data.reply, false);
            } else {
                addMessage(data.error || 'Oops, I encountered a little beauty hiccup. Please try again.', false);
            }
        } catch (error) {
            console.error('Chat error:', error);
            typingIndicator.classList.add('hidden');
            addMessage('Network error. Please try again later.', false);
        } finally {
            input.disabled = false;
            input.focus();
        }
    });

    // Ensure CSRF token is attached to all future requests if using jQuery etc, but we're using fetch.
});
</script>
