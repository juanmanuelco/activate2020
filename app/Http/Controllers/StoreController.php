<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Branch;
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
    public function index(Request $request)
    {
        $stores= $this->storeRepository;
        $stores = $stores->search(isset($request['search'])? $request['search'] : '');
        if(!auth()->user()->hasRole('Super Admin')){
            $stores->where('owner', auth()->user()->id);
        }
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
            $request['owner'] = auth()->user()->id;
        }

        $branches = json_decode($request['branches']);

        try {
            DB::beginTransaction();
            $input = $request->all();
            $store = $this->storeRepository->create($input);
            $this->createBranches( $branches, $store );
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
            $request['owner'] = auth()->user()->id;
        }

        $branches = json_decode($request['branches']);

        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        try {
            DB::beginTransaction();
            $input = $request->all();
            $store->update($input);
            $this->createBranches( $branches, $store );
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
            Benefit::query()->where('store', '=', $store->id)->delete();
            Branch::query()->where('store', '=', $store->id)->delete();
            $store->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    /**
     * @param $branches
     * @param \Illuminate\Database\Eloquent\Model $store
     */
    public function createBranches( $branches, \Illuminate\Database\Eloquent\Model $store ): void {
        foreach ( $branches as $branch ) {
            if ( $branch->exists ) {
                $toBranch            = Branch::find( $branch->id );
                $toBranch->name      = $branch->name;
                $toBranch->store     = $store->id;
                $toBranch->latitude  = $branch->latitude;
                $toBranch->longitude = $branch->longitude;
                $toBranch->save();
            } else {
                Branch::create( [
                    'name'      => $branch->name,
                    'store'     => $store->id,
                    'latitude'  => $branch->latitude,
                    'longitude' => $branch->longitude
                ] );
            }
        }
    }
}
