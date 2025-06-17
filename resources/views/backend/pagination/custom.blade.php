@if ($paginator->hasPages())
    <nav class="Page navigation" style="margin-left: 10px;">
        <ul class="pagination pagination-rounded">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Prev</a></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Prev</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><a class="page-link" href="#">{{ $element }}</a></li>
                @endif

                {{-- Array of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="#">{{ $page }} <span class="visually-hidden">(current)</span></a>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a></li>
            @else
                <li class="page-item disabled"><a class="page-link" href="#" aria-disabled="true">Next</a></li>
            @endif
        </ul>
    </nav>
@endif
