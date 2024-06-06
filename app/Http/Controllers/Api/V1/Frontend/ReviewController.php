<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\ReviewRequest;
use App\traits\apiResponse;
use App\Http\Controllers\Api\V1\ApiController;
use App\Policies\ReviewPolicy;


class ReviewController extends Controller
{

    
    // protected $policyClass = ReviewPolicy::class;
    use apiResponse;
    public function __construct()
    {
        $this->authorizeResource(Review::class, 'review');
    }

    public function index()
    { 
        
        return $this->successResponse(ReviewResource::collection(Review::latest()->get()));
      
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
