<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        $histories = ChatHistory::where('user_id', Auth::id())
            ->latest()->take(20)->get()->reverse()->values();
        return view('chatbot.index', compact('histories'));
    }

    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $userMessage = $request->message;

        ChatHistory::create([
            'user_id' => Auth::id(),
            'role'    => 'user',
            'message' => $userMessage,
        ]);

        $histories = ChatHistory::where('user_id', Auth::id())
            ->latest()->take(10)->get()->reverse()->values();

        $contents = [];
        foreach ($histories as $h) {
            $contents[] = [
                'role'  => $h->role === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $h->message]],
            ];
        }

        $apiKey = env('GEMINI_API_KEY');
        $response = Http::post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
            [
                'system_instruction' => [
                    'parts' => [['text' => 'Kamu adalah asisten wisata Indonesia bernama NusaBot. Bantu wisatawan dengan informasi destinasi wisata, kuliner, budaya, dan rekomendasi perjalanan di Indonesia. Jawab dalam Bahasa Indonesia yang ramah dan informatif.']]
                ],
                'contents' => $contents,
            ]
        );

        $botReply = 'Maaf, saya sedang mengalami gangguan. Silakan coba lagi.';
        if ($response->successful()) {
            $data = $response->json();
            $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? $botReply;
        }

        ChatHistory::create([
            'user_id' => Auth::id(),
            'role'    => 'assistant',
            'message' => $botReply,
        ]);

        if ($request->ajax()) {
            return response()->json(['reply' => $botReply]);
        }
        return redirect()->route('chatbot.index');
    }

    public function clearHistory()
    {
        ChatHistory::where('user_id', Auth::id())->delete();
        return redirect()->route('chatbot.index')->with('success', 'Riwayat chat berhasil dihapus!');
    }
}
