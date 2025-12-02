<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\HitPayService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;
    protected $hitPayService;

    public function __construct(CartService $cartService, OrderService $orderService, HitPayService $hitPayService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->hitPayService = $hitPayService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        return Inertia::render('Checkout/Index', [
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
        ]);

        $cart = $this->cartService->getCart();
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $order = $this->orderService->createOrderFromCart($cart, $validated);

        $paymentRequest = $this->hitPayService->createPaymentRequest(
            $order->total_amount,
            'SGD',
            $order->transaction_id,
            route('checkout.success', ['order' => $order->id]),
            route('checkout.webhook'),
            $validated['email'],
            $validated['name']
        );

        if (isset($paymentRequest['url'])) {
            return Inertia::location($paymentRequest['url']);
        }

        return redirect()->back()->with('error', 'Payment initialization failed.');
    }

    public function success(Request $request, $orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);

        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
        ]);

        $this->cartService->clearCart();

        return Inertia::render('Checkout/Success', [
            'order' => $order->load('items'),
        ]);
    }

    public function webhook(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }
}
