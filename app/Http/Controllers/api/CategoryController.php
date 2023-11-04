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

    public function __construct()
    {
        $this->middleware("is_admin")->except('index');
    }

    public function index()
    {
        //
        $category = Category::all();

        return CategoryResource::collection($category);

    }

    /**
     * Store a newly created resource in storage.
     */


         // $addition=new Addition();

        // if($request->hasFile('image')){
        //     $completeFileNmae=$request->file('image')->getClientOriginalName();
        //     $fileNameOnly=pathinfo($completeFileNmae,PATHINFO_FILENAME);
        //     $extension=$request->file('image')->getClientOriginalExtension();
        //     $compic=str_replace(' ','_',$fileNameOnly.'-'.rand().'_'.time().'.'.$extension);
        //     $path=$request->file('image')-storeAs('public/images/category',$compic);
        //     $addition->img=$compic;
        // }

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "name"=>"required",
           
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
// dd($request);
        $path = public_path('images/category');
        !is_dir($path) &&
            mkdir($path, 0777, true);


        $imageName = time() . '.' . $request->file('img')->extension();
        $request->file('img')->move($path, $imageName);

        $fullRequest = $request->all();
        $fullRequest['img'] = $imageName;
        
        $category = Category::create($fullRequest);
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
        $image_path=public_path('images/category/'. $category->img);
        if(file_exists($image_path)){
            unlink($image_path);
            $category->delete();        

    }
            return response("Deleted", 204);
    }
}