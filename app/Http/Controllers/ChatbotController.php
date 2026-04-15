<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Chatbot;
use App\Http\Requests\StoreChatbotRequest;
use App\Http\Requests\UpdateChatbotRequest;
use Inertia\Inertia;

class ChatbotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { //ok
        $user_id = Auth::user()->id;
        $chatbots = Chatbot::where("user_id", "=", $user_id)->where("is_chathead", "=", true)->paginate(3);
        return Inertia::render('viewjs/chatbot/index', [
            'chatbots' => $chatbots,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * from index to create
     */
    public function create() //ok
    {
        return Inertia::render('viewjs/chatbot/create');
    }

    /**
     * Store a newly created resource in storage.
     * from create to edit
     */
    public function store1(StoreChatbotRequest $request)
    { //ok
        // saving and extracting uploaed picture
        if ($request->hasFile('pic1_file')) {
            $request->merge([
                // local file upload, VPS
                'pic1_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic1_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic2_file')) {
            $request->merge([
                // local file upload, VPS
                'pic2_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic2_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic3_file')) {
            $request->merge([
                // local file upload, VPS
                'pic3_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic3_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic4_file')) {
            $request->merge([
                // local file upload, VPS
                'pic4_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic4_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $chatbot = Chatbot::create($request->all());
        $request->merge([
            'user_id' => Auth::user()->id,
            'chatbot_id' => $chatbot->id,
            'role' => "user",
            'is_chathead' => true,
            'is_analyzed' => false,
        ]);
        $chatbot->update($request->all());
        return redirect()->route('chatbot.edit', [
            'chatbot' => $chatbot
        ]);
    }

    // from show to edit
    // user_id, chatbot_id, role should already stored in $request
    public function store2(StoreChatbotRequest $request)
    { //ok
        // saving and extracting uploaed picture
        if ($request->hasFile('pic1_file')) {
            $request->merge([
                // local file upload, VPS
                'pic1_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic1_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic2_file')) {
            $request->merge([
                // local file upload, VPS
                'pic2_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic2_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic3_file')) {
            $request->merge([
                // local file upload, VPS
                'pic3_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic3_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic4_file')) {
            $request->merge([
                // local file upload, VPS
                'pic4_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic4_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $chatbot = Chatbot::create($request->all());
        $request->merge([
            'user_id' => Auth::user()->id,
            'role' => "user",
            'is_chathead' => false,
            'is_analyzed' => false,
        ]);
        $chatbot->update($request->all());
        return redirect()->route('chatbot.edit', [
            'chatbot' => $chatbot
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chatbot $chatbot) //ok
    {
        $chatbots = Chatbot::where("user_id", "=", Auth::user()->id)->where("chatbot_id", "=", $chatbot->id)->orderBy('id', 'asc')->get();
        // check for AI pending un analyzed user message
        $lastNum = -10;
        foreach ($chatbots as $chatbot1) {
            $lastNum = $chatbot1->id;
        }
        if ($lastNum > 0) {
            $chatbotx = Chatbot::find($lastNum);
            if ($chatbotx->role == "user") {
                // submit the last message for AI analysis
                $this->send_to_ai2a(new StoreChatbotRequest([
                    'message' => $chatbotx->message,
                ]), $chatbotx);
                $chatbots = Chatbot::where("user_id", "=", Auth::user()->id)->where("chatbot_id", "=", $chatbot->id)->orderBy('id', 'asc')->get();
            }
        }
        return Inertia::render('viewjs/chatbot/show', [
            'chatbots' => $chatbots,
            'chatbot' => $chatbot, // head chatbot
        ]);
    }

    /**
     * AI Setup
     */
    private function contactAI($messages)
    {
        $response = Http::withToken(env('GROQ_API_KEY'))                 // groq api key
            ->acceptJson()
            ->post('https://api.groq.com/openai/v1/chat/completions', [  // groq server
                'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',  // groq model for image recognition
                'messages' => $messages,                                 // messages to be sent to groc

                "max_completion_tokens" => 1024,
                "top_p" => 1,
                "stream" => false,
                "stop" => null,
                "temperature" => 1,
                // use this setting for high consistency output in automation
                //"temperature" => 0,
                //"response_format" => [
                //    "type" => "json_object"
                //],
            ]);
        return ($response);
    }

    /**
     * Process AI Results
     */
    private function saveAIResponse(Chatbot $chatbot, $response, $messages)
    {
        // save AI json reponse
        $ai_json_response = $response->json('choices.0.message');
        if (filled($ai_json_response)) {
            // do this if AI response is successful
            $ai_request = new StoreChatbotRequest([
                'user_id' => Auth::user()->id,
                'chatbot_id' => $chatbot->chatbot_id,
                'role' => $ai_json_response["role"],
                'message' => $ai_json_response["content"],
                'is_analyzed' => true,
                'is_error' => false,
            ]);
            Chatbot::create($ai_request->all());
            $request = new StoreChatbotRequest([
                'is_analyzed' => true,
            ]);
            $chatbot->update($request->all());
        } else {
            // do this if AI response is a failure
            $ai_request = new StoreChatbotRequest([
                'user_id' => Auth::user()->id,
                'chatbot_id' => $chatbot->chatbot_id,
                'role' => "system",
                'message' => "**input messages:**\n" . json_encode($messages) . "\n\n**output error message:**\n" . json_encode($response->json()),
                'is_analyzed' => true,
                'is_error' => true,
            ]);
            Chatbot::create($ai_request->all());
            $request = new StoreChatbotRequest([
                'is_error' => true,
            ]);
            $chatbot->update($request->all());
        }
    }

    // store data from create
    // modify chatbot_id of newly created item
    // send data to ai
    // receive and store data from ai
    // redirect route to show( root_chatbot,)
    // from create to show

    public function send_to_ai1(StoreChatbotRequest $request)
    { //ok
        // save most recent AI message, this is a chat head
        $chatbot = Chatbot::create($request->all());
        $request->merge([
            'user_id' => Auth::user()->id,
            'chatbot_id' => $chatbot->id,
            'role' => "user",
            'is_chathead' => true,
            'is_analyzed' => false,
            'is_error' => false,
        ]);
        $chatbot->update($request->all());

        // build AI message in JSON format
        $messages = [
            // message[0]
            /*
            [
                "role" => "system",
                "content" => [
                    // content[0]
                    [
                        "type" => "text",
                        "text" => "additional spceific and technical instructions for the AI model to follow and let it output a formatted JSON",
                    ],
                ]
            ],
            */
            // message[1]
            [
                "role" => $chatbot->role, // "user"
                "content" => [
                    // content[0] // text content
                    [
                        'type' => 'text',
                        'text' => $chatbot->message,
                    ],
                    // conternt[1] // image content to be analyzed
                    /*
                    [
                        "type" => "image_url",
                        "image_url" => [
                            "url" => env('APP_URL') . $chatbot->pic1_link,
                        ]
                    ],
                    */
                    // conternt[2] // image content to be analyzed
                    /*
                    [
                        "type" => "image_url",
                        "image_url" => [
                            "url" => env('APP_URL') . $chatbot->pic2_link,
                        ]
                    ],
                    */
                ]
            ],
        ];

        // contact AI with the message and wait for a response
        $response = $this->contactAI($messages);

        // save AI response to database (chatbot table)
        $this->saveAIResponse($chatbot, $response, $messages);

        // redirect to show
        return redirect()->route('chatbot.show', [
            'chatbot' => $chatbot,
        ]);
    }

    /**
     * send AI message from edit form
     * from edit to show
     */
    public function send_to_ai2(StoreChatbotRequest $request, Chatbot $chatbot)
    { //ok

        if (filled($request['message'])) {
            $request->merge([
                'role' => "user",
                'is_analyzed' => false,
                'is_error' => false,
            ]);
            $chatbot->update($request->all());
        }

        // search all the related chat messages from database
        $chatbots = Chatbot::where("user_id", "=", Auth::user()->id)->where("chatbot_id", "=", $chatbot->chatbot_id)->orderBy('id', 'asc')->get();

        // build json message to ai
        $messages = [];
        foreach ($chatbots as $chatbot1) {
            $content = [];
            $content[] = [
                'type' => 'text',
                'text' => $chatbot1->message,
            ];

            if (filled($chatbot1->pic1_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic1_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic2_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic2_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic3_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic3_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic4_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic4_link,
                    ]
                ];
            }

            $message1 = [
                "role" => $chatbot1->role,
                "content" => $content,
            ];

            if (!$chatbot1->is_error) {
                // append chatbot message if it is not erroneous
                $messages[] = $message1;
            }
        }

        // contact AI with the message and wait for a response
        $response = $this->contactAI($messages);

        // save AI response to database (chatbot table)
        $this->saveAIResponse($chatbot, $response, $messages);

        // redirect to show
        return redirect()->route('chatbot.show', [
            'chatbot' => $chatbots[0],
        ]);
    }

    private function send_to_ai2a(StoreChatbotRequest $request, Chatbot $chatbot)
    { //ok

        if (filled($request['message'])) {
            $request->merge([
                'role' => "user",
                'is_analyzed' => false,
                'is_error' => false,
            ]);
            $chatbot->update($request->all());
        }

        // search all the related chat messages from database
        $chatbots = Chatbot::where("user_id", "=", Auth::user()->id)->where("chatbot_id", "=", $chatbot->chatbot_id)->orderBy('id', 'asc')->get();

        // build json message to ai
        $messages = [];
        foreach ($chatbots as $chatbot1) {
            $content = [];
            $content[] = [
                'type' => 'text',
                'text' => $chatbot1->message,
            ];

            if (filled($chatbot1->pic1_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic1_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic2_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic2_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic3_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic3_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic4_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic4_link,
                    ]
                ];
            }

            $message1 = [
                "role" => $chatbot1->role,
                "content" => $content,
            ];

            if (!$chatbot1->is_error) {
                // append chatbot message if it is not erroneous
                $messages[] = $message1;
            }
        }

        // contact AI with the message and wait for a response
        $response = $this->contactAI($messages);

        // save AI response to database (chatbot table)
        $this->saveAIResponse($chatbot, $response, $messages);

    }

    /**
     * send AI message from show form
     * from show to show
     */
    public function send_to_ai3(StoreChatbotRequest $request)
    { //ok

        // save the latest chat message
        if (filled($request['message'])) {
            $request->merge([
                'role' => "user",
                'is_analyzed' => false,
                'is_error' => false,
                'is_chathead' => false,
            ]);
            $chatbot = Chatbot::create($request->all());
        }

        // search for related chats
        $chatbots = Chatbot::where("user_id", "=", Auth::user()->id)->where("chatbot_id", "=", $chatbot->chatbot_id)->orderBy('id', 'asc')->get();

        // build json message to AI to create a context
        $messages = [];
        foreach ($chatbots as $chatbot1) {
            $content = [];
            $content[] = [
                'type' => 'text',
                'text' => $chatbot1->message,
            ];

            if (filled($chatbot1->pic1_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic1_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic2_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic2_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic3_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic3_link,
                    ]
                ];
            }

            if (filled($chatbot1->pic4_link) && (!$chatbot1->is_analyzed)) {
                $content[] = [
                    'type' => "image_url",
                    "image_url" => [
                        'url' => env('APP_URL') . $chatbot1->pic4_link,
                    ]
                ];
            }

            $message1 = [
                "role" => $chatbot1->role,
                "content" => $content,
            ];

            if (!$chatbot1->is_error) {
                $messages[] = $message1;
            }
        }

        // contact AI with the message and wait for a response
        $response = $this->contactAI($messages);

        // save AI response to database (chatbot table)
        $this->saveAIResponse($chatbot, $response, $messages);

        // redirect to show
        return redirect()->route('chatbot.show', [
            'chatbot' => $chatbots[0],
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chatbot $chatbot)
    { // ok
        $chatbots = Chatbot::where("user_id", "=", Auth::user()->id)->where("chatbot_id", "=", $chatbot->chatbot_id)->where("is_analyzed", "=", true)->orderBy('id', 'asc')->get();
        return Inertia::render('viewjs/chatbot/edit', [
            'chatbots' => $chatbots,
            'chatbot' => $chatbot, // head chatbot
        ]);
    }

    /**
     * Update the specified resource in storage.
     * from edit to edit
     */
    public function update(UpdateChatbotRequest $request, Chatbot $chatbot)
    { //ok
        // saving and extracting uploaed picture
        if ($request->hasFile('pic1_file')) {
            $request->merge([
                // local file upload, VPS
                'pic1_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic1_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic2_file')) {
            $request->merge([
                // local file upload, VPS
                'pic2_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic2_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic3_file')) {
            $request->merge([
                // local file upload, VPS
                'pic3_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic3_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic4_file')) {
            $request->merge([
                // local file upload, VPS
                'pic4_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic4_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $chatbot->update($request->all());
        return redirect()->route('chatbot.edit', [
            'chatbot' => $chatbot
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chatbot $chatbot)
    {
        //
    }
}
