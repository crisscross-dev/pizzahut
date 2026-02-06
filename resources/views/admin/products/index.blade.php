@extends('layouts.admin')

@section('title', 'Products')
@section('subtitle', '')

@section('hideHeaderTitle', true)
@section('hideUserMenu', true)

@section('content')
<style>
    .products-header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    @media (max-width: 768px) {
        .card-header {
            align-items: flex-start;
            gap: 12px;
        }

        .products-header-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .products-header-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }

    .toggle-cell {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-muted);
    }

    .status-pill.on {
        background: rgba(76, 175, 80, 0.12);
        border-color: rgba(76, 175, 80, 0.25);
        color: var(--success);
    }

    .status-pill.off {
        background: rgba(220, 53, 69, 0.10);
        border-color: rgba(220, 53, 69, 0.20);
        color: var(--danger);
    }

    .toggle-switch input[type="checkbox"][disabled]+.toggle-slider {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .admin-product-card {
        background: var(--dark-light);
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 12px;
    }

    .admin-product-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }

    .admin-product-name {
        font-weight: 700;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }

    .admin-product-desc {
        margin-top: 4px;
        font-size: 12px;
        color: var(--text-muted);
        display: -webkit-box;
        line-clamp: 2;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .admin-product-price {
        font-weight: 800;
        flex-shrink: 0;
    }

    .admin-product-mid {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 12px;
    }

    .admin-product-mid .product-image {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .admin-product-meta {
        min-width: 0;
        flex: 1;
    }

    .admin-product-badges {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .admin-product-toggles {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin-top: 12px;
    }

    .admin-product-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .admin-product-toggle-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .admin-product-actions {
        margin-top: 12px;
        display: flex;
        gap: 10px;
    }

    .admin-product-actions .btn {
        flex: 1;
        justify-content: center;
    }
</style>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">All Products</h2>
        <div class="products-header-actions">
            <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex; align-items: center; gap: 10px; margin: 0; width: 100%;">
                <select name="category" class="form-control" style="width: 190px; padding: 10px 14px; max-width: 100%;" onchange="this.form.submit()" aria-label="Filter by category">
                    <option value="">All Categories</option>
                    @foreach(($categories ?? []) as $value => $label)
                    <option value="{{ $value }}" {{ ($selectedCategory ?? null) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New Pizza
            </a>
        </div>
    </div>
    <div class="table-container admin-desktop-only">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Visible</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="products-table">
                @forelse($pizzas as $pizza)
                <tr data-id="{{ $pizza->id }}">
                    <td style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="product-image">
                        <div>
                            <div style="font-weight: 500;">{{ $pizza->name }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ Str::limit($pizza->description, 40) }}</div>
                        </div>
                    </td>
                    <td>
                        <span style="background: rgba(247, 127, 0, 0.15); color: #F77F00; padding: 4px 10px; border-radius: 6px; font-size: 12px;">
                            {{ ucfirst($pizza->category) }}
                        </span>
                    </td>
                    <td style="font-weight: 600;">₱{{ number_format($pizza->price, 0) }}</td>
                    <td>
                        <div class="toggle-cell">
                            <label class="toggle-switch" title="Toggle availability">
                                <input type="checkbox"
                                    {{ $pizza->is_available ? 'checked' : '' }}
                                    aria-label="Toggle availability"
                                    onchange="toggleAvailability({{ $pizza->id }}, this)">
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="status-pill {{ $pizza->is_available ? 'on' : 'off' }}" data-role="availability-pill">
                                {{ $pizza->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="toggle-cell">
                            <label class="toggle-switch" title="Toggle visibility">
                                <input type="checkbox"
                                    {{ $pizza->is_visible ? 'checked' : '' }}
                                    aria-label="Toggle visibility"
                                    onchange="toggleVisibility({{ $pizza->id }}, this)">
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="status-pill {{ $pizza->is_visible ? 'on' : 'off' }}" data-role="visibility-pill">
                                {{ $pizza->is_visible ? 'Visible' : 'Hidden' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.products.edit', $pizza) }}" class="action-btn edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="action-btn delete" title="Delete" data-id="{{ $pizza->id }}" data-name="{{ $pizza->name }}" onclick="deleteProduct(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                        <i class="fas fa-pizza-slice" style="font-size: 48px; opacity: 0.3; margin-bottom: 15px; display: block;"></i>
                        No products yet. Add your first pizza!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-mobile-only">
        @forelse($pizzas as $pizza)
        <div class="admin-product-card" data-id="{{ $pizza->id }}">
            <div class="admin-product-top">
                <div style="min-width: 0; flex: 1;">
                    <div class="admin-product-name">{{ $pizza->name }}</div>
                    <div class="admin-product-desc">{{ Str::limit($pizza->description, 90) }}</div>
                </div>
                <div class="admin-product-price">₱{{ number_format($pizza->price, 0) }}</div>
            </div>

            <div class="admin-product-mid">
                <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="product-image">
                <div class="admin-product-meta">
                    <div class="admin-product-badges">
                        <span style="background: rgba(247, 127, 0, 0.15); color: #F77F00; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                            {{ ucfirst($pizza->category) }}
                        </span>
                        <span class="status-pill {{ $pizza->is_available ? 'on' : 'off' }}" data-role="availability-pill">
                            {{ $pizza->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                        <span class="status-pill {{ $pizza->is_visible ? 'on' : 'off' }}" data-role="visibility-pill">
                            {{ $pizza->is_visible ? 'Visible' : 'Hidden' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="admin-product-toggles">
                <div class="admin-product-toggle-row">
                    <div class="admin-product-toggle-label">Availability</div>
                    <label class="toggle-switch" title="Toggle availability">
                        <input type="checkbox"
                            {{ $pizza->is_available ? 'checked' : '' }}
                            aria-label="Toggle availability"
                            onchange="toggleAvailability({{ $pizza->id }}, this)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="admin-product-toggle-row">
                    <div class="admin-product-toggle-label">Visibility</div>
                    <label class="toggle-switch" title="Toggle visibility">
                        <input type="checkbox"
                            {{ $pizza->is_visible ? 'checked' : '' }}
                            aria-label="Toggle visibility"
                            onchange="toggleVisibility({{ $pizza->id }}, this)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <div class="admin-product-actions">
                <a href="{{ route('admin.products.edit', $pizza) }}" class="btn btn-secondary">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <button class="btn btn-danger" type="button" data-id="{{ $pizza->id }}" data-name="{{ $pizza->name }}" onclick="deleteProduct(this)">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
            </div>
        </div>
        @empty
        <div style="text-align: center; color: var(--text-muted); padding: 20px;">
            No products yet. Add your first pizza!
        </div>
        @endforelse
    </div>

    @if($pizzas->hasPages())
    @include('admin.partials.pagination', ['paginator' => $pizzas])
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 2000; align-items: center; justify-content: center;">
    <div style="background: var(--dark-card); padding: 30px; border-radius: 16px; max-width: 400px; width: 90%;">
        <h3 style="margin-bottom: 15px;">Delete Product</h3>
        <p style="color: var(--text-muted); margin-bottom: 25px;">Are you sure you want to delete <strong id="deleteProductName"></strong>? This action cannot be undone.</p>
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let deleteProductId = null;

    function setPillState(pillEl, onText, offText, isOn) {
        if (!pillEl) return;
        pillEl.classList.toggle('on', !!isOn);
        pillEl.classList.toggle('off', !isOn);
        pillEl.textContent = isOn ? onText : offText;
    }

    async function toggleAvailability(id, checkboxEl) {
        const previousChecked = checkboxEl.checked;
        const cell = checkboxEl.closest('.toggle-cell');
        const pillEl = cell ? cell.querySelector('[data-role="availability-pill"]') : null;

        checkboxEl.disabled = true;

        try {
            const response = await fetchWithCsrf(`/admin/products/${id}/toggle-availability`, {
                method: 'POST'
            });
            const data = await response.json();

            if (!data.success) {
                throw new Error('Failed to update availability');
            }

            checkboxEl.checked = !!data.is_available;
            setPillState(pillEl, 'Available', 'Unavailable', data.is_available);
        } catch (e) {
            checkboxEl.checked = previousChecked;
            setPillState(pillEl, 'Available', 'Unavailable', previousChecked);
            alert(e.message || 'Failed to update availability');
        } finally {
            checkboxEl.disabled = false;
        }
    }

    async function toggleVisibility(id, checkboxEl) {
        const previousChecked = checkboxEl.checked;
        const cell = checkboxEl.closest('.toggle-cell');
        const pillEl = cell ? cell.querySelector('[data-role="visibility-pill"]') : null;

        checkboxEl.disabled = true;

        try {
            const response = await fetchWithCsrf(`/admin/products/${id}/toggle-visibility`, {
                method: 'POST'
            });
            const data = await response.json();

            if (!data.success) {
                throw new Error('Failed to update visibility');
            }

            checkboxEl.checked = !!data.is_visible;
            setPillState(pillEl, 'Visible', 'Hidden', data.is_visible);
        } catch (e) {
            checkboxEl.checked = previousChecked;
            setPillState(pillEl, 'Visible', 'Hidden', previousChecked);
            alert(e.message || 'Failed to update visibility');
        } finally {
            checkboxEl.disabled = false;
        }
    }

    function deleteProduct(buttonEl) {
        const id = buttonEl.dataset.id;
        const name = buttonEl.dataset.name;

        deleteProductId = id;
        document.getElementById('deleteProductName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/products/${id}`;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        deleteProductId = null;
    }

    // Close modal on outside click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection