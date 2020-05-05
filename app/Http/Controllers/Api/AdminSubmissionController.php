<?php

namespace App\Http\Controllers\Api;


use App\Models\Traits\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Submissions\Repositories\SubmissionRepository;
use App\Models\Submissions\Repositories\SubmissionRepositoryInterface;
use App\Models\Submissions\Requests\CreateSubmissionRequest;
use App\Models\Submissions\Requests\UpdateSubmissionRequest;
use Illuminate\Http\Request;
use App\Models\Submissions\Submission;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminSubmissionController extends Controller
{

    // use Authorizable;

    /**
     * @var SubmissionRepositoryInterface
     */
    private $submissionRepo;

    /**
     * SubmissionController constructor.
     *
     * @param SubmissionRepositoryInterface $submissionRepository
     */
    public function __construct(SubmissionRepositoryInterface $submissionRepository)
    {
        $this->submissionRepo = $submissionRepository;
    }


    public function index(Request $request)
    {
      $submissions = $this->submissionRepo->getAllSubmissions($request);

      return response()->json($submissions);
    }


}
