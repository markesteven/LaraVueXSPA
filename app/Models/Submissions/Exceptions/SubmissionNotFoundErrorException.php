<?php

namespace App\Models\Submissions\Exceptions;

class SubmissionNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'submission_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}
