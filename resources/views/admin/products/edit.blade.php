@extends('layouts.admin')

@section('title', 'Edit Pizza')
@section('subtitle', 'Update product details')

@section('content')
<style>
    .settings-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 14px;
        padding: 16px;
    }

    .setting-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 0;
    }

    .setting-row+.setting-row {
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .setting-title {
        font-weight: 600;
    }

    .setting-desc {
        margin-top: 4px;
        color: var(--text-muted);
        font-size: 12px;
        line-height: 1.4;
    }

    .help-text {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 6px;
        line-height: 1.4;
    }
</style>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.products.update', $pizza) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Pizza Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $pizza->name) }}" required placeholder="e.g., Margherita Supreme">
            @error('name')
            <p style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description *</label>
            <textarea name="description" class="form-control" required placeholder="Describe your pizza, ingredients, etc.">{{ old('description', $pizza->description) }}</textarea>
            @error('description')
            <p style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Ingredients *</label>
            <input type="text" name="ingredients" class="form-control"
                value="{{ old('ingredients', is_array($pizza->ingredients) ? implode(', ', $pizza->ingredients) : ($pizza->ingredients ?? '')) }}"
                required placeholder="e.g., Mozzarella, Tomato sauce, Basil">
            <p class="help-text">Separate ingredients with commas.</p>
            @error('ingredients')
            <p style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Price (₱) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $pizza->price) }}" required min="0" step="0.01" placeholder="0.00">
                @error('price')
                <p style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="classic" {{ old('category', $pizza->category) == 'classic' ? 'selected' : '' }}>Classic</option>
                    <option value="gourmet" {{ old('category', $pizza->category) == 'gourmet' ? 'selected' : '' }}>Gourmet</option>
                    <option value="specialty" {{ old('category', $pizza->category) == 'specialty' ? 'selected' : '' }}>Specialty</option>
                    <option value="vegetarian" {{ old('category', $pizza->category) == 'vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                </select>
                @error('category')
                <p style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Upload Image</label>
            @if($pizza->image)
            <div style="margin-bottom: 10px;">
                <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px;">
            </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            <p class="help-text">Upload a new pizza image (JPG/PNG/WebP). If you upload an image, it will be used instead of the Image URL.</p>
            @error('image')
            <p style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Image URL</label>
            <input type="url" name="image_url" class="form-control" value="{{ old('image_url', $pizza->image) }}" placeholder="https://example.com/pizza.jpg">
            <p class="help-text">Optional alternative to upload. Leave blank to keep current image (or use default).</p>
            @error('image_url')
            <p style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Settings</label>
            <div class="settings-card">
                <div class="setting-row">
                    <div>
                        <div class="setting-title">Available for Order</div>
                        <div class="setting-desc">Customers can order this pizza</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $pizza->is_available) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-row">
                    <div>
                        <div class="setting-title">Visible on Store</div>
                        <div class="setting-desc">Show on the storefront</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="is_visible" value="0">
                        <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $pizza->is_visible) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $pizza->sort_order) }}" min="0" placeholder="0">
            <p style="font-size: 12px; color: var(--text-muted); margin-top: 5px;">
                Lower numbers appear first. Leave as 0 for default ordering.
            </p>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Update Pizza
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection