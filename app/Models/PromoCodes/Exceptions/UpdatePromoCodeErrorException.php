<?php

namespace App\Models\PromoCodes\Exceptions;

class UpdatePromoCodeErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_promoCode_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}
