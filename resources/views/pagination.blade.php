

@if($paginator->hasPages())
<nav aria-label="Page navigation example" class="pag-box meet-pag smllr">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item"><a class="page-link" href="javascript:;">
            <img src="{{ asset('public/images/Frame.png') }}" />
            </a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="<?php echo $paginator->url( $paginator->currentPage() - 1 ); ?>">
            <img src="{{ asset('public/images/Frame.png') }}" />
            </a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif
        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item"><a href="javascript:;" class="page-link this-pg">{{ $page }}</a></li>
        @else
        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                <img src="{{ asset('public/images/Frame1.png') }}" class="next-page" />
            </a>
        </li>
        @else
        <li class="page-item"><a class="page-link" href="javascript:;">
                <img src="{{ asset('public/images/Frame1.png') }}" class="next-page" />
            </a>
        </li>
        @endif
    </ul>
    </nav>
@endif