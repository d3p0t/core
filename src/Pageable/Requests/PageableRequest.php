<?php

namespace D3p0t\Core\Pageable\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageableRequest extends FormRequest
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
            'per_page'  => ['integer', 'nullable'],
            'page_number'   => ['integer', 'nullable']
        ];
    }

    public function prepareForValidation()
    {
        $this->mergeIfMissing([
            'per_page'      => 20,
            'page_number'   => 0
        ]);
    }
}
