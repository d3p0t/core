<?php

namespace D3p0t\Core\Pageable;

use D3p0t\Core\Pageable\Requests\PageableRequest;
use D3p0t\Core\Pageable\Requests\SortableRequest;

class PageRequest
{

    private int $perPage;
    private int $pageNumber;

    private SortRequest $sortRequest;

    private function __construct(
        int $perPage,
        int $pageNumber,
        SortRequest $sortRequest
    ) {
        $this->per_page = $perPage;
        $this->page_number = $pageNumber;

        $this->sortRequest = $sortRequest;
    }

    /**
     * Number of elements per page
     * @return int
     */
    public function perPage(): int
    {
        return $this->perPage;
    }

    /**
     * Get page number
     * @return int
     */
    public function pageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * Get Sort request
     * @return SortRequest
     */
    public function sortRequest(): SortRequest {
        return $this->sortRequest;
    }

    public static function fromRequest(PageableRequest $request, SortableRequest $sortableRequest): PageRequest
    {
        return new PageRequest(
            $request->input('per_page', 20),
            $request->input('page_number', 0),
            SortRequest::fromRequest($sortableRequest)
        );
    }


}
