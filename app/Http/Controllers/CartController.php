<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        return Inertia::render('Cart/Index', [
            'cart' => $this->cartService->getCart(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $this->cartService->addToCart($request->product_id, $request->quantity ?? 1);

        return redirect()->back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->updateQuantity($itemId, $request->quantity);

        return redirect()->back();
    }

    public function destroy($itemId)
    {
        $this->cartService->removeFromCart($itemId);
        return redirect()->back();
    }
}
