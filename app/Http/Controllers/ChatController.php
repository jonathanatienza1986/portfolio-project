<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        /*
        if ($request->filled('message')) {
            $apiResponse = Http::withToken(env('OPENAI_API_KEY'))
                ->acceptJson()
                ->post('https://api.openai.com/v1/responses', [
                    'model' => 'gpt-5.3',
                    'input' => $request->message,
                ]);

            // Convert to array
            $data = $apiResponse->json();

            // Safely extract reply
            $reply = $data['output'][0]['content'][0]['text']
                ?? 'No response from AI';

            return response()->json([
                'reply' => $data
            ]);
        } */

        if ($request['message']) {

            $response = Http::withToken(env('GROQ_API_KEY'))
                ->acceptJson()
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $request['message']
                        ]
                    ]
                ]);

            return Inertia::render('viewjs/chat/index',[
                //'response' => ["data" => $response->json()],
                'response' => $response->json('choices.0.message'),
            ]);

        } else
            return Inertia::render('viewjs/chat/index'); // Renders the Vue component
    }

    public function sendMessage(Request $request)
    {
        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/responses', [
            'model' => 'gpt-4o-mini', //'gpt-5.3',
            'input' => $request["message"],
        ]);

        return redirect()->route('chat.index', [
            'response' => $response['output'][0]['content'][0]['text'] ?? 'No response'
        ]);
        //return Inertia::render('viewjs/chat/index', [
        //    'response' => $response['output'][0]['content'][0]['text'] ?? 'No response'
        //]);
    }

}
