<?php

namespace App\Models\Submissions\Requests;

use App\Models\Base\BaseFormRequest;

class CreateSubmissionRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'street_name' => ['required'],
            'barangay' => ['required'],
            'city' => ['required'],
            'mobile_number' => ['required'],
            'email_address' => ['required','email']
        ];
    }
}
