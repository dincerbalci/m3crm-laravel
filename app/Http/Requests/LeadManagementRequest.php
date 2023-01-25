<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadManagementRequest extends FormRequest
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
            'salutation' => ['required','not_in:0'],
            'lead_name' => ['required'],
            'cnic' => ['required'],
            'email' => ['required'],
            'gender' => ['required','not_in:0'],
            'lead_source' => ['required','not_in:0'],
            'lead_value' => ['required'],
            'allow_follow_up' => ['required','not_in:0'],
            'status' => ['required','not_in:0'],
            'lead_category' => ['required','not_in:0'],
            'description' => ['required'],
        ];
    }
}
