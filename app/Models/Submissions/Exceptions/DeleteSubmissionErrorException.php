<?php

namespace App\Models\Submissions\Exceptions;

class DeleteSubmissionErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_submission_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}
