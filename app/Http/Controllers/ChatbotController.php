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

        // Gemini API requires the conversation to strictly alternate and START with 'user'.
        // If it starts with 'model', remove the first element.
        while (count($contents) > 0 && $contents[0]['role'] === 'model') {
            array_shift($contents);
        }

        $apiKey = env('GEMINI_API_KEY');
        $botReply = 'Maaf, saya sedang mengalami gangguan. Silakan coba lagi.';
        
        try {
            $response = Http::timeout(30)->retry(3, 1500)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}",
                [
                    'system_instruction' => [
                        'parts' => [['text' => 'Kamu adalah asisten wisata Indonesia bernama NusaBot. Bantu wisatawan dengan informasi destinasi wisata, kuliner, budaya, dan rekomendasi perjalanan di Indonesia. Jawab dalam Bahasa Indonesia yang ramah dan informatif.']]
                    ],
                    'contents' => $contents,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? $botReply;
            } else {
                \Illuminate\Support\Facades\Log::error('Gemini API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gemini Exception: ' . $e->getMessage());
        }

        ChatHistory::create([
            'user_id' => Auth::id(),
            'role'    => 'assistant',
            'message' => $botReply,
        ]);

        $replyHtml = \Illuminate\Support\Str::markdown($botReply);
        return response()->json([
            'reply' => $botReply,
            'replyHtml' => $replyHtml
        ]);
    }

    public function clearHistory()
    {
        ChatHistory::where('user_id', Auth::id())->delete();
        return redirect()->route('chatbot.index')->with('success', 'Riwayat chat berhasil dihapus!');
    }
}
