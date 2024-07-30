@if($paginator->hasPages())
<ul class="pagination ">
    {{-- Previous Page Link --}}
    @if($paginator->currentPage() > 5)
        <li class="page-item"><a href="javascript:;" class="page-link">
            <img src="{{URL::to('public/frontend/images/chevron-down2.png')}}" alt="" class="dpb">
            </a>
        </li>
    @endif
    @if ($paginator->onFirstPage())
 
        <li class="paginate_button previous disabled"><a href="<?php echo $paginator->url( $paginator->currentPage() - 1 ); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
    @else
        <li class="paginate_button previous disabled"><a href="<?php echo $paginator->url( $paginator->currentPage() - 1 ); ?>"><i class="fa fa-angle-left" ></i></a></li>
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
                    <li class="page-item active" style="padding: 0px 4px" aria-current="page"><a class="actv page-link" style="border-radius: 14px !important;padding: 1px 12px !important;" href="javascript:;">{{ $page }}</a></li>
                @else
                    <li class="page-item" style="padding: 0px 4px"><a class="page-link" style="border-radius: 14px !important;padding: 1px 12px !important;" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
   
        <li class="paginate_button next"><a href="{{ $paginator->nextPageUrl() }}"><img src="{{asset('public/front_assets/images/chevron-down1.png')}}" alt=""></a></li>
    @else
        
        <li class="paginate_button next"><a href="<?php echo $paginator->url( $paginator->currentPage() - 1 ); ?>"><img src="{{asset('public/front_assets/images/chevron-down1.png')}}" alt=""></a></li>
    @endif
    {{-- @if($paginator->lastPage() >= $paginator->currentPage()+1)
        
        <li class="paginate_button next"><a href="{{ $paginator->url( $paginator->currentPage() + 1 ) }}"><img src="{{asset('public/front_assets/images/chevron-down1.png')}}" alt=""></a></li>
    @endif --}}
</ul>
@endif