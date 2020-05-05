<?php

namespace App\Models\Submissions\Exceptions;

class UpdateSubmissionErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_submission_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}
