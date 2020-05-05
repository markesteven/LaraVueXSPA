<?php

namespace App\Models\PromoCodes\Exceptions;

class PromoCodeNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'promoCode_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}
