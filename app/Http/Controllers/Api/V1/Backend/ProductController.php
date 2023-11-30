<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductImage;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $products = Products::with('images')->get();
    return ProductResource::collection($products);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
{

    $validatedData = $request->validated();

    if ($validatedData) {
        $product = Products::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'weight' => $request->product_weight,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_des' => $request->short_des,
            'long_des' => $request->long_des,
            'show_slider' => $request->show_slider,
            'week_deals' => $request->week_deals,
            'special_offer' => $request->special_offer,
            'new_products' => $request->new_products,
            'discount_products' => $request->discount_products,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);


        $images = $request->file('images');

        foreach($images as $img){

        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(400,400)->save('upload/ProductImage/'.$make_name);
        $uploadPath = 'upload/ProductImage/'.$make_name;

        ProductImage::insert([

            'product_id' => $product->id,
            'url' => $uploadPath,
            'created_at' => Carbon::now(), 

        ]); 
        } 

        return response()->json([
            'success' => 'Product added successfully',
            'product' => $product
        ], 200);
    }

    return response()->json(['errors' => 'Validation failed'], 422);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $product = Products::find($id);
    if (!$product) {
    return response()->json(['errors' => 'Product not found'], 404);
    }
    return new ProductResource($product);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
      try {
        $product = products::findOrFail($id);
        $product->update([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'weight' => $request->product_weight,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_des' => $request->short_des,
            'long_des' => $request->long_des,
            'show_slider' => $request->show_slider,
            'week_deals' => $request->week_deals,
            'special_offer' => $request->special_offer,
            'new_products' => $request->new_products,
            'discount_products' => $request->discount_products,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        
        return response()->json([
            'product' => $product,
            'message' => 'product updated successfully',
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['errors' => 'product not found'], 404);
    }
    }


    
    public function updateImages(Request $request, string $id)
{
    $request->validate([
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $productImages = ProductImage::where('product_id', $id)->get();
    $Product = Products::find($id);

    if ($productImages->isEmpty()) {
        return response()->json(['message' => 'Product not found'], 404);
    } else {
        foreach ($productImages as $image) {
            @unlink(public_path($image->url));
            $image->delete(); 
        }

        $images = $request->file('images');
        foreach($images as $img){

            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(400,400)->save('upload/ProductImage/'.$make_name);
            $uploadPath = 'upload/ProductImage/'.$make_name;

            ProductImage::create([
                'product_id' => $Product->id,
                'url' => $uploadPath,
            ]);
        }
        return response()->json([
            'message' => 'Images Update Successfully',
            'Images' => $productImages->pluck('url'),
        ], 200);
    }
}

    /**
     * Remove the specified resource from storage.
     */
 public function destroy(string $id)
{
    $product = Products::find($id);
    if (!$product)
    {
     return response()->json(['errors' => 'Product not found'], 404);
    }
    $images = ProductImage::where('product_id', $id)->get();
    foreach ($images as $image) {
        if (file_exists(public_path($image->url))) {
            unlink(public_path($image->url));
        }
    $image->delete();
    }
    $product->delete();

    return response()->json([
        'status' => true,
        'message' => 'Product deleted successfully!',
    ], 200);
}

}
