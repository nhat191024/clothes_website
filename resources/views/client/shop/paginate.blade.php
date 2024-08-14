{{-- <div class="col-lg-12 text-center">
    <div class="pagination__option">
        <a href="#"><i class="fa fa-angle-left"></i></a>
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#"><i class="fa fa-angle-right"></i></a>
        
    </div>
</div> --}}

@if ($paginator->hasPages())
    <div class="col-lg-12 text-center">
        <div class="pagination__option">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="#" class="disabled"><i class="fa fa-angle-left"></i></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-angle-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="active">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a>
            @else
                <a href="#" class="disabled"><i class="fa fa-angle-right"></i></a>
            @endif
        </div>
    </div>
@endif

