@if($paginator->hasPages())
<ul class="pagination pagine">
    {{-- Previous Page Link --}}
    @if($paginator->currentPage() > 5)
        <li class="page-item"><a href="javascript:;" class="page-link">
            <img src="{{asset('public/front_assets/images/chevron-down2.png')}}" alt="">
            </a>
        </li>
    @endif
    @if ($paginator->onFirstPage())
        <li class="page-item disabled"><a href="<?php echo $paginator->url( $paginator->currentPage() - 1 ); ?>"  class="page-item"><img src="{{asset('public/front_assets/images/chevron-down2.png')}}" alt=""></a></li>
    @else
        <li class="page-item disabled"><a href="<?php echo $paginator->url( $paginator->currentPage() - 1 ); ?>"  class="page-item"><img src="{{asset('public/front_assets/images/chevron-down2.png')}}" alt=""></a></li>
    @endif
    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif
        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><a class="actv page-link" href="javascript:;">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
   
        <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}"><img src="{{asset('public/front_assets/images/chevron-down1.png')}}" alt=""></a></li>
    @else
        
        <li class="page-item"><a href="<?php echo $paginator->url( $paginator->currentPage() - 1 ); ?>"  class="page-item"><img src="{{asset('public/front_assets/images/chevron-down1.png')}}" alt=""></a></li>
    @endif
    {{-- @if($paginator->lastPage() >= $paginator->currentPage()+1)
        
        <li class="page-item"><a href="{{ $paginator->url( $paginator->currentPage() + 1 ) }}"  class="page-item"><img src="{{asset('public/front_assets/images/chevron-down1.png')}}" alt=""></a></li>
    @endif --}}
</ul>
@endif