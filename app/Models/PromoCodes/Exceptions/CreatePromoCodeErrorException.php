<?php

namespace App\Models\PromoCodes\Exceptions;

class CreatePromoCodeErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_promoCode_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}
