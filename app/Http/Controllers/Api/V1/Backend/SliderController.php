<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Products;
use Carbon\Carbon;
use Validator;
use Intervention\Image\Facades\Image;
use App\Http\Resources\SliderResource;

class SliderController extends Controller
{


   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Slider = Slider::all();
        return SliderResource::collection($Slider);     
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(SliderRequest $request)
{
    $validatedData = $request->validated();

    if ($validatedData) {
        $image = $request->file('img_url');

        $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(576, 479)->save('upload/SliderImage/' . $make_name);
        $uploadPath = 'upload/SliderImage/' . $make_name;

        // Check if the product with the given ID exists
        $product = Products::find($request->product_id);

        if ($product) {
            $slider = Slider::create([
                'product_id' => $request->product_id,
                'image' => $uploadPath
            ]);

            return response()->json(['success' => 'Slider added successfully', 'Slider' => $slider], 200);
        } else {
            return response()->json(['errors' => 'Product does not exist'], 404);
        }
    } else {
        return response()->json(['errors' => 'Validation failed'], 401);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = slider::find($id);
    if (!$slider) {
    return response()->json(['errors' => 'slider not found'], 404);
    }
    return new SliderResource($slider);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, string $id)
    {
        $validatedData = $request->validated();
    
        if($validatedData){

            $slider = Slider::find($id);
            if(!$slider){
                return response()->json(['errors' => 'slider not found'], 404);
                }
             
                @unlink($slider->image);
                $image = $request->file('img_url');
                $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(576,479)->save('upload/SliderImage/'.$make_name);
                $uploadPath = 'upload/SliderImage/'.$make_name;

            // Check if the product with the given ID exists
            $product = Products::find($request->product_id);

            if ($product) {
                    $update = [
                    'product_id'=>$request->product_id,
                    'image'=>$uploadPath
                    ];
                    $slider->fill($update);
                    $slider->save();
                }
                  
                return response()->json(['success' => 'slider updated successfully','data'=>new SliderResource($slider)], 200);
                }else{
                 return response()->json(['errors' => 'Validation failed'], 401);
                }
     }
                            /**
    
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
        return response()->json(['errors' => 'slider not found'], 404);
        }else{
            if (file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }
            $slider->delete();
            return response()->json([
                'status' => true,
                'message' => 'slider deleted successfully!',
            ], 200);
        }
    }
}
