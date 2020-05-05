<?php

namespace App\Models\PromoCodes\Exceptions;

class DeletePromoCodeErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_promoCode_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}
