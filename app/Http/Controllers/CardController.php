<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Benefit;
use App\Models\Branch;
use App\Models\Card;
use App\Models\Category;
use App\Models\Market;
use App\Models\Store;
use App\Models\User;
use App\Repositories\CardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{

    private $cardRepository;

    /**
     * @param $cardRepository
     */
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
        $cards= $this->cardRepository;
        $cards = $cards->search(isset($request['search'])? $request['search'] : '');
        $cards = $cards->paginate(15);
        return view('pages.cards.index')->with('cards', $cards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::query()->pluck('name', 'id');
        return view('pages.cards.create', ['stores' => $stores]);
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
        $request['hidden'] = $request['hidden'] == 'on';
        try {
            DB::beginTransaction();
            $input = $request->all();
            if($input['start'] >= $input['end']){
                throw  new \Exception(__("End value should be grater than start"));
            }
            $card = $this->cardRepository->create($input);
            if(isset($request['stores'])){
                $card->stores()->sync($input['stores']);
            }

            DB::commit();
            return redirect(route('card.create'))->with('status', __('saved_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        $stores = Store::query()->pluck('name', 'id');
        return view('pages.cards.show')->with('card', $card)->with('stores', $stores);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        $stores = Store::query()->pluck('name', 'id');
        return view('pages.cards.edit')->with('card', $card)->with('stores', $stores);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $request['hidden'] = $request['hidden'] == 'on';
        try {
            DB::beginTransaction();
            $input = $request->all();

            $card->update($input);

            if(isset($request['stores'])){
                $card->stores()->sync($input['stores']);
            }
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
     * @param  \App\Models\Card  $card
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        try {
            DB::beginTransaction();
            DB::table('store_cards')->where('card', $card->id)->delete();
            Market::query()->where('card', $card->id)->delete();
            $card->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    public function my_cards(){
        $cards = Card::query()->whereHas('assignments', function ($q){
            $q->where('email', auth()->user()->email);
        })->paginate(10);
        return view('pages.profile.my_cards')->with('cards', $cards);
    }

    public function my_cards_stores(Assignment $assignment){
        if($assignment->email != auth()->user()->email){
            abort(403, __('Not allowed'));
        }
        $stores = $assignment->getCard()->stores()->paginate(10);
        return view('pages.profile.my_cards_stores')->with('stores', $stores);
    }
    public function api_index(){
        $cards = Card::query()->where('hidden', false)
                              ->with(['image', 'markets', 'markets.image'])->get();
        return response()->json(['cards' => $cards]);
    }

    public function api_my_cards(Request $request){
        $user = User::query()->where('user_token', $request['user_token'])->first();
        $cards  = Assignment::query()
                            ->where('email', $user->email)
                            ->with([
                                'card',
                                'card.image',
                                'card.stores',
                                'card.stores.image',
                                'card.stores.benefits',
                                'card.stores.benefits.image',
                                'card.stores.categoryR',
                                'card.stores.categoryR.image'
                            ])
                            ->get();
        return response()->json(['assignments' => $cards]);
    }
}
