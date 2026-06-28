@extends('layouts.app')

@section('content')
<div class="container max-w-4xl mx-auto px-4 py-8 md:py-12">
    <!-- Chat Container -->
    <div class="rounded-[2rem] border border-border bg-white shadow-sm overflow-hidden flex flex-col h-[80vh] min-h-[600px] max-h-[800px]">
        
        <!-- Header -->
        <div class="bg-primary px-6 py-4 flex items-center justify-between relative overflow-hidden shrink-0">
            <!-- Decorative circle -->
            <div class="absolute -right-8 -top-12 w-32 h-32 rounded-full bg-white/10 blur-2xl"></div>
            
            <div class="flex items-center gap-4 relative z-10">
                <div class="bg-white rounded-2xl w-12 h-12 flex items-center justify-center shadow-sm">
                    <i data-lucide="bot" class="h-6 w-6 text-primary"></i>
                </div>
                <div>
                    <h2 class="font-bold font-heading text-white text-xl m-0">NusaBot</h2>
                    <div class="flex items-center gap-1.5 text-white/80 text-sm">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        Asisten Wisata Indonesia
                    </div>
                </div>
            </div>
            
            <form action="{{ route('chatbot.clear') }}" method="POST" class="m-0 relative z-10">
                @csrf
                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-white px-4 py-2 text-sm font-medium transition-colors border-0"
                    onclick="return confirm('Hapus semua riwayat chat?')">
                    <i data-lucide="trash-2" class="mr-2 h-4 w-4"></i> Hapus Riwayat
                </button>
            </form>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 overflow-y-auto p-6 bg-gray-50/50 space-y-6" id="chatArea">
            <!-- Welcome Message -->
            <div class="flex gap-4 animate-[fadeIn_0.5s_ease-out]">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-sm">
                    NB
                </div>
                <div class="bg-white rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm border border-gray-100 max-w-[85%] sm:max-w-[75%]">
                    <p class="m-0 text-foreground text-sm leading-relaxed">Halo! Aku <strong>NusaBot</strong> 👋, asisten wisata Indonesia. Tanya apa saja tentang destinasi wisata, kuliner, atau budaya Indonesia!</p>
                </div>
            </div>

            @foreach($histories as $chat)
                @if($chat->role === 'user')
                    <div class="flex flex-row-reverse gap-4 animate-[fadeIn_0.3s_ease-out]">
                        <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-sm uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="bg-primary text-white rounded-2xl rounded-tr-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%]">
                            <p class="m-0 text-sm leading-relaxed">{{ $chat->message }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex gap-4 animate-[fadeIn_0.3s_ease-out]">
                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-sm">
                            NB
                        </div>
                        <div class="bg-white rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm border border-gray-100 max-w-[85%] sm:max-w-[75%] overflow-x-auto">
                            <div class="m-0 text-foreground text-sm leading-relaxed chatbot-markdown">{!! \Illuminate\Support\Str::markdown($chat->message) !!}</div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Loading Indicator -->
            <div id="loadingIndicator" class="hidden flex gap-4 animate-[fadeIn_0.3s_ease-out]">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-sm">
                    NB
                </div>
                <div class="bg-white rounded-2xl rounded-tl-sm px-5 py-4 shadow-sm border border-gray-100 w-24 flex items-center justify-center">
                    <div class="flex gap-1.5 items-center">
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Questions -->
        <div class="px-6 py-3 border-t border-border bg-gray-50/50 flex flex-wrap gap-2 shrink-0">
            <button class="quick-q inline-flex items-center justify-center rounded-full border border-gray-200 bg-white px-4 py-1.5 text-xs font-semibold text-gray-600 hover:border-primary hover:text-primary transition-colors shadow-sm" data-q="Rekomendasikan destinasi wisata terbaik di Bali">Wisata Bali</button>
            <button class="quick-q inline-flex items-center justify-center rounded-full border border-gray-200 bg-white px-4 py-1.5 text-xs font-semibold text-gray-600 hover:border-primary hover:text-primary transition-colors shadow-sm" data-q="Apa kuliner khas Jawa Timur yang wajib dicoba?">Kuliner Jatim</button>
            <button class="quick-q inline-flex items-center justify-center rounded-full border border-gray-200 bg-white px-4 py-1.5 text-xs font-semibold text-gray-600 hover:border-primary hover:text-primary transition-colors shadow-sm" data-q="Tempat wisata alam terbaik di Indonesia">Wisata Alam</button>
            <button class="quick-q inline-flex items-center justify-center rounded-full border border-gray-200 bg-white px-4 py-1.5 text-xs font-semibold text-gray-600 hover:border-primary hover:text-primary transition-colors shadow-sm" data-q="Tips perjalanan ke Raja Ampat">Raja Ampat</button>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-border shrink-0">
            <div id="chatInputGroup" class="flex items-center bg-gray-50 rounded-2xl border border-gray-200 focus-within:border-primary focus-within:bg-white focus-within:ring-4 focus-within:ring-primary/10 transition-all p-1.5">
                <button id="voiceBtn" class="p-3 text-gray-400 hover:text-primary hover:bg-gray-100 rounded-xl transition-colors border-0 bg-transparent flex items-center justify-center shrink-0" title="Voice Input">
                    <i data-lucide="mic" class="h-5 w-5"></i>
                </button>
                <input type="text" id="chatInput" class="flex-1 bg-transparent border-0 focus:ring-0 px-3 text-sm text-foreground outline-none w-full" placeholder="Tanya tentang wisata Indonesia..." autocomplete="off">
                <button id="sendBtn" class="p-3 bg-primary text-white rounded-xl hover:bg-teal-800 transition-colors border-0 flex items-center justify-center shrink-0 shadow-sm">
                    <i data-lucide="send" class="h-5 w-5"></i>
                </button>
            </div>
            <div class="text-center mt-3 flex items-center justify-center gap-1.5 text-xs text-muted-foreground font-medium">
                <i data-lucide="sparkles" class="h-3.5 w-3.5 text-accent"></i> Powered by Gemini AI
            </div>
        </div>

    </div>
</div>

<style>
.typing-dot { width: 6px; height: 6px; background: #0F766E; border-radius: 50%; animation: typing 1s infinite ease-in-out; display: inline-block; }
.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing { 0%,100%{transform:translateY(0);opacity:0.4} 50%{transform:translateY(-4px);opacity:1} }

#voiceBtn.recording { color: #F59E0B; animation: pulse 1.5s infinite; background: #FEF3C7; }
@keyframes pulse { 0%,100%{box-shadow:0 0 0 0 rgba(245, 158, 11, 0.4)} 50%{box-shadow:0 0 0 6px rgba(245, 158, 11, 0)} }

/* Markdown styling inside chatbot */
.chatbot-markdown { line-height: 1.6; }
.chatbot-markdown p { margin-bottom: 0.75rem; }
.chatbot-markdown p:last-child { margin-bottom: 0; }
.chatbot-markdown ul, .chatbot-markdown ol { padding-left: 1.5rem; margin-bottom: 0.75rem; }
.chatbot-markdown li { margin-bottom: 0.25rem; }
.chatbot-markdown strong { font-weight: 700; color: #1E293B; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatArea   = document.getElementById('chatArea');
    const chatInput  = document.getElementById('chatInput');
    const sendBtn    = document.getElementById('sendBtn');
    const voiceBtn   = document.getElementById('voiceBtn');
    const loadingEl  = document.getElementById('loadingIndicator');
    const csrfToken  = '{{ csrf_token() }}';
    const userInitials = '{{ substr(Auth::user()->name, 0, 2) }}';

    function scrollBottom() { chatArea.scrollTop = chatArea.scrollHeight; }
    scrollBottom();

    function addUserBubble(text) {
        const div = document.createElement('div');
        div.className = 'flex flex-row-reverse gap-4 animate-[fadeIn_0.3s_ease-out] mb-6';
        div.innerHTML = `
            <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-sm uppercase">
                ${userInitials}
            </div>
            <div class="bg-primary text-white rounded-2xl rounded-tr-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%]">
                <p class="m-0 text-sm leading-relaxed">${text}</p>
            </div>`;
        chatArea.insertBefore(div, loadingEl);
        scrollBottom();
    }

    function addBotBubble(text, isHtml = false) {
        const div = document.createElement('div');
        div.className = 'flex gap-4 animate-[fadeIn_0.3s_ease-out] mb-6';
        let content = isHtml ? text : text.replace(/\n/g, '<br>');
        div.innerHTML = `
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-sm">
                NB
            </div>
            <div class="bg-white rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm border border-gray-100 max-w-[85%] sm:max-w-[75%] overflow-x-auto">
                <div class="m-0 text-foreground text-sm leading-relaxed chatbot-markdown">${content}</div>
            </div>`;
        chatArea.insertBefore(div, loadingEl);
        scrollBottom();
    }

    async function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;
        
        addUserBubble(message);
        chatInput.value = '';
        sendBtn.disabled = true;
        sendBtn.classList.add('opacity-50');
        loadingEl.classList.remove('hidden');
        loadingEl.classList.add('flex');
        scrollBottom();
        
        try {
            const res = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ message }),
            });
            const data = await res.json();
            
            loadingEl.classList.add('hidden');
            loadingEl.classList.remove('flex');
            
            if (data.replyHtml) {
                addBotBubble(data.replyHtml, true);
            } else {
                addBotBubble(data.reply || 'Maaf, terjadi kesalahan.', false);
            }
        } catch(e) {
            loadingEl.classList.add('hidden');
            loadingEl.classList.remove('flex');
            addBotBubble('Maaf, tidak bisa terhubung ke server. Silakan periksa koneksi internet Anda.');
        }
        
        sendBtn.disabled = false;
        sendBtn.classList.remove('opacity-50');
    }

    sendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', e => { if(e.key === 'Enter') sendMessage(); });

    document.querySelectorAll('.quick-q').forEach(btn => {
        btn.addEventListener('click', () => { 
            chatInput.value = btn.dataset.q; 
            sendMessage(); 
        });
    });

    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SR();
        recognition.lang = 'id-ID';
        
        recognition.onresult = e => { 
            chatInput.value = e.results[0][0].transcript; 
            voiceBtn.classList.remove('recording'); 
            // Optional: automatically send when speech recognition finishes
            // sendMessage();
        };
        
        recognition.onend = () => voiceBtn.classList.remove('recording');
        
        voiceBtn.addEventListener('click', () => {
            if (voiceBtn.classList.contains('recording')) { 
                recognition.stop(); 
            } else { 
                recognition.start(); 
                voiceBtn.classList.add('recording'); 
            }
        });
    } else {
        voiceBtn.disabled = true;
        voiceBtn.title = 'Browser tidak mendukung voice input';
        voiceBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
});
</script>
@endsection
