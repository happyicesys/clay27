<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrderFromCart(Cart $cart, array $customerData)
    {
        $totalAmount = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $order = Order::create([
            'user_id' => $cart->user_id,
            'customer_email' => $customerData['email'],
            'customer_name' => $customerData['name'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'transaction_id' => Str::uuid(), // Temporary reference
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        return $order;
    }
}
