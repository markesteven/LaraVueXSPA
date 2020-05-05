<?php

namespace App\Models\PromoCodes\Requests;

use App\Models\Base\BaseFormRequest;

class UpdatePromoCodeRequest extends BaseFormRequest
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
          'date' => ['required','date']
      ];
    }
}
