<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Card;
use App\Models\Seller;
use App\Repositories\CardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AssignmentController extends Controller
{
    private $cardRepository;

    public function __construct( CardRepository $cardRepository ) {
        $this->cardRepository = $cardRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

        if(!empty($roles)){
            $sellers = Seller::query()->pluck('name', 'id');
            $sellers_ids =Seller::query()->pluck('id')->toArray();
            $cards = $this->cardRepository
                ->search(isset($request['search'])? $request['search'] : '')
                ->whereHas('assignments', function ($q){
                    $q->where('email', '=', null);
                })->paginate(1);

        }else{
            $sellers = Seller::query()
                             ->where('user',auth()->user()->id)
                             ->orWhere('superior',auth()->user()->id)
                             ->pluck('name', 'id');


            $sellers_ids = Seller::query()
                                 ->where('user',auth()->user()->id)
                                 ->orWhere('superior',auth()->user()->id)
                                 ->pluck( 'id')->toArray();


            $cards = $this->cardRepository
                ->search(isset($request['search'])? $request['search'] : '')
                ->whereHas('assignments', function ($q) use($sellers_ids){
                    $q->where('email', '=', null);
                    $q->whereIn('seller', $sellers_ids);
                })->paginate(1);

        }


        return view('pages.assignments.index')->with('cards', $cards)->with('sellers', $sellers )->with('seller_ids', $sellers_ids);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $cards = Card::query()->pluck('name', 'id');
        $sellers = Seller::query()->pluck('name', 'id');
        return view('pages.assignments.create', ['cards'=> $cards, 'sellers' => $sellers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            if($input['start'] >= $input['end']){
                throw  new \Exception(__("End value should be grater than start"));
            }
           $current_card =  Card::query()->where('id', $input['card'])->first();

            if($input['start'] < $current_card->start || $input['end'] > $current_card->end ){
                throw  new \Exception(__("Numbers out of range"));
            }

            for($i = $input['start']; $i<=$input['end']; $i++){
                $exists = Assignment::query()->where(['number'=> $i, 'card' => $input['card']])->first();
                if($exists == null){
                    Assignment::create([
                        'seller' => $input['seller'],
                        'card' => $input['card'],
                        'number' => $i,
                        'code' => $i . '-' . uniqid()
                    ]);
                }
            }
            DB::commit();
            return redirect(route('assignments.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Assignment $assignment)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $assignment->update(['seller' => $input['seller']]);
            DB::commit();
            return response()->json(['update' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
