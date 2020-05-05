<?php

namespace App\Models\PromoCodes\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\PromoCodes\PromoCode;
use App\Models\PromoCodes\Exceptions\PromoCodeNotFoundErrorException;
use App\Models\PromoCodes\Exceptions\CreatePromoCodeErrorException;
use App\Models\PromoCodes\Exceptions\UpdatePromoCodeErrorException;
use App\Models\PromoCodes\Exceptions\DeletePromoCodeErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class PromoCodeRepository extends BaseRepository implements PromoCodeRepositoryInterface
{
    /**
     * PromoCodeRepository constructor.
     *
     * @param PromoCode $promoCode
     */
    public function __construct(PromoCode $promoCode)
    {
        parent::__construct($promoCode);
        $this->model = $promoCode;
    }

    /**
     * @param array $data
     *
     * @return PromoCode
     * @throws CreatePromoCodeErrorException
     */
    public function createPromoCode(array $data) : PromoCode
    {
        try {

          return $this->create($data);


        } catch (QueryException $e) {
            throw new CreatePromoCodeErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return PromoCode
     * @throws PromoCodeNotFoundErrorException
     */
    public function findPromoCodeById(int $id) : PromoCode
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PromoCodeNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdatePromoCodeErrorException
     */
    public function updatePromoCode(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdatePromoCodeErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deletePromoCode() : bool
    {

        try{
          return $this->delete();
        } catch (QueryException $e) {
            throw new DeletePromoCodeErrorException($e);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listPromoCodes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function getAllPromoCodes(Request $request)
    {

       $r = $request;

       if (isset($r["sort"])){
            $sort = explode("|",$r["sort"]);
          }

          if (isset($r["filter"])) {
            $promoCodes = $this->model->where('code', 'like', '%' . $r["filter"] . '%')->orderBy( $sort[0] ,$sort[1])->paginate(5);
          }else if(!isset($r["sort"])){
               $promoCodes = $this->model->paginate(5);
               return response()->json(compact('promoCodes'));
          }else{
            $promoCodes = $this->model->orderBy( $sort[0] ,$sort[1])->paginate(5);
          }

      return $promoCodes;
    }


}
