<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Events\OrderPlaced;
use App\Events\OrderNotifications;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Notifications\AdminPushNotification;


class CheckoutController extends Controller
{        

    public function checkoutOrders(CheckoutRequest $request)
    {
        $validatedData = $request->validated();
        
        $user = $this->getUser();
        if (!$user) {
            return $this->userNotFoundResponse();
        }
    
        $totalPoints = $this->calculateTotalPoints($validatedData['cartData']);
        $usedPoints = $validatedData['used_point'];
    
        $this->updateUserPoints($user, $usedPoints, $totalPoints);
    
        try {
            $order = $this->createOrder($user, $validatedData, $usedPoints);
    
            $this->saveOrderItems($order, $validatedData['cartData']);
    
            $message = "New order added by {$user->name}";
            event(new OrderPlaced($order->user->email));
            event(new OrderNotifications($message));
          
    
            return response()->json(['message' => 'Order placed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }
    
    private function getUser()
    {
        return User::find(auth()->id());
    }
    
    private function userNotFoundResponse()
    {
        return response()->json(['error' => 'User not found'], 404);
    }
    
    private function calculateTotalPoints($cartData)
    {
        $totalPoints = 0;
        foreach ($cartData as $cartItem) {
            $product = Products::find($cartItem['id']);
            if ($product) {
                $totalPoints += $product->points;
            }
        }
        return $totalPoints;
    }
    
    private function updateUserPoints($user, $usedPoints, $totalPoints)
    {
        if ($usedPoints >= 0 && $user->points >= $usedPoints) {
            $user->points -= $usedPoints;
        }
    
        $user->points += $totalPoints;
        $user->save();
    }
    
    private function createOrder($user, $validatedData, $usedPoints)
    {
        return Order::create([
            'user_id' => $user->id,
            'amount' => $validatedData['total_amount'],
            'notes' => $validatedData['notes'],
            'payment_method' => $validatedData['payment_method'],
            'invoice_no' => 'NUM' . mt_rand(10000000, 99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'), 
            'used_point' => $usedPoints,
            'status' => 'pending',
            'created_at' => Carbon::now(),  
        ]);
    }
    
    private function saveOrderItems($order, $cartData)
    {
        $orderItems = [];
        foreach ($cartData as $cartItem) {
            $orderItems[] = new OrderItem([
                'product_id' => $cartItem['id'],
                'qty' => $cartItem['qty'],
                'price' => $cartItem['price'],
            ]);
        }
        $order->orderItems()->saveMany($orderItems);
    }



    public function viewPastOrders()
{
    $user = $this->getUser();
    if (!$user) {
        return $this->userNotFoundResponse();
    }

    $orders = Order::where('user_id', $user->id)
                   ->with('orderItems')
                   ->orderBy('created_at', 'desc')
                   ->get();

    if ($orders->isEmpty()) {
        return response()->json(['message' => 'No orders found'], 404);
    }

    return response()->json(['orders' => $orders], 200);
}

public function declineOrder($orderId)
{
    $user = $this->getUser();
    if (!$user) {
        return $this->userNotFoundResponse();
    }
    
    $order = Order::where(['id' => $orderId, 'user_id' => $user->id])->first();

    if (!$order) {
    return response()->json(['message' => 'Order not found'], 404);}
    if ($order->status !== 'pending') {
    return response()->json(['message' => 'Order cannot be declined'], 400);}
    try {
        $order->update([
            'return_order' => 1,
            'return_date' => now()->toDateTimeString(),
            'status' => 'declined' 
        ]);

        return response()->json(['message' => 'Order declined successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to decline order: ' . $e->getMessage()], 500);
    }
}




}


