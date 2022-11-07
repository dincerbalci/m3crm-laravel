<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'first_name' => ['required'],
            'last_name' => ['required'],
            'group_id' => ['required'],
            'user_name' => [
                'required',
                Rule::unique('tbl_users')->ignore($this->id),
            ],
            'email' => [
                'required',
                Rule::unique('tbl_users')->ignore($this->id),
            ],
           // 'password' => ['required','min:6','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
           // 'confirm_password' => ['required_with:password','same:password'],
            'employee_id' => ['required'],
            'mobile_no' => ['required'],
        ];
    }
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // $this->merge([
        //     'slug' => Str::slug($this->slug),
        // ]);
        $this->merge( ['isactive' => is_null($this->isactive) ? '0' : '1'
                        ,'isadmin' => is_null($this->isadmin) ? '0' : '1'
                        ,'is_all_complaint' => is_null($this->is_all_complaint) ? '0' : '1'
                        ,'is_all_eform' => is_null($this->is_all_eform) ? '0' : '1'
        ]);
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'A first name is required',
            'last_name.required' => 'A last name is required',
        ];
    }
}
