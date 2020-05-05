<?php

namespace App\Models\Submissions\Exceptions;

class CreateSubmissionErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_submission_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}
