<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Coupon;
use Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Coupon = Coupon::latest()->get();
        return CouponResource::collection($Coupon);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $coupon = Coupon::create([
                'coupon_name' => strtoupper($validatedData['coupon_name']),
                'coupon_discount' => $validatedData['coupon_discount'],
                'coupon_validity' => $validatedData['coupon_validity'],
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);
    
            return response()->json([
                'message' => 'Coupon created successfully',
                'coupon' => $coupon,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->getMessage()], 422);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Coupon = Coupon::find($id);
        if (!$Coupon) {
        return response()->json(['errors' => 'Coupon not found'], 404);
        }
        return new CouponResource($Coupon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $coupon = Coupon::findOrFail($id);
            $coupon->update([
                'coupon_name' => strtoupper($request->coupon_name),
                'coupon_discount' => $request->coupon_discount,
                'coupon_validity' => $request->coupon_validity,
            ]);
    
            return response()->json([
                'coupon' => $coupon,
                'message' => 'Coupon updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => 'Coupon not found'], 404);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $Coupon = Coupon::find($id);
    if (!$Coupon) {
    return response()->json(['errors' => 'Coupon not found'], 404);
    }else{
        $Coupon->delete();
        return response()->json([
            'status' => true,
            'message' => 'Coupon deleted successfully!',
        ], 200);
    }
    }
}
