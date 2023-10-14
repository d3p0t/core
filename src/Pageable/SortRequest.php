<?php

namespace D3p0t\Core\Pageable;

use D3p0t\Core\Pageable\Requests\SortableRequest;

class SortRequest
{

    private String $sortBy;
    private String $sortDirection;

    private function __construct(
        String $sortBy,
        String $sortDirection
    ) {
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
    }

    /**
     * Sort by field
     * @return String
     */
    public function sortBy(): String
    {
        return $this->sortBy;
    }

    /**
     * Sort direction
     * @return String
     */
    public function sortDirection(): String
    {
        return $this->sortDirection;
    }

    public static function fromRequest(SortableRequest $request): SortRequest
    {
        return new SortRequest(
            $request->input('sort_by', 'id'),
            $request->input('sort_direction', 'asc'),
        );
    }


}
