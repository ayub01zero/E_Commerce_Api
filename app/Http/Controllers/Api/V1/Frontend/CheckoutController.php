<?php

namespace App\Http\Controllers\Api\V1\Frontend;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\CheckoutRequest;
use App\traits\apiResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Events\OrderNotifications;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Notifications\AdminPushNotification;
use App\Jobs\SendOrderPlacedEmail;
use App\Http\Resources\OrderResource;
use App\Http\Filters\V1\OrderFilter;

class CheckoutController extends ApiController
{        

    use apiResponse;
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
            event(new OrderNotifications($message));
            SendOrderPlacedEmail::dispatch($order, $user);
          
            return $this->successResponse($order, 'Order placed successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to place order: ' . $e->getMessage(), 500);

        }
    }
    
    private function getUser()
    {
        return User::find(auth()->id());
    }
    
    private function userNotFoundResponse()
    {
        return $this->errorResponse('User not found', 404);

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



    public function viewPastOrders(OrderFilter $filters)
    {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->userNotFoundResponse();
        }
    
        $query = Order::where('user_id', $user->id)
                      ->with('orderItems')
                      ->latest();
    
        // Apply the filters to the query
        $filteredQuery = $filters->apply($query);
    
        // Conditionally include the user relationship
        if ($this->include('user')) {
            $orders = $filteredQuery->get()->load('user');
        } else {
            $orders = $filteredQuery->get();
        }
    
        if ($orders->isEmpty()) {
            return $this->errorResponse('No orders found');
        }
    
        return OrderResource::collection($orders);
    }
    
    

public function declineOrder($orderId)
{
    $user = $this->getUser();
    if (!$user) {
        return $this->userNotFoundResponse();
    }
    
    $order = Order::where(['id' => $orderId, 'user_id' => $user->id])->first();

    if (!$order) {
        
 return $this->errorResponse('Order not found', 404);}
    if ($order->status !== 'pending') {
        return $this->errorResponse('Order cannot be declined', 400);}
    try {
        $order->update([
            'return_order' => 1,
            'return_date' => now()->toDateTimeString(),
            'status' => 'declined' 
        ]);

        return $this->successResponse(null,'Order declined successfully', 200);
    } catch (\Exception $e) {
        return $this->errorResponse('Failed to decline order: ' . $e->getMessage(), 500);
    }
}

}


