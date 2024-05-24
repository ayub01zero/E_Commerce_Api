<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\ReviewRequest;
use App\traits\apiResponse;


class ReviewController extends Controller
{

    use apiResponse;
    public function __construct()
    {
        $this->authorizeResource(Review::class, 'review');
    }

    public function index()
    {
        $reviews = Review::latest()->get();
        return $this->successResponse(ReviewResource::collection($reviews));
      
    }

    public function store(ReviewRequest $request)
    {
        $review = Review::create($request->validated());
        return $this->successResponse(new ReviewResource($review));
    
    }

    public function show(Review $review)
    {
        return $this->successResponse(new ReviewResource($review));
    }

   
}
