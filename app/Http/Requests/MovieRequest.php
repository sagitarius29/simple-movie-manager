<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'nullable|integer|exists:movies,id',
            'name'       => 'nullable|string|max:250',
            'cover'      => 'required|url|max:250',
            'url'        => 'nullable|url|max:400',
            'categories' => 'nullable|array',
        ];
    }
}
