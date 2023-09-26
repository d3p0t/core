<?php

namespace D3p0t\Core\Pageable\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SortableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sort_by'       => ['string', 'nullable'],
            'sort_direction' => ['string', 'nullable']
        ];
    }

    public function prepareForValidation()
    {
        $this->mergeIfMissing([
            'sort_by'           => 'id',
            'sort_direction'    => 'asc'
        ]);
    }
}
