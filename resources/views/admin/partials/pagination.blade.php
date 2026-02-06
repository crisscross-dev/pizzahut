@php
/** @var \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */

$current = (int) $paginator->currentPage();
$last = (int) $paginator->lastPage();

$window = 1;
$showAll = $last <= 7;

    $start=$showAll ? 1 : max(1, $current - $window);
    $end=$showAll ? $last : min($last, $current + $window);
    @endphp

    <style>
    .admin-pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    }

    .page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: var(--text);
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.2s ease;
    user-select: none;
    }

    .page-btn:hover {
    transform: translateY(-1px);
    border-color: rgba(255, 255, 255, 0.16);
    background: rgba(255, 255, 255, 0.06);
    }

    .page-btn.active {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-color: transparent;
    color: var(--text);
    }

    .page-btn.disabled {
    opacity: 0.45;
    pointer-events: none;
    transform: none;
    }

    .page-ellipsis {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    padding: 0 10px;
    color: var(--text-muted);
    font-weight: 600;
    }
    </style>

    <nav class="admin-pagination" role="navigation" aria-label="Pagination Navigation">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
        <span class="page-btn disabled" aria-disabled="true">Prev</span>
        @else
        <a class="page-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">Prev</a>
        @endif

        {{-- Page Numbers --}}
        @if (!$showAll)
        {{-- First page --}}
        <a class="page-btn {{ $current === 1 ? 'active' : '' }}" href="{{ $paginator->url(1) }}" aria-label="Page 1">1</a>

        @if ($start > 2)
        <span class="page-ellipsis" aria-hidden="true">…</span>
        @endif
        @endif

        @for ($page = $start; $page <= $end; $page++)
            @if ($showAll || ($page !==1 && $page !==$last))
            <a class="page-btn {{ $page === $current ? 'active' : '' }}" href="{{ $paginator->url($page) }}" aria-label="Page {{ $page }}">{{ $page }}</a>
            @endif
            @endfor

            @if (!$showAll)
            @if ($end < $last - 1)
                <span class="page-ellipsis" aria-hidden="true">…</span>
                @endif

                @if ($last > 1)
                <a class="page-btn {{ $current === $last ? 'active' : '' }}" href="{{ $paginator->url($last) }}" aria-label="Page {{ $last }}">{{ $last }}</a>
                @endif
                @endif

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <a class="page-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">Next</a>
                @else
                <span class="page-btn disabled" aria-disabled="true">Next</span>
                @endif
    </nav>