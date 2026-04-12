<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
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
        return Inertia::render('viewjs/customer/create');
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
