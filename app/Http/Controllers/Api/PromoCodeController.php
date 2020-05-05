<?php

namespace App\Http\Controllers\Api;


use App\Models\Traits\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\PromoCodes\Repositories\PromoCodeRepository;
use App\Models\PromoCodes\Repositories\PromoCodeRepositoryInterface;
use App\Models\PromoCodes\Requests\CreatePromoCodeRequest;
use App\Models\PromoCodes\Requests\UpdatePromoCodeRequest;
use Illuminate\Http\Request;
use App\Models\PromoCodes\PromoCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PromoCodeController extends Controller
{

    // use Authorizable;

    /**
     * @var PromoCodeRepositoryInterface
     */
    private $promoCodeRepo;

    /**
     * PromoCodeController constructor.
     *
     * @param PromoCodeRepositoryInterface $promoCodeRepository
     */
    public function __construct(PromoCodeRepositoryInterface $promoCodeRepository)
    {
        $this->promoCodeRepo = $promoCodeRepository;
    }


    public function index(Request $request)
    {
      $promoCodes = $this->promoCodeRepo->getAllPromoCodes($request);

      return response()->json($promoCodes);
    }

    /**
     * @param CreatePromoCodeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePromoCodeRequest $request)
    {


         $promoCodeRepo = new PromoCodeRepository(new PromoCode);
         $promoCode = $promoCodeRepo->createPromoCode($request->all());

         return response()->json([
             'success' => 'promoCode_created',
             'message' => 'PromoCode Successfully Created',
             'data' => $promoCode
         ],201);


    }

    public function show($id)
    {

      $promoCodeRepo = new PromoCodeRepository(new PromoCode);
      $promoCode = $this->promoCodeRepo->findPromoCodeById($id);
      return response()->json($promoCode);

    }

    public function update(UpdatePromoCodeRequest $request, $id)
    {
          $promoCode = $this->promoCodeRepo->findPromoCodeById($id);

          $update = new PromoCodeRepository($promoCode);
          $data = $update->updatePromoCode($request->all());

           return response()->json([
               'success' => 'promoCode_updated',
               'message' => 'Promo Code Successfully Updated',
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
        $promoCode = $this->promoCodeRepo->findPromoCodeById($id);

        $delete = new PromoCodeRepository($promoCode);
        $data = $delete->deletePromoCode();

        return response()->json([
            'success' => 'promoCode_deleted',
            'message' => 'PromoCode Successfully Deleted',
            'data' => $data
        ],200);


    }
}
