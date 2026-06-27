@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header border-0 py-3 px-4 d-flex align-items-center justify-content-between"
                    style="background: linear-gradient(135deg, #e63946, #c1121f);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width:45px; height:45px;">
                            <i class="fa-solid fa-robot text-danger fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white">NusaBot ??</div>
                            <small class="text-white opacity-75">Asisten Wisata Indonesia · Online</small>
                        </div>
                    </div>
                    <form action="{{ route('chatbot.clear') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-light rounded-3"
                            onclick="return confirm('Hapus semua riwayat chat?')">
                            <i class="fa-solid fa-trash me-1"></i>Hapus Riwayat
                        </button>
                    </form>
                </div>

                <div class="card-body p-4" id="chatArea"
                    style="height:450px; overflow-y:auto; background:#f8f9fa;">

                    <div class="d-flex gap-2 mb-3">
                        <img src="https://ui-avatars.com/api/?name=NB&background=e63946&color=fff&size=35"
                            class="rounded-circle flex-shrink-0" width="35" height="35">
                        <div class="bg-white rounded-4 rounded-tl-0 px-3 py-2 shadow-sm" style="max-width:80%;">
                            <p class="mb-0">Halo! Aku <strong>NusaBot</strong> ??, asisten wisata Indonesia. Tanya apa saja tentang destinasi wisata, kuliner, atau budaya Indonesia!</p>
                        </div>
                    </div>

                    @foreach($histories as $chat)
                        @if($chat->role === 'user')
                            <div class="d-flex flex-row-reverse gap-2 mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e3342f&color=fff&size=35"
                                    class="rounded-circle flex-shrink-0" width="35" height="35">
                                <div class="rounded-4 rounded-tr-0 px-3 py-2 text-white"
                                    style="max-width:80%; background:#e63946;">
                                    <p class="mb-0">{{ $chat->message }}</p>
                                </div>
                            </div>
                        @else
                            <div class="d-flex gap-2 mb-3">
                                <img src="https://ui-avatars.com/api/?name=NB&background=e63946&color=fff&size=35"
                                    class="rounded-circle flex-shrink-0" width="35" height="35">
                                <div class="bg-white rounded-4 rounded-tl-0 px-3 py-2 shadow-sm" style="max-width:80%;">
                                    <p class="mb-0">{!! nl2br(e($chat->message)) !!}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div id="loadingIndicator" class="d-none d-flex gap-2 mb-3">
                        <img src="https://ui-avatars.com/api/?name=NB&background=e63946&color=fff&size=35"
                            class="rounded-circle flex-shrink-0" width="35" height="35">
                        <div class="bg-white rounded-4 px-3 py-2 shadow-sm">
                            <div class="d-flex gap-1 align-items-center" style="height:20px;">
                                <span class="typing-dot"></span>
                                <span class="typing-dot"></span>
                                <span class="typing-dot"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-2 border-top bg-white">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-sm btn-outline-danger rounded-pill quick-q"
                            data-q="Rekomendasikan destinasi wisata terbaik di Bali">??? Wisata Bali</button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill quick-q"
                            data-q="Apa kuliner khas Jawa Timur yang wajib dicoba?">?? Kuliner Jatim</button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill quick-q"
                            data-q="Tempat wisata alam terbaik di Indonesia">?? Wisata Alam</button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill quick-q"
                            data-q="Tips perjalanan ke Raja Ampat">?? Raja Ampat</button>
                    </div>
                </div>

                <div class="card-footer border-0 bg-white p-3">
                    <div class="input-group">
                        <button id="voiceBtn" class="btn btn-outline-secondary rounded-start-3" title="Voice Input">
                            <i class="fa-solid fa-microphone"></i>
                        </button>
                        <input type="text" id="chatInput" class="form-control border-start-0 border-end-0"
                            placeholder="Tanya tentang wisata Indonesia..." autocomplete="off">
                        <button id="sendBtn" class="btn text-white rounded-end-3 px-4" style="background:#e63946;">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                    <small class="text-muted mt-1 d-block text-center">
                        <i class="fa-solid fa-shield-halved me-1"></i>Powered by Gemini AI
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.typing-dot { width:8px; height:8px; background:#e63946; border-radius:50%; animation:typing 1s infinite ease-in-out; display:inline-block; }
.typing-dot:nth-child(2) { animation-delay:0.2s; }
.typing-dot:nth-child(3) { animation-delay:0.4s; }
@keyframes typing { 0%,100%{transform:translateY(0);opacity:0.4} 50%{transform:translateY(-6px);opacity:1} }
#voiceBtn.recording { background:#e63946; color:white; animation:pulse 1s infinite; }
@keyframes pulse { 0%,100%{box-shadow:0 0 0 0 rgba(230,57,70,0.4)} 50%{box-shadow:0 0 0 8px rgba(230,57,70,0)} }
</style>

<script>
const chatArea   = document.getElementById('chatArea');
const chatInput  = document.getElementById('chatInput');
const sendBtn    = document.getElementById('sendBtn');
const voiceBtn   = document.getElementById('voiceBtn');
const loadingEl  = document.getElementById('loadingIndicator');
const csrfToken  = '{{ csrf_token() }}';
const userAvatar = 'https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e3342f&color=fff&size=35';

function scrollBottom() { chatArea.scrollTop = chatArea.scrollHeight; }
scrollBottom();

function addUserBubble(text) {
    const div = document.createElement('div');
    div.className = 'd-flex flex-row-reverse gap-2 mb-3';
    div.innerHTML = `<img src="${userAvatar}" class="rounded-circle flex-shrink-0" width="35" height="35">
        <div class="rounded-4 rounded-tr-0 px-3 py-2 text-white" style="max-width:80%; background:#e63946;">
            <p class="mb-0">${text}</p></div>`;
    chatArea.insertBefore(div, loadingEl);
    scrollBottom();
}

function addBotBubble(text) {
    const div = document.createElement('div');
    div.className = 'd-flex gap-2 mb-3';
    div.innerHTML = `<img src="https://ui-avatars.com/api/?name=NB&background=e63946&color=fff&size=35"
        class="rounded-circle flex-shrink-0" width="35" height="35">
        <div class="bg-white rounded-4 rounded-tl-0 px-3 py-2 shadow-sm" style="max-width:80%;">
            <p class="mb-0">${text.replace(/\n/g, '<br>')}</p></div>`;
    chatArea.insertBefore(div, loadingEl);
    scrollBottom();
}

async function sendMessage() {
    const message = chatInput.value.trim();
    if (!message) return;
    addUserBubble(message);
    chatInput.value = '';
    sendBtn.disabled = true;
    loadingEl.classList.remove('d-none');
    scrollBottom();
    try {
        const res = await fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ message }),
        });
        const data = await res.json();
        loadingEl.classList.add('d-none');
        addBotBubble(data.reply || 'Maaf, terjadi kesalahan.');
    } catch(e) {
        loadingEl.classList.add('d-none');
        addBotBubble('Maaf, tidak bisa terhubung ke server.');
    }
    sendBtn.disabled = false;
}

sendBtn.addEventListener('click', sendMessage);
chatInput.addEventListener('keydown', e => { if(e.key === 'Enter') sendMessage(); });

document.querySelectorAll('.quick-q').forEach(btn => {
    btn.addEventListener('click', () => { chatInput.value = btn.dataset.q; sendMessage(); });
});

if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
    const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = new SR();
    recognition.lang = 'id-ID';
    recognition.onresult = e => { chatInput.value = e.results[0][0].transcript; voiceBtn.classList.remove('recording'); };
    recognition.onend = () => voiceBtn.classList.remove('recording');
    voiceBtn.addEventListener('click', () => {
        if (voiceBtn.classList.contains('recording')) { recognition.stop(); }
        else { recognition.start(); voiceBtn.classList.add('recording'); }
    });
} else {
    voiceBtn.disabled = true;
    voiceBtn.title = 'Browser tidak mendukung voice input';
}
</script>
@endsection
