<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;

class HomeController extends Controller
{
   
    public function HomeProduct(request $request)
    {
        $products = Products::OfCategory($request->category_id)
            ->OfSearch($request->search)
            ->OfPrice($request->price)
            ->get();
        return ProductResource::collection($products);
    }

    public function HomeCategory(request $request)
    {
        $categories = Category::ofName($request->category_name)->get();
        return CategoryResource::collection($categories);
    }
    

    public function getAllPC()
    {
        return response()->json([
            "status" => true,
            "Categories" => CategoryResource::collection(Category::all()),
            "Products" => ProductResource::collection(Products::with("images")->get()),
        ], 200);
    }


}
