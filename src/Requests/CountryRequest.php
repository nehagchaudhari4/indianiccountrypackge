<?php

namespace Indianiic\Country\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
        /*return [
            'name' => 'required',
            'phone_code' => 'required',
            'country_code' => 'required'
        ];*/

        $rules = [];
        if (request()->method() === 'PUT') {
            $id = decrypt($this->route()->parameter('country'));
            $rules = array_merge($rules, [
                'name' => ['required', 'string',  'max:255', 'regex:/^[^\s]+(\s*[^\s]+)*$/', 'unique:countries,name,' . $id.',id'],
                'phone_code' => ['required', 'string',  'max:255', 'regex:/^[^\s]+(\s*[^\s]+)*$/', 'unique:countries,phone_code,' . $id.',id'],
                'country_code' => ['required', 'string',  'max:255', 'regex:/^[^\s]+(\s*[^\s]+)*$/', 'unique:countries,country_code,' . $id.',id'],
            ]);
        } else {
            $rules = array_merge($rules, [
                'name' => ['required', 'string', 'max:255', 'regex:/^[^\s]+(\s*[^\s]+)*$/', 'unique:countries'],
                'phone_code' => ['required', 'string', 'max:255', 'regex:/^[^\s]+(\s*[^\s]+)*$/', 'unique:countries'],
                'country_code' => ['required', 'string', 'max:255', 'regex:/^[^\s]+(\s*[^\s]+)*$/', 'unique:countries'],
            ]);

        }

        return $rules;

    }

    public function messages()
    {
        return [
            'name.regex' => 'The name may not contain whitespace.',
            'phone_code.regex' => 'The phone code may not contain whitespace.',
            'country_code.regex' => 'The country code may not contain whitespace.'
        ];
    }
}
