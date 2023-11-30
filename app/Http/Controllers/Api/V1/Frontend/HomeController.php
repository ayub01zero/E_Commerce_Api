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
    public function Home(request $request){
        $products = Products::OfCategory($request->category_id)
        ->OfSearch($request->search)
        ->OfPrice($request->price)
        ->with('images')->get();
    
        $categories = CategoryResource::collection(Category::all());
    
        return response()->json([
            'status' => true,
            'Category' => $categories,
            'Products' => $products,
        ], 200);
    }
    


}
