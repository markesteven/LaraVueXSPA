<?php

namespace App\Http\Controllers\Api;


use App\Models\Traits\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Categories\Repositories\CategoryRepository;
use App\Models\Categories\Repositories\CategoryRepositoryInterface;
use App\Models\Categories\Requests\CreateCategoryRequest;
use App\Models\Categories\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Categories\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{

    use Authorizable;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }


    public function index(Request $request)
    {
      $categories = $this->categoryRepo->getAllCategories($request);

      return response()->json($categories);
    }

    /**
     * @param CreateCategoryRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {


         $categoryRepo = new CategoryRepository(new Category);
         $category = $categoryRepo->createCategory($request->all());

         return response()->json([
             'success' => 'category_created',
             'message' => 'Category Successfully Created',
             'data' => $category
         ],201);


    }

    public function show($id)
    {

      $categoryRepo = new CategoryRepository(new Category);
      $category = $this->categoryRepo->findCategoryById($id);
      return response()->json($category);

    }

    public function update(UpdateCategoryRequest $request, $id)
    {
          $category = $this->categoryRepo->findCategoryById($id);

          $update = new CategoryRepository($category);
          $data = $update->updateCategory($request->all());

           return response()->json([
               'success' => 'category_updated',
               'message' => 'Category Successfully Updated',
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
        $category = $this->categoryRepo->findCategoryById($id);

        $delete = new CategoryRepository($category);
        $data = $delete->deleteCategory();

        return response()->json([
            'success' => 'category_deleted',
            'message' => 'Category Successfully Deleted',
            'data' => $data
        ],200);


    }
}
