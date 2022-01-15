<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Seller;
use App\Models\User;
use App\Repositories\SellerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    private $sellerRepository;

    /**
     * @param SellerRepository $sellerRepository
     */
    public function __construct(SellerRepository $sellerRepository ) {
        $this->sellerRepository = $sellerRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $sellers= $this->sellerRepository;
        $sellers = $sellers->search(isset($request['search'])? $request['search'] : '');
        if(!auth()->user()->hasRole('Super Admin')){
            $sellers->where('superior', auth()->user()->id);
        }
        $sellers = $sellers->paginate(15);
        return view('pages.sellers.index')->with('sellers', $sellers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::whereHas("roles", function($q){
                    $q->where("name", "Vendedor");
                })->doesntHave('seller')->where('id', '!=', auth()->user()->id)->pluck('name', 'id');

        if(auth()->user()->hasRole('Super Admin')){
           $sellers = User::whereHas("roles", function($q){
                           $q->where("name", "Vendedor");
                       })->has('seller')->pluck('name', 'id');
        }else{
            $sellers = User::whereHas("roles", function($q){
                $q->where("name", "Vendedor");
            })->whereHas('seller', function ($q){
                $q->where('user', auth()->user()->id );
            })->pluck('name', 'id');
        }
        return view('pages.sellers.create', ['users'=> $users, 'superiors' => $sellers]);
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
        if(!auth()->user()->hasRole('Super Admin')){
            $request['superior'] = auth()->user()->id;
        }

        try {
            DB::beginTransaction();
            $input = $request->all();
            $this->sellerRepository->create($input);
            DB::commit();
            return redirect(route('seller.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return view('pages.sellers.show')->with('seller', $seller);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        return view('pages.sellers.edit', ['seller' => $seller]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        if(!auth()->user()->hasRole('Super Admin')){
            $request['superior'] = auth()->user()->id;
        }

        try {
            DB::beginTransaction();
            $input = $request->all();
            $seller->update($input);
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
     * @param  \App\Models\Seller  $seller
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        try {
            DB::beginTransaction();
            $seller->getUser()->assignRole('Cliente');
            $seller->getUser()->removeRole('Vendedor');
            Seller::query()->where('superior', $seller->getUser()->id)->update([
                'superior'=> null
            ]);
            $seller->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
