<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Store;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private $categoryRepository;

    /**
     * @param $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepo ) {
        $this->categoryRepository = $categoryRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories= $this->categoryRepository;
        $categories = $categories->search(isset($request['search'])? $request['search'] : '');
        $categories = $categories->paginate(15);

        return view('pages.categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::query()->orderBy('id')->pluck('name', 'id');
        return view('pages.categories.create', ['categories'=> $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $this->categoryRepository->create($input);
            DB::commit();
            return redirect(route('category.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('pages.categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = $this->categoryRepository->all()->where('id', '!=', $category->id)->sortBy('id')->pluck('name', 'id');
        return view('pages.categories.edit')->with('category', $category)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $category->update($input);
            DB::commit();
            return redirect()->back()->with('status', __('updated_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();
            Category::query()->where('parent', '=', $category->id)->delete();
            $category->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function api_index(Request $request){
        $categories = Category::query();
        if(!isset($request['parent'])){
            $categories =$categories->whereNull('parent')
                                    ->with('stores')
                                    ->with('stores.image')
                                    ->with('stores.benefits')->with('stores.benefits.image');
        }else{
            $categories->where('parent', $request['parent'])
                        ->whereHas('stores')
                        ->with('stores')->with('stores.image')
                        ->with('stores.benefits')->with('stores.benefits.image');
        }
        $categories = $categories->with('image')->limit(9)->get();

        return response()->json(['categories' => $categories]);
    }
}
