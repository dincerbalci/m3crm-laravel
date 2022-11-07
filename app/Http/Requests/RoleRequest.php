<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'primary_name' => ['required'],
            'secondary_name' => ['required'],
            'email' => ['required'],
            'expiry_date' => ['required'],
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
        $tableJson=json_decode($this->table_json);
        $expiryDate=str_replace(","," ",$this->expiry_date);
        $expiryDate=date("Y-m-d",strtotime($expiryDate));
        $this->merge( ['isactive' => is_null($this->isactive) ? '0' : '1',
                        'expiry_date'=> $expiryDate, 'table_json'=>$tableJson
        ]);
    }
}
