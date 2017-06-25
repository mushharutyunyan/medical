<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class AdminsRequest extends FormRequest
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
        $data = Request::all();
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'role_id' => 'required',
                    'organization_id' => 'required',
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'email' => 'required|min:3|unique:admins,email',
                    'password' => 'required|min:6|confirmed',
                ];
            }
            case 'PUT':
            {
                return [
                    'role_id' => 'required',
                    'organization_id' => 'required',
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'email' => 'required|min:3|unique:admins,email,'.$data['id'],
                ];
            }
            case 'PATCH':
            {
                return [
                    'password' => 'required|min:6|confirmed',
                ];
            }
        }

    }
    public function messages()
    {
        return[
            'email.required' => 'The username field is required.',
            'email.unique' => 'The username has already been taken.'
        ];
    }
}
