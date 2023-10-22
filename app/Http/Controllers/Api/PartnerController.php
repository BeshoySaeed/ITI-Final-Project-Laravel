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
    public function index()
    {
        $branches = Partner::paginate(10);
        return PartnerResource::collection($branches);
    }

    public function store(Request $request)
    {
        $request->validate([
            "first_name" => "required|min:3|max:255",
            "last_name" => "required|min:3|max:255",
            "email" => "required|email|unique:partners,email,except,id",
            "subject" => "required",
            "mobile" => "required",
            "message" => "required",
        ]);
        $newClient = Partner::create($request->all());
        return new PartnerResource($newClient);
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
