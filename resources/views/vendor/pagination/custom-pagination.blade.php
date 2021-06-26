@if ($paginator->hasPages() && $paginator->currentPage() <= $paginator->lastPage())
    @php
        $totalItemsPagination = 5;
    @endphp
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-circle pg-primary-custom d-flex justify-content-center" role="navigation">

            @if($paginator->currentPage() > 3)
                <li class="page-item  clearfix d-none d-md-block">
                    <a href="{{ $paginator-> url(1) }}" class="page-link">Primero</a>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                </li>
            @endif

            @php
                $initPage = 1;
                // si esta dentro de las pagina finales
                if($paginator->currentPage() <= $totalItemsPagination -2){
                    $initPage = 1;
                // si esta dentro de las paginas intermedias
                }else if($paginator->currentPage() >= $paginator->lastPage() - 2 ){
                    $initPage = $paginator->lastPage() - ($totalItemsPagination - 1);
                // si esta dentro de las paginas iniciales
                }else{
                    $initPage = $paginator->currentPage()-2;
                }
            @endphp

            @for ($i=0;$i < $totalItemsPagination ;$i++)

                @if($initPage+$i > $paginator->lastPage())
                    @break
                @endif

                @if ($initPage+$i  == $paginator->currentPage())
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $paginator->currentPage() }}</span>
                    </li>
                @else
                    @if ($initPage+$i  < $initPage+$totalItemsPagination && $initPage+$i  >= $initPage)
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($initPage+$i) }}">
                                {{ $initPage+$i }}
                            </a>
                        </li>
                    @endif
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                </li>
            @endif

            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item clearfix d-none d-md-block">
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link">Último</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
