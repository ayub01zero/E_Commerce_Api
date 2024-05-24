<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Favorite,Products};
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FavoriteResource;
use App\traits\apiResponse;


class FavoriteController extends Controller
{
    use apiResponse;

    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('product')->latest()->get();
    
        return FavoriteResource::collection($favorites);
    }
    
    public function store(Request $request)
    {
        $productId = $request->input('productId');
        $user = Auth::user();
        $product = Products::find($productId);
    
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
    
        $isAlreadyFavorite = $user->favorites()->where('product_id', $productId)->exists();
    
        if ($isAlreadyFavorite) {
            return $this->errorResponse('Product already in favorites', 400);
        }
    
        $favoriteItem = $user->favorites()->create(['product_id' => $productId]);
        return $this->successResponse(
            new FavoriteResource($favoriteItem),
            'Product added to favorites',
            201
        );
    }
    
    public function destroy(string $id)
    {
        $user = Auth::user();
        $favoriteItem = Favorite::find($id);
    
        if (!$favoriteItem) {
            return $this->errorResponse('Favorite not found', 404);
        }
    
        if ($favoriteItem->user_id !== $user->id) {
            return $this->errorResponse('Unauthorized to remove this favorite item.', 403);
        }
    
        $favoriteItem->delete();
        return $this->errorResponse('Favorite removed successfully', 200);
    }
    
    
}
