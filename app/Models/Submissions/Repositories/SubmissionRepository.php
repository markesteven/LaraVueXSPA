<?php

namespace App\Models\Submissions\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\Submissions\Submission;
use App\Models\Submissions\ValidEmail;
use App\Models\PromoCodes\PromoCode;
use App\Models\Submissions\Exceptions\SubmissionNotFoundErrorException;
use App\Models\Submissions\Exceptions\CreateSubmissionErrorException;
use App\Models\Submissions\Exceptions\UpdateSubmissionErrorException;
use App\Models\Submissions\Exceptions\DeleteSubmissionErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Mail\ConfirmationMail;
use App\Mail\ReceiptMail;

class SubmissionRepository extends BaseRepository implements SubmissionRepositoryInterface
{
    /**
     * SubmissionRepository constructor.
     *
     * @param Submission $submission
     */
    public function __construct(Submission $submission)
    {
        parent::__construct($submission);
        $this->model = $submission;
    }

    /**
     * @param array $data
     *
     * @return Submission
     * @throws CreateSubmissionErrorException
     */
    public function createSubmission(array $data)
    {
        try {


          $email_address = $data['email_address'];
          $code = $data['code'];
          $created_at  = date('Y-m-d');
          $is_valid = true;
          $error_response = [];
          $is_count = 0;


          $count = Submission::whereDate('created_at', Carbon::today())->where('email_address',  $data['email_address'])->count();

          if ($count>=7) {
            $error_response = [
              'error' => 'max_entry_by_email',
              'message' => 'You have already reach your daily maximum entry.'
            ];

            $is_valid = false;
          }




          if ($is_valid) {
            $count = Submission::whereDate('created_at', Carbon::today())
                      ->where('email_address',  $data['email_address'])
                      ->where('code',  $data['code'])
                      ->count();

              if ($count > 0) {
                return $error_response = [
                  'error' => 'duplicate_code_entry_by_email_today',
                  'message' => 'You have already enter this code today.'
                ];
              }


           }


          if ($is_valid) {

            $is_confirmed = false;
            $count = ValidEmail::where('email',$data['email_address'])->count();

            if ($count > 0) {
              $is_confirmed = true;
            }



             $response = [];
             // if the code is valid

             $is_code_valid = PromoCode::whereDate('date', Carbon::today())->where('code',  $data['code'])->count();
             if ($is_code_valid > 0) {
                $data['is_valid'] = true;
             }else{
               $data['is_valid'] = false;
             }




             if (!$is_confirmed) {
               $data['is_confirmed'] = false;
               $promo_submission =  $this->create($data);
                \Mail::to($promo_submission->email_address)->send(new ConfirmationMail($promo_submission));
                \Mail::to($promo_submission->email_address)->send(new ReceiptMail($promo_submission));

                $response = [
                   'is_confirmed' => $is_confirmed,
                   'submission' => $promo_submission
                 ];

               return $response;

             }else{
               $data['is_confirmed'] = true;
               $promo_submission =  $this->create($data);
               \Mail::to($promo_submission->email_address)->send(new ReceiptMail($promo_submission));

                $response = [
                     'is_confirmed' => $is_confirmed,
                     'submission' => $promo_submission
                ];

               return $response;
             }


          }else{

            return $error_response;


          }



        } catch (QueryException $e) {

            throw new CreateSubmissionErrorException($e);
        }
    }


    public function confirmSubmission(array $data)
    {
        try {



          $email_address = $data['code'];



          $is_valid = false;
          $response = [];

          $count = ValidEmail::where('email',decrypt($email_address))->count();

           if($count > 0) {

               $response = [
                  'status' => 'already_valid'
                ];

                $is_valid = true;

           }

           $is_exist = false;
           if (!$is_valid) {

               $count =  Submission::orderBy('created_at', 'desc')->where('email_address',decrypt($email_address))->count();

               if ($count > 0) {
                     $is_exist = true;
               }


                if ($is_exist) {

                  \DB::beginTransaction();
                    $validEmail =   ValidEmail::create(['email' => decrypt($data['code'])]);
                    if (!$validEmail)
                    {
                        \DB::rollback();
                    }



                  $submission =  Submission::where('email_address', decrypt($email_address))->update(['is_confirmed' => true ]);


                  if (!$submission)
                  {
                      \DB::rollback();
                  }

                  \DB::commit();




                   $response = [
                      'status' => 'confirmed'
                    ];
                }else{
                  $response = [
                     'status' => 'not_found'
                   ];
                }


           }





           return $response;




        } catch (\Exception $e) {

          return $response = [
             'status' => 'error',
             'error' => $e->getMessage()
           ];
        }
    }


    /**
     * @param int $id
     *
     * @return Submission
     * @throws SubmissionNotFoundErrorException
     */
    public function findSubmissionById(int $id) : Submission
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new SubmissionNotFoundErrorException($e);
        }
    }


    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listSubmissions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function getAllSubmissions(Request $request)
    {
       //
       // $r = $request;
       //
       //  if (isset($r["sort"])){
       //      $sort = explode("|",$r["sort"]);
       //    }
       //
       //    if (isset($r["filter"])) {
       //      $submissions = $this->model->where('first_name', 'like', '%' . $r["filter"] . '%')
       //            ->orWhere('middle_name', 'like', '%' . $r["filter"] . '%')
       //            ->orWhere('last_name', 'like', '%' . $r["filter"] . '%')
       //            ->orWhere('email_address', 'like', '%' . $r["filter"] . '%')
       //            ->orderBy( $sort[0] ,$sort[1])->paginate(5);
       //    }else if(!isset($r["sort"])){
       //         $submissions = $this->model->paginate(5);
       //         return response()->json(compact('submissions'));
       //    }else{
       //      $submissions = $this->model->orderBy( $sort[0] ,$sort[1])->paginate(5);
       //      // $submissions = $submissions->toArray();
       //    }

      return Submission::orderBy('created_at','desc')->get();
    }


}
