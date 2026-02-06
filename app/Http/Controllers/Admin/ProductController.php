<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'classic' => 'Classic',
            'gourmet' => 'Gourmet',
            'specialty' => 'Specialty',
            'vegetarian' => 'Vegetarian',
        ];

        $selectedCategory = $request->query('category');

        $query = Pizza::ordered();

        if ($selectedCategory && array_key_exists($selectedCategory, $categories)) {
            $query->where('category', $selectedCategory);
        } else {
            $selectedCategory = null;
        }

        $pizzas = $query->paginate(15)->withQueryString();

        return view('admin.products.index', compact('pizzas', 'categories', 'selectedCategory'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'ingredients' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'category' => 'required|string|in:classic,gourmet,specialty,vegetarian',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'is_visible' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Process ingredients from comma-separated string to array
        $validated['ingredients'] = array_map('trim', explode(',', $validated['ingredients']));

        // Handle image upload or URL
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pizzas', 'public');
            $validated['image'] = Storage::url($path);
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $validated['image_url'];
        }
        unset($validated['image_url']);

        // Set defaults
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_available'] = $request->boolean('is_available', true);
        $validated['is_visible'] = $request->boolean('is_visible', true);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        if ($validated['sort_order'] <= 0) {
            $validated['sort_order'] = (Pizza::max('sort_order') ?? 0) + 1;
        }

        Pizza::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Pizza created successfully!');
    }

    public function edit(Pizza $pizza)
    {
        return view('admin.products.edit', compact('pizza'));
    }

    public function update(Request $request, Pizza $pizza)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'ingredients' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'category' => 'required|string|in:classic,gourmet,specialty,vegetarian',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'is_visible' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Process ingredients
        $validated['ingredients'] = array_map('trim', explode(',', $validated['ingredients']));

        // Handle image (do not clear existing image unless explicitly changed)
        unset($validated['image']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pizzas', 'public');
            $validated['image'] = Storage::url($path);
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $validated['image_url'];
        }
        unset($validated['image_url']);

        $validated['is_featured'] = $request->boolean('is_featured', $pizza->is_featured);
        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_visible'] = $request->boolean('is_visible');

        $pizza->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Pizza updated successfully!');
    }

    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return redirect()->route('admin.products.index')->with('success', 'Pizza deleted successfully!');
    }

    public function toggleVisibility(Pizza $pizza)
    {
        $pizza->update(['is_visible' => !$pizza->is_visible]);
        return response()->json(['success' => true, 'is_visible' => $pizza->is_visible]);
    }

    public function toggleAvailability(Pizza $pizza)
    {
        $pizza->update(['is_available' => !$pizza->is_available]);
        return response()->json(['success' => true, 'is_available' => $pizza->is_available]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            Pizza::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
