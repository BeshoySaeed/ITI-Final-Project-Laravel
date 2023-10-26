<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobApplicantResource;
use App\Models\JopApplicant;
use Illuminate\Http\Request;

class JopApplicantControl  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $branches = JopApplicant::paginate(10);
        $branches = JopApplicant::all();
            return $branches;
    }


    public function store(Request $request)
    {
        $request->validate([
            "first_name" => "required|min:3|max:255",
            "last_name" => "required|min:3|max:255",
            "email" => "required",
            "title" => "required",
            "education" => "required",
            "mobile" => "required",
            "cv"=>"required"

        ]);

        $newJobOffer = JopApplicant::create($request->all());
        return $newJobOffer;
    }

    public function show(JopApplicant $jopApplicant)
    {
        if (!$jopApplicant) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        return response()->json([
            'data' => $jopApplicant,
            'status' => 'success',
        ], 200);
    }


    public function update(Request $request, JopApplicant $jopApplicant)
    {
        $request->validate([
            "first_name" => "sometimes|required|min:3|max:255",
            "last_name" => "sometimes|required|min:3|max:255",
            "email" => "sometimes|required|email|unique:job_applicants,email,except,id",
            "job_title" => "sometimes|required",
            "education" => "sometimes|required",
            "mobile" => "sometimes|required",
        ]);

        $jopApplicant->update($request->all());
        return new JobApplicantResource($jopApplicant);
    }

    public function destroy(JopApplicant $jopApplicant)
    {
        $jopApplicant->delete();
        return response()->json('deleted')->setStatusCode(204);
    }
}
