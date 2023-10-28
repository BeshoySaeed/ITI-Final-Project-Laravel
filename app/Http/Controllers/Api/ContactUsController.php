<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function __construct()
    {
        $this->middleware("is_admin")->except('store');
    }

    public function index()
    {
        // $contactUsData = ContactUs::paginate(4);

        $contactUsData = ContactUs::all();
        return $contactUsData;
   
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "first_name" => "required|min:3|max:255",
            "last_name" => "required|min:3|max:255",
            "email" => "required|email|unique:contact_us,email,except,id",
            "message" => "min:2",
            "mobile" => "required",
        ]);

        $newClient = ContactUs::create($request->all());
        return new ContactUsResource($newClient);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        if (!$contactUs) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        return response()->json([
            'data' => $contactUs,
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        $request->validate([
            "first_name" => "sometimes|required|min:3|max:255",
            "last_name" => "sometimes|required|min:3|max:255",
            "email" => "sometimes|required|email|unique:contact_us,email,except,id",
            "message" => "min:2",
            "mobile" => "sometimes|required",
        ]);

        $contactUs->update($request->all());

        return new ContactUsResource($contactUs);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        $contactUs->delete();
        return response()->json('deleted')->setStatusCode(204);
    }
}
