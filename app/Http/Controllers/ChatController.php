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
        if ($request['message']) {
            $response = Http::withToken(env('GROQ_API_KEY')) // groq
                //$response = Http::withToken(env('OPENROUTER_API_KEY')) //openrouter
                //$response = Http::withToken(env('HF_TOKEN')) //hugging face
                //$response = Http::withToken(env('OPENAI_API_KEY')) //open ai not working
                //$response = Http::withToken(env('GEMINI_API_KEY')) //GEMINI
                ->acceptJson()
                ->post('https://api.groq.com/openai/v1/chat/completions', [ // groq
                    //->post('https://openrouter.ai/api/v1/chat/completions', [ //openrouter
                    //->post('https://router.huggingface.co/v1/chat/completions', [ //hugging face
                    //->post('https://api.openai.com/v1/chat/completions', [ //open ai not working
                    //->post('https://generativelanguage.googleapis.com/v1beta/openai/chat/completions', [ //GEMINI
                    //'model' => 'openai/gpt-oss-120b',                          // groq model
                    //'model' => 'llama-3.3-70b-versatile',                    // groq model
                    //'model' => 'llama-3.1-8b-instant',                       // groq model
                    'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',  // groq model for image recognition
                    //'model' => 'nvidia/nemotron-3-super-120b-a12b:free',     // openrouter
                    //'model' => 'openai/gpt-oss-120b:groq',                   // hugging face
                    //'model' => 'gpt-5.4',                                    // open ai not working
                    //'model' => 'gemini-3-flash-preview',                     // gemini
                    'messages' => [
                        [
                            "role" => "user",
                            "content" => [
                                [
                                    'type' => 'text',
                                    'text' => $request['message'],
                                ],
                                //[
                                //    'type' => "image_url",
                                //    "image_url" => [
                                //        'url' => $request['image_link'],
                                //    ]
                                //]
                            ],
                        ]
                    ],
                ]);

            $aaa = $response->json('choices.0.message');
            $bbb = $aaa['role'];
            return Inertia::render('viewjs/chat/index', [
                //'response' => ["data" => $response->json()],
                'response' => $aaa, //$response->json('choices.0.message'),
            ]);

        } else
            return Inertia::render('viewjs/chat/index'); // Renders the Vue component
    }

    public function index_automation(Request $request)
    {
        if ($request['message']) {
            $response = Http::withToken(env('GROQ_API_KEY')) // groq
                //$response = Http::withToken(env('OPENROUTER_API_KEY')) //openrouter
                //$response = Http::withToken(env('HF_TOKEN')) //hugging face
                //$response = Http::withToken(env('OPENAI_API_KEY')) //open ai
                //$response = Http::withToken(env('GEMINI_API_KEY')) //GEMINI
                ->acceptJson()
                ->post('https://api.groq.com/openai/v1/chat/completions', [ // groq
                    //->post('https://openrouter.ai/api/v1/chat/completions', [ //openrouter
                    //->post('https://router.huggingface.co/v1/chat/completions', [ //hugging face
                    //->post('https://api.openai.com/v1/chat/completions', [ //open ai
                    //->post('https://generativelanguage.googleapis.com/v1beta/openai/chat/completions', [ //GEMINI
                    'model' => 'openai/gpt-oss-120b',     // groq model
                    //'model' => 'llama-3.3-70b-versatile', // groq model
                    //'model' => 'llama-3.1-8b-instant',    // groq model
                    //'model' => 'nvidia/nemotron-3-super-120b-a12b:free', //openrouter
                    //'model' => 'openai/gpt-oss-120b:groq', //hugging face
                    //'model' => 'gpt-5.4', // open ai
                    //'model' => 'gemini-3-flash-preview', // gemini
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful assistant that outputs only valid JSON: {action: ..., model: ..., data: ...}'
                        ],
                        [
                            "role" => "user",
                            "content" => $request['message'],
                        ]
                    ],
                    'response_format' => [
                        'type' => 'json_object'
                    ],
                    'temperature' => 0 // Set to 0 for consistent JSON structure
                ]);

            return Inertia::render('viewjs/chat/index_automation', [
                'response' => $response->json('choices.0.message'),
            ]);

        } else
            return Inertia::render('viewjs/chat/index_automation'); // Renders the Vue component
    }
}
