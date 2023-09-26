<?php

namespace D3p0t\Core\Pageable;

use D3p0t\Core\Pageable\Requests\SortableRequest;

class SortRequest
{

    private String $sort_by;
    private String $sort_direction;

    private function __construct(
        String $sort_by,
        String $sort_direction
    ) {
        $this->sort_by = $sort_by;
        $this->sort_direction = $sort_direction;
    }

    /**
     * Sort by field
     * @return String
     */
    public function sortBy(): String
    {
        return $this->sort_by;
    }

    /**
     * Sort direction
     * @return String
     */
    public function sortDirection(): String
    {
        return $this->sort_direction;
    }

    public static function fromRequest(SortableRequest $request): SortRequest
    {
        return new SortRequest(
            $request->input('sort_by', 'id'),
            $request->input('sort_direction', 'asc'),
        );
    }


}
