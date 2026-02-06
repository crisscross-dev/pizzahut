<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'requires_auth' => true,
                'message' => 'Please login to place your order.',
            ], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cod,gcash,maya',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:pizzas,id',
            'cart.*.size' => 'required|in:small,medium,large',
            'cart.*.quantity' => 'required|integer|min:1|max:10',
        ]);

        // Calculate totals
        $subtotal = 0;
        $cartItems = [];
        $unavailableItems = [];

        foreach ($validated['cart'] as $item) {
            $pizza = Pizza::findOrFail($item['id']);

            if (!$pizza->is_visible || !$pizza->is_available) {
                $unavailableItems[] = $pizza->name;
                continue;
            }

            $sizeMultiplier = match ($item['size']) {
                'small' => 0.8,
                'medium' => 1.0,
                'large' => 1.3,
            };

            $unitPrice = $pizza->price * $sizeMultiplier;
            $totalPrice = $unitPrice * $item['quantity'];
            $subtotal += $totalPrice;

            $cartItems[] = [
                'pizza_id' => $pizza->id,
                'pizza_name' => $pizza->name,
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
            ];
        }

        if (!empty($unavailableItems)) {
            $names = implode(', ', array_values(array_unique($unavailableItems)));

            return response()->json([
                'success' => false,
                'message' => "Some items in your cart are unavailable: {$names}. Please remove them and try again.",
                'unavailable_items' => array_values(array_unique($unavailableItems)),
            ], 422);
        }

        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart has no available items. Please update your cart and try again.',
            ], 422);
        }

        $deliveryFee = 50.00; // ₱50 delivery fee
        $tax = $subtotal * 0.12; // 12% VAT
        $total = $subtotal + $deliveryFee + $tax;

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'delivery_address' => $validated['address'],
            'city' => $validated['city'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            $order->items()->create($item);
        }

        // Update user info if fields are empty
        /** @var User $user */
        $user = Auth::user();
        if (!$user->phone) $user->phone = $validated['phone'];
        if (!$user->address) $user->address = $validated['address'];
        if (!$user->city) $user->city = $validated['city'];
        $user->save();

        // Send order confirmation email
        try {
            Mail::to($order->customer_email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            // Log error but don't fail the order
            Log::error('Failed to send order confirmation email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'order_number' => $order->order_number,
            'order_id' => $order->id,
        ]);
    }

    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();
        $orders = $user->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function track(Order $order)
    {
        // Ensure user can only view their own orders
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $order->load('items.pizza');

        return view('orders.track', compact('order'));
    }

    public function trackByNumber(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        // Allow tracking if user is the owner or if checking by order number
        if (Auth::check() && Auth::id() === $order->user_id) {
            return redirect()->route('orders.track', $order);
        }

        return view('orders.track', compact('order'));
    }
}
