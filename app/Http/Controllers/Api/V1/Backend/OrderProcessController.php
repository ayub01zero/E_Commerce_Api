<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Response;
use App\Http\Filters\V1\OrderFilter;
use App\Http\Controllers\Api\V1\ApiController;
class OrderProcessController extends ApiController
{
    
    public function GetAllOrders(OrderFilter $filters) {
        if ($this->include('user')) {
            return OrderResource::collection(Order::with('user')->filter($filters)->paginate());
        }elseif ($this->include('orderItems')) {
            return OrderResource::collection(Order::with('orderItems')->filter($filters)->paginate());
        }
        return OrderResource::collection(Order::filter($filters)->paginate());
    }
    

public function statusOrderProcess($orderId)
{
    $order = Order::find($orderId);

    if (!$order) {
        return response()->json(['message' => 'Order Not Found'], Response::HTTP_NOT_FOUND);
    }

    $statusTransitions = [
        'pending' => 'confirmed',
        'confirmed' => 'delivered',
    ];

    if (!isset($statusTransitions[$order->status])) {
        if ($order->status === 'delivered') {
            return response()->json(['message' => 'The process is finished'], Response::HTTP_OK);
        }
        
      return response()->json(['message' => 'The process is not finished'], Response::HTTP_BAD_REQUEST);
    }

    $order->status = $statusTransitions[$order->status];
    $order->save();

    return response()->json(['message' => 'Order status updated', 'status' => $order->status], Response::HTTP_OK);
}



}
