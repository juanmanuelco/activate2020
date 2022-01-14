<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{

    private $storeRepository;

    /**
     * @param $storeRepository
     */
    public function __construct( StoreRepository $storeRepo ) {
        $this->storeRepository = $storeRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $stores= $this->storeRepository;
        $stores = $stores->search(isset($request['search'])? $request['search'] : '');
        $stores = $stores->paginate(15);
        return view('pages.stores.index')->with('stores', $stores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->hasRole('Super Admin')){
            $owners = User::query()->orderBy('id')->pluck('name', 'id');
        }else{
            $owners = User::query()->where('id',auth()->user()->id)->pluck('name', 'id');
        }
        $categories = Category::query()->orderBy('id')->pluck('name', 'id');
        return view('pages.stores.create', ['owners'=> $owners, 'categories' => $categories]);
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

        if(!auth()->user()->hasRole('Super Admin')){
            $input['owner'] = auth()->user()->id;
        }

        try {
            DB::beginTransaction();
            $input = $request->all();
            $this->storeRepository->create($input);
            DB::commit();
            return redirect(route('store.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        return view('pages.stores.show')->with('store', $store);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        $categories = Category::query()->orderBy('id')->pluck('name', 'id');
        if(auth()->user()->hasRole('Super Admin')){
            $owners = User::query()->orderBy('id')->pluck('name', 'id');
        }else{
            $owners = User::query()->where('id',auth()->user()->id)->pluck('name', 'id');
        }
        return view('pages.stores.edit')->with('categories', $categories)->with('store',$store)->with('owners', $owners);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Store $store)
    {
        if(!auth()->user()->hasRole('Super Admin')){
            $input['owner'] = auth()->user()->id;
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $store->update($input);
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
     * @param  \App\Models\Store  $store
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Store $store)
    {
        try {
            DB::beginTransaction();
            $store->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
