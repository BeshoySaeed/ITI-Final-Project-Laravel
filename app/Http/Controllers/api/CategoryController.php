<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Couchbase\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



use Ramsey\Collection\Collection;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category = Category::all();

        return CategoryResource::collection($category);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "name"=>"required",
           
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
   
        $category = Category::create($request->all());
        $category->save();

        return (new CategoryResource($category))->response()->setStatusCode(201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return new CategoryResource($category);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = Validator::make($request->all(), [
            "name"=>"required",
        ]);
   
        
        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        
        $category->update($request->all());

        return new CategoryResource($category);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return response("Deleted", 204);
    }
}
