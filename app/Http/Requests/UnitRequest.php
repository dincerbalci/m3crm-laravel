<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'group_id' => ['required'],
            'region_id' => ['required'],
            'unit_name' => ['required'],
            'branch_code' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'email'],
        ];
    }
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if($this->escalation_time1 != 0)
        {
            $this->merge( ['level1' => implode(',',$this->level1)]);
        }
        if($this->escalation_time2 != 0)
        {
            $this->merge( ['level2' => implode(',',$this->level2)]);
        }
        if($this->escalation_time3 != 0)
        {
            $this->merge( ['level3' => implode(',',$this->level3)]);
        }
        if($this->escalation_time4 != 0)
        {
            $this->merge( ['level4' => implode(',',$this->level4)]);
        }
        
    }
    
    
}
