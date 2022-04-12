<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    private $productRepository;

    /**
     * @param $categoryRepository
     */
    public function __construct(ProductRepository $productRepo ) {
        $this->productRepository = $productRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $products= $this->productRepository;
        $products = $products->search(isset($request['search'])? $request['search'] : '');
        $products = $products->paginate(15);

        return view('pages.products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $this->productRepository->create($input);
            DB::commit();
            return redirect(route('product.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Product $product)
    {
        return view('pages.products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        return view('pages.products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $product->update($input);
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
     * @param  \App\Models\Product  $product
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
