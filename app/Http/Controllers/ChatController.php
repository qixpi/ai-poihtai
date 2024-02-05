<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function generateChatBasedResponse(Request $request)
    {
        $request->validate([
            'content' => 'required',
            // data validation 
        ]);

        $userRole = $request->input('role', 'user');
        $userContent = $request->input('content', 'Tell me something.');

        $messages = [
            ['role' => 'system', 'content' => 'You are a greek poet who will return a poem of exactly 4 sentences in greek to the input the user provided. You should have basic Greek language skills.Keep each sentence short.'],
            ['role' => $userRole, 'content' => $userContent],
        ];

        $prompt = collect($messages)->pluck('content')->implode("\n");

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
            'max_tokens' => 500,
        ]);

        $result = $response->json();

        return view('chat.index', ['response' => $result['choices'][0]['message']['content'],
            'submittedValues' => [
                'role' => $userRole,
                'content' => $userContent,
            ],]);
    }
}
