<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function addToFavorite(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Products::find($productId);
    
        if (!$product) {
            return response()->json([
                "error" => "Product with ID $productId does not exist.",
            ], 404);
        }
    
        $isAlreadyFavorite = $user->favorites()->where('product_id', $productId)->exists();

        if ($isAlreadyFavorite) {
            return response()->json([
                "error" => "Product with ID $productId is already in favorites.",
            ], 400);
        }
    
        $favoriteItem = $user->favorites()->create([
            'product_id' => $productId,
        ]);
    
        return response()->json([
           "message" => "Product added to favorites successfully",
           "Favorite" => $favoriteItem,
        ], 201);
    }
    

    
    
    public function removeFromFavorite($id)
{
    $favoriteItem = Favorite::find($id);

    if (!$favoriteItem) {
        return response()->json([
            "error" => "Favorite with ID $id does not exist.",
        ], 404);
    }

    $favoriteItem->delete();

    return response()->json([
        "message" => 'Item removed from Favorite'
    ], 200);
}

  

        


    public function getFavorite()
    {
        $user = Auth::user();
        $Favorite = $user->favorites()->with('product')->get();

        return response()->json(["Favorite" => $Favorite],200);
    }

}
