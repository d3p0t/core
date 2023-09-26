<?php

namespace D3p0t\Core\Pageable;

use D3p0t\Core\Pageable\Requests\PageableRequest;
use D3p0t\Core\Pageable\Requests\SortableRequest;

class PageRequest
{

    private int $per_page;
    private int $page_number;

    private SortRequest $sort_request;

    private function __construct(
        int $per_page,
        int $page_number,
        SortRequest $sort_request
    ) {
        $this->per_page = $per_page;
        $this->page_number = $page_number;

        $this->sort_request = $sort_request;
    }

    /**
     * Number of elements per page
     * @return int
     */
    public function perPage(): int
    {
        return $this->per_page;
    }

    /**
     * Get page number
     * @return int
     */
    public function pageNumber(): int
    {
        return $this->page_number;
    }

    /**
     * Get Sort request
     * @return SortRequest
     */
    public function sortRequest(): SortRequest {
        return $this->sort_request;
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
