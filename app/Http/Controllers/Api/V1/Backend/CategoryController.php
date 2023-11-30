<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Validator;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $categories = Category::all();
     return CategoryResource::collection($categories);     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();
        if($validatedData){

        $image = $request->file('img_url');

        $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(576,479)->save('upload/CategoryImage/'.$make_name);
        $uploadPath = 'upload/CategoryImage/'.$make_name;

            $category = Category::create([
                'category_name' => $request->category_name,
                'image' => $uploadPath
            ]);

            return response()->json(['success' => 'Category added successfully', 'category' => $category], 200);
        }else{
            return response()->json(['errors' => 'Validation failed'], 401);
        }
    }
    

    /**
     * Display the specified resource.
     */
public function show(string $id)
{
    $category = Category::find($id);
    if (!$category) {
    return response()->json(['errors' => 'category not found'], 404);
    }
    return new CategoryResource($category);
}

    /**
     * Update the specified resource in storage.
     */
   public function update(CategoryRequest $request, string $id)
{
    $validatedData = $request->validated();
    
        if($validatedData){

            $Category = Category::find($id);
            if(!$Category){
                return response()->json(['errors' => 'Category not found'], 404);
                }
             
                @unlink($Category->image);

                $image = $request->file('img_url');
                $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(576,479)->save('upload/CategoryImage/'.$make_name);
                $uploadPath = 'upload/CategoryImage/'.$make_name;

                    $update = [
                    'category_name'=>$request->category_name,
                    'image'=>$uploadPath
                    ];

                    $Category->fill($update);
                    $Category->save();
                    return response()->json(['success' => 'Category updated successfully','data'=>new CategoryResource($Category)], 200);
                }else{
                 return response()->json(['errors' => 'Validation failed'], 401);
                }
    
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $category = Category::find($id);
    if (!$category) {
    return response()->json(['errors' => 'category not found'], 404);
    }else{
        if (file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'category deleted successfully!',
        ], 200);
    }
}

}
