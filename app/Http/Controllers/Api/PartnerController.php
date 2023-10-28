<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function __construct()
    {
        $this->middleware("is_admin")->except('store');
    }

    public function index()
    {

        // $branches = Partner::paginate(10);
        $partner = Partner::all();
        return $partner;


    }
    public function store(Request $request)
    {
        $request->validate([
            "first_name" => "required|min:3|max:255",
            "last_name" => "required|min:3|max:255",
            "email" => "required",
            "mobile" => "required",
            "message" => "required",
        ]);
        $partner = Partner::create($request->all());
        return response()->json($partner, 201);
    }
   
    public function show(Partner $partner)
    {
        if (!$partner) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        return response()->json([
            'data' => $partner,
            'status' => 'success',
        ], 200);
    }


    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            "first_name" => "sometimes|required|min:3|max:255",
            "last_name" => "sometimes|required|min:3|max:255",
            "email" => "sometimes|required|email|unique:job_applicants,email,except,id",
            "subject" => "sometimes|required",
            "mobile" => "sometimes|required",
            "message" => "sometimes|required",
        ]);
        $partner->update($request->all());
        return response()->json($partner);
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return response()->json('deleted')->setStatusCode(204);
    }
}
