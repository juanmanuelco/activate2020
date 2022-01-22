<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Assignment;
use App\Models\Benefit;
use App\Models\Branch;
use App\Models\Card;
use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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
        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(empty($roles)){
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
        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(!empty($roles)){
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

        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(empty($roles)){
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

        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(!empty($roles)){
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
        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(empty($roles)){
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

    public function apply_benefit(){
        if(auth()->user()->hasRole('Local')){
            $stores = Store::query()->where('owner', auth()->user()->id)
                                    ->with('benefits')
                                    ->with('benefits.image')
                                    ->with('image')
                                    ->with('branches')->get();
            $cards = Card::query()->with('image')->get();
            return view('pages.stores.apply_benefit', ['stores' => $stores, 'cards' => $cards]);
        }else{
            return redirect()->back()->with('error', __('Not allowed'));
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function apply_benefit_save(Request $request){
        try {
            if(!auth()->user()->hasRole('Local')){
                throw new \Exception(__('Not allowed'));
            }
            $input = $request->all();
            DB::beginTransaction();
            $benefit = Benefit::find($input['benefit']);
            if($benefit == null) abort(404, __('Benefit not found'));
            $card = Assignment::query()->where('card', $input['card'])->where('number', $input['number'] )->first();
            if($card == null) abort(404, __('Card number not found'));
            if(!$benefit->unlimited){
                $exist_application = Application::query()->where('assignment', $card->id)->where('benefit', $benefit->id)->first();
                if($exist_application != null) abort(403, __('Benefit not allowed'));
            }
            Application::create([
               'assignment' => $card->id,
                'benefit' => $benefit->id
            ]);
            DB::commit();
            return response()->json(['save' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function applied_benefits(){
        try {
            $roles = auth()->user()->getRoleNames()->toArray();
            $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

            if(!empty($roles)){
                $applications = Application::query()->orderBy('created_at', 'desc')->paginate(20);
            }else if(auth()->user()->hasRole('Local')){
                $applications = Application::query()->whereHas('benefit', function($q){
                    $q->whereHas('store', function($k){
                        $k->where('owner', auth()->user()->id);
                    });
                })->orderBy('created_at', 'desc')->paginate(20);
            }else {
                $applications = Application::query()->whereHas('assignment', function ($q){
                    $q->where('email', auth()->user()->email);
                })->orderBy('created_at', 'desc')->paginate(20);
            }
            return view('pages.reports.applied_benefits', ['applications' => $applications]);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function my_applied_benefits(){
        try {
            $applications = Application::query()->whereHas('assignment', function ($q){
                $q->where('email', auth()->user()->email);
            })->orderBy('created_at', 'desc')->paginate(20);
            return view('pages.reports.applied_benefits', ['applications' => $applications]);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
