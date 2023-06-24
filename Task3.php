<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class Task3
{
    public function Task3()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $orders = Order::with(['orderItems.product.category'])
            ->whereHas('orderItems.product.category', function ($query) {
                $query->where('name', 'Electronics');
            })
            ->where('created_at', '>', $thirtyDaysAgo)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $arrayOfOrders = [];
        foreach ($orders as $order) {
            $orderObj = new stdClass();
            $orderObj->id = $order->id;
            $orderObj->create_at = $order->created_at;

            foreach ($order->orderItems as $orderItem) {
                $orderObj->orderItems->product_name = $orderItem->product->name;
                $orderObj->orderItems->category_name = $orderItem->category->name;
            }
            $arrayOfOrders[] = $orderObj;
        }
        return $arrayOfOrders;
    }

}
