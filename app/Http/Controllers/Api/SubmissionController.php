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

class SubmissionController extends Controller
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

    /**
     * @param CreateSubmissionRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(CreateSubmissionRequest $request)
    {


         $submissionRepo = new SubmissionRepository(new Submission);
         $submission = $submissionRepo->createSubmission($request->all());


         if (isset($submission['error'])) {
           return response()->json([
               'error' => $submission['error'],
               'message' => $submission['message']
           ]);
         }else{
           return response()->json([
               'success' => 'submission_created',
               'message' => 'Submission Successfully Created',
               'data' => $submission
           ],201);
         }


    }

    public function confirmation(Request $request)
    {

         $submissionRepo = new SubmissionRepository(new Submission);
         $submission = $submissionRepo->confirmSubmission($request->all());



         return response()->json([
             'status' => 'confirmation',
             'data' => $submission
         ],201);



    }

    public function show($id)
    {

      $submissionRepo = new SubmissionRepository(new Submission);
      $submission = $this->submissionRepo->findSubmissionById($id);
      return response()->json($submission);

    }

    public function update(UpdateSubmissionRequest $request, $id)
    {
          $submission = $this->submissionRepo->findSubmissionById($id);

          $update = new SubmissionRepository($submission);
          $data = $update->updateSubmission($request->all());

           return response()->json([
               'success' => 'submission_updated',
               'message' => 'Submission Successfully Updated',
               'data' => $data
           ],200);

    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $submission = $this->submissionRepo->findSubmissionById($id);

        $delete = new SubmissionRepository($submission);
        $data = $delete->deleteSubmission();

        return response()->json([
            'success' => 'submission_deleted',
            'message' => 'Submission Successfully Deleted',
            'data' => $data
        ],200);


    }
}
