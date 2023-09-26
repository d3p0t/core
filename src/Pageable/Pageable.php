<?php

namespace D3p0t\Core\Pageable;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Pageable
{

    private bool $first;

    private bool $last;

    private PageRequest $pageRequest;

    private Array $items;

    private int $totalItems;

    private int $totalPages;

    public function __construct(PageRequest $pageRequest, LengthAwarePaginator $paginator)
    {
        $this->pageRequest = $pageRequest;
        $this->items = $paginator->items();
        $this->totalItems = $paginator->total();
        
        $this->totalPages = intval(ceil($paginator->total() / $paginator->perPage()));

        $this->first = $pageRequest->pageNumber() === 0;
        $this->last = $pageRequest->pageNumber() >= ($this->totalPages() - 1);
    }

    public function pageRequest(): PageRequest
    {
        return $this->pageRequest;
    }

    public function items(): Array
    {
        return $this->items;
    }

    public function totalItems(): int
    {
        return $this->totalItems;
    }

    public function totalPages(): int
    {
        return $this->totalPages;
    }

    public function first(): bool
    {
        return $this->first;
    }

    public function last(): bool
    {
        return $this->last;
    }

}
