<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $branches = Branch::paginate(10);
        $branches = Branch::all();

        return $branches;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:255",
            "address" => "required|min:3|max:255",
            "address_location" => "required",

        ]);

        $newClient = Branch::create($request->all());
        return $newClient;
    }


    public function show(Branch $branch)
    {
        if (!$branch) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        return response()->json([
            'data' => $branch,
            'status' => 'success',
        ], 200);
    }

    public function getBranchById( $id)

    {
        $branch= Branch::find($id);
        

        return $branch;
    }


    // public function update(Request $request, Branch $branch)
    public function update(Request $request,  $id)

    {
        $branch= Branch::find($id);
        if(is_null($branch)){
            return response()->json(['message'=>'branch not found'],404);
        }
        $request->validate([
            'name' => ['sometimes', 'required', 'min:3', 'max:255'],
            'address' => ['sometimes', 'required', 'min:3', 'max:255'],
            'address_location' => ['sometimes', 'required'],
        ]);

        $branch->update($request->all());

        // return response()->json($branch);
        return $branch;
    }


    public function destroy(Branch $branch)
    {
        $branch->delete();
        return response()->json('deleted')->setStatusCode(204);
    }
}
