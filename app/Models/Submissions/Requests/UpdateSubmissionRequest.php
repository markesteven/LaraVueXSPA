<?php

namespace App\Models\Submissions\Requests;

use App\Models\Base\BaseFormRequest;

class UpdateSubmissionRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
          // 'name' => ['required', 'unique:categories,name,' . $this->id]
      ];
    }
}
