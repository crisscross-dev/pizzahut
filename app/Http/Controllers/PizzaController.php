<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index()
    {
        // Show only visible pizzas. Unavailable pizzas remain visible but cannot be ordered.
        $pizzas = Pizza::visible()->ordered()->get();
        $featuredPizzas = Pizza::where('is_featured', true)->visible()->ordered()->get();

        return view('shop.index', compact('pizzas', 'featuredPizzas'));
    }

    public function show(Pizza $pizza)
    {
        if (!$pizza->is_visible) {
            abort(404);
        }

        return view('shop.show', compact('pizza'));
    }

    public function cart()
    {
        return view('shop.cart');
    }

    public function checkout()
    {
        return view('shop.checkout');
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        // In a real application, you would process the order here
        // For now, we'll just return a success response

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'order_number' => 'PH-' . strtoupper(uniqid()),
        ]);
    }

    public function getCartData()
    {
        // This would typically fetch from session or database
        return response()->json([
            'items' => [],
            'total' => 0,
        ]);
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1|max:10',
            'size' => 'required|in:small,medium,large',
        ]);

        $pizza = Pizza::findOrFail($validated['pizza_id']);

        if (!$pizza->is_visible) {
            return response()->json([
                'success' => false,
                'message' => 'This product is not available in the store.',
            ], 404);
        }

        if (!$pizza->is_available) {
            return response()->json([
                'success' => false,
                'message' => 'This pizza is currently unavailable.',
            ], 422);
        }

        $sizeMultiplier = match ($validated['size']) {
            'small' => 0.8,
            'medium' => 1.0,
            'large' => 1.3,
        };

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $pizza->id,
                'name' => $pizza->name,
                'price' => $pizza->price * $sizeMultiplier,
                'quantity' => $validated['quantity'],
                'size' => $validated['size'],
                'image' => $pizza->image,
            ],
        ]);
    }
}
