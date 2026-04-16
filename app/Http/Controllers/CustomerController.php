<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Mem;
use App\Http\Requests\StoreMemRequest;
use App\Http\Requests\UpdateMemRequest;

class CustomerController extends Controller
{
    public function scan_id_using_ai(StoreCustomerRequest $request)
    {
        $file = $request->file('license_image');
        $imageType = $file->getClientOriginalExtension();
        $imageContent = base64_encode(file_get_contents($file->getRealPath()));
        //$imageContent = base64_encode(file_get_contents($file->path()));
        //$imageContent = base64_encode($file->get());
        $base64Image = "data:image/{$imageType};base64,{$imageContent}";
        $messages = [
            // message[0]
            [
                "role" => "system",
                "content" => [
                    // content[0]
                    [
                        "type" => "text",
                        "text" => "you are an ID scanning expert AI model. scan the ID picture and output a JSON format accurately, JSON:{'id_type': ....,'full_name': [FamilyName<comma><space>GivenName<space> MiddleName],'nationality': ....,'sex': [Male/Female],'date_of_birth': mm/dd/yyyy ,'weight': ....,'height': ....,'address': ....,'id_no': ....,'expiry_date': mm/dd/yyyy,'agency_code': ....,'blood_type': ....,'eyes_color': ....,'dl_codes': ....,'conditions': ....,}",
                    ],
                ]
            ],
            // message[1]
            [
                "role" => "user", // "user"
                "content" => [
                    // content[0] // text content
                    [
                        'type' => 'text',
                        'text' => 'please scan the id picture and output a JSON format as specified by the system',
                    ],
                    // conternt[1] // image content to be analyze
                    [
                        "type" => "image_url",
                        "image_url" => [
                            "url" => $base64Image,
                        ]
                    ],
                ]
            ],
        ];

        $response = Http::withToken(env('GROQ_API_KEY'))                 // groq api key
            ->acceptJson()
            ->post('https://api.groq.com/openai/v1/chat/completions', [  // groq server
                'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',  // groq model for image recognition
                'messages' => $messages,                                 // messages to be sent to groc
                "max_completion_tokens" => 1024,
                "top_p" => 1,
                "stream" => false,
                "stop" => null,
                "temperature" => 0,
                "response_format" => [
                    "type" => "json_object"
                ],
            ]);

        // save scanning result to mems
        $memRequest = new StoreMemRequest([
            'user_id' => Auth::user()->id,
            'process' => 'scanning license id',
            'key' => 'id_data',
            'value' => json_encode($response->json()["choices"][0]["message"]["content"]),//json_encode($messages), // // json_encode($messages) . "\n" .
        ]);
        Mem::updateOrCreate([
            'user_id' => Auth::user()->id,
            'process' => 'scanning license id',
            'key' => 'id_data',
        ], $memRequest->all());
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(StoreCustomerRequest $request)
    {
        if ($request["name"] && ($request["name"] != "")) { // if index has search parameter
            $customers = Customer::where("name", "like", "%" . $request["name"] . "%")->paginate(2000);
            return Inertia::render('viewjs/customer/index', [
                'customers' => $customers,
                'name' => $request["name"],
            ]);
        } else // if index has no search parameter
            return Inertia::render('viewjs/customer/index', [
                'customers' => Customer::paginate(3),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // retreive mems
        $mems = Mem::where("user_id", "=", Auth::user()->id)->where('process', "=", 'scanning license id')->where('key' , "=", 'id_data')->get();
        return Inertia::render('viewjs/customer/create', [
            'mems' => $mems
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        // saving and extracting uploaed picture
        if ($request->hasFile('license_image')) {
            $request->merge([
                // local file upload, VPS
                'license_link' => config('alphaenvironment.LOCAL_URL') . $request->file('license_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('govt_id_image')) {
            $request->merge([
                // local file upload, VPS
                'govt_id_link' => config('alphaenvironment.LOCAL_URL') . $request->file('govt_id_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('portrait_image')) {
            $request->merge([
                // local file upload, VPS
                'portrait_link' => config('alphaenvironment.LOCAL_URL') . $request->file('portrait_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic1_image')) {
            $request->merge([
                // local file upload, VPS
                'pic1_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic1_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic2_image')) {
            $request->merge([
                // local file upload, VPS
                'pic2_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic2_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic3_image')) {
            $request->merge([
                // local file upload, VPS
                'pic3_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic3_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $customer = Customer::create($request->all());
        return redirect()->route(
            'customer.show',
            [
                'customer' => $customer
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return Inertia::render(
            'viewjs/customer/show',
            [
                'customer' => $customer
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return Inertia::render(
            'viewjs/customer/edit',
            [
                'customer' => $customer
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        // saving and extracting uploaed picture
        if ($request->hasFile('license_image')) {
            $request->merge([
                // local file upload, VPS
                'license_link' => config('alphaenvironment.LOCAL_URL') . $request->file('license_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('govt_id_image')) {
            $request->merge([
                // local file upload, VPS
                'govt_id_link' => config('alphaenvironment.LOCAL_URL') . $request->file('govt_id_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('portrait_image')) {
            $request->merge([
                // local file upload, VPS
                'portrait_link' => config('alphaenvironment.LOCAL_URL') . $request->file('portrait_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic1_image')) {
            $request->merge([
                // local file upload, VPS
                'pic1_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic1_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic2_image')) {
            $request->merge([
                // local file upload, VPS
                'pic2_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic2_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic3_image')) {
            $request->merge([
                // local file upload, VPS
                'pic3_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic3_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $customer->update($request->all());
        return redirect()->route(
            'customer.show',
            [
                'customer' => $customer
            ]
        );
    }

    public function update_ajax(UpdateCustomerRequest $request, Customer $customer)
    {
        // saving and extracting uploaed picture
        if ($request->hasFile('license_image')) {
            $request->merge([
                // local file upload, VPS
                'license_link' => config('alphaenvironment.LOCAL_URL') . $request->file('license_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('govt_id_image')) {
            $request->merge([
                // local file upload, VPS
                'govt_id_link' => config('alphaenvironment.LOCAL_URL') . $request->file('govt_id_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('portrait_image')) {
            $request->merge([
                // local file upload, VPS
                'portrait_link' => config('alphaenvironment.LOCAL_URL') . $request->file('portrait_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic1_image')) {
            $request->merge([
                // local file upload, VPS
                'pic1_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic1_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic2_image')) {
            $request->merge([
                // local file upload, VPS
                'pic2_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic2_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        if ($request->hasFile('pic3_image')) {
            $request->merge([
                // local file upload, VPS
                'pic3_link' => config('alphaenvironment.LOCAL_URL') . $request->file('pic3_image')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $customer->update($request->all());
        return redirect()->route(
            'customer.edit',
            [
                'customer' => $customer
            ]
        );
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
