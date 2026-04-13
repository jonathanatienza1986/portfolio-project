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
            dd($request['message']);

            $response = Http::withToken(env('GROQ_API_KEY'))
                ->acceptJson()
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama3-70b-8192',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $request['message']
                        ]
                    ]
                ]);

            dd($response->json());

            return response()->json([
                //'response' => $response->json('choices.0.message.content')
                'response' => $response->json(),
            ]);

            //if ($response->failed()) {
            //    return response()->json([
            //        'error' => 'API request failed',
            //        'details' => $response->body()
            //    ], 500);
            //}

            //return response()->json([
            //    'reply' => $response['choices'][0]['message']['content'] ?? 'No response'
            //]);
            //return Inertia::render('viewjs/chat/index', [
            //    'reply' => $response['choices'][0]['message']['content'] ?? 'No response'
            //]);
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
