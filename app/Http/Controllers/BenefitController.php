<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Store;
use App\Models\User;
use App\Repositories\BenefitRepository;
use App\Repositories\StoreRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class BenefitController extends Controller
{

    private $benefitRepository;

    public function __construct( BenefitRepository $benefitRepo ) {
        $this->benefitRepository = $benefitRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $benefits= $this->benefitRepository;
        $benefits = $benefits->search(isset($request['search'])? $request['search'] : '');

        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(empty($roles)){
            $benefits->whereHas('store', function (Builder $query){
                $query->where('owner', auth()->user()->id);
            });

        }
        $benefits->orderBy('store' );
        $benefits = $benefits->paginate(15);
        return view('pages.benefits.index')->with('benefits', $benefits);
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
            $stores = Store::query()->orderBy('name')->pluck('name', 'id');
        }else{
            $stores = Store::query()->where('owner', '=', auth()->user()->id )->orderBy('name')->pluck('name', 'id');
        }
        return view('pages.benefits.create', ['stores'=> $stores]);
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
        $request['unlimited'] = $request['unlimited'] == 'on';

        if($request['benefit'] == '<p><br></p>'){
            $request['benefit'] = "";
        }

        if($request['restriction'] == '<p><br></p>'){
            $request['restriction'] = "";
        }

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);


        try {
            DB::beginTransaction();
            $input = $request->all();

            $roles = auth()->user()->getRoleNames()->toArray();
            $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

            if(empty($roles)){
                $store = Store::find($request['store'])->where('owner', auth()->user()->id)->first();
                if($store == null)  throw new \Exception("Store forbidden for current user");
            }

            $this->benefitRepository->create($input);
            DB::commit();
            return redirect(route('benefit.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Benefit  $benefit
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Benefit $benefit)
    {
        return view('pages.benefits.show')->with('benefit', $benefit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Benefit  $benefit
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Benefit $benefit)
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(!empty($roles)){
            $stores = Store::query()->orderBy('name')->pluck('name', 'id');
        }else{
            $stores = Store::query()->where('owner', '=', auth()->user()->id )->orderBy('name')->pluck('name', 'id');
        }
        return view('pages.benefits.edit')->with('stores',$stores)->with('benefit', $benefit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Benefit  $benefit
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Benefit $benefit)
    {
        $request['unlimited'] = $request['unlimited'] == 'on';

        if($request['benefit'] == '<p><br></p>'){
            $request['benefit'] = "";
        }

        if($request['restriction'] == '<p><br></p>'){
            $request['restriction'] = "";
        }

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        try {
            DB::beginTransaction();
            $input = $request->all();

            $roles = auth()->user()->getRoleNames()->toArray();
            $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

            if(empty($roles)){
                $store = Store::find($request['store'])->where('owner', auth()->user()->id)->first();
                if($store == null)  throw new \Exception("Store forbidden for current user");
            }
           $benefit->update($input);
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
     * @param  \App\Models\Benefit  $benefit
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Benefit $benefit)
    {
        try {
            DB::beginTransaction();
            $benefit->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
