<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Assignment;
use App\Models\Benefit;
use App\Models\Branch;
use App\Models\Card;
use App\Models\Category;
use App\Models\Market;
use App\Models\Sale;
use App\Models\Seller;
use App\Models\Store;
use App\Models\User;
use App\Repositories\CardRepository;
use App\Repositories\MailReceiverRepository;
use App\Repositories\MailRepository;
use App\Repositories\NotificationReceiverRepository;
use App\Repositories\NotificationRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CardController extends Controller
{

    private $cardRepository;
    private MailRepository $mailRepository;
    private MailReceiverRepository $mailReceiverRepository;
    private NotificationRepository $notificationRepository;
    private NotificationReceiverRepository $notificationReceiverRepository;

    /**
     * @param $cardRepository
     */
    public function __construct( CardRepository $cardRepository ,  MailRepository $mailRepo,
        MailReceiverRepository $mailReceiverRepo, NotificationRepository $notificationRepo,
        NotificationReceiverRepository $notificationReceiverRepo) {
        $this->cardRepository = $cardRepository;
        $this->mailRepository = $mailRepo;
        $this->mailReceiverRepository =  $mailReceiverRepo;
        $this->notificationRepository = $notificationRepo;
        $this->notificationReceiverRepository = $notificationReceiverRepo;
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
        if($user == null) abort(403);
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
                                'card.stores.categoryR.image',
                                'card.stores.branches'
                            ])
                            ->get();
        return response()->json(['assignments' => $cards]);
    }

    public function api_add_card(Request $request){
        try {
            DB::beginTransaction();
            $user = User::query()->where('user_token', $request['user_token'])->first();
            if($user == null) abort(403, 'User not found');
            $today = date('Y-m-d h:i:sa');
            $card = Assignment::query()->where('code', $request['code'])->first();
            if($card == null) abort(403, 'Card not found');
            $card->email = $user->email;
            $card->start = CarbonImmutable::parse($today);
            $card->end = CarbonImmutable::parse(strtotime($today . ' + ' . $card->getCard()->days . ' days'));
            $card->type = 'physical';
            $card->price =  $card->getCard()->price;
            $card->sale_date = CarbonImmutable::parse($today);

            $card->save();
            $current_seller = $card->getSeller();
            if($current_seller != null){
                $seller_commissions = [0];
                $seller_totals = [0];
                $array_sellers = [$current_seller ];
                while (!empty($current_seller->superior)){
                    $current_seller = Seller::query()->where('user', $current_seller->superior)->first();
                    array_push($array_sellers, $current_seller);
                    array_push($seller_commissions, 0);
                    array_push($seller_totals, 0);
                }

                $array_sellers = array_reverse($array_sellers);
                $seller_commissions = array_reverse($seller_commissions);
                $seller_totals = array_reverse($seller_totals);

                $root_price = $card->price;
                $count_commission = 0;


                foreach ($array_sellers as $seller){
                    $calculated = ($root_price * $seller->commission / 100);
                    $seller_commissions[$count_commission] = $calculated;
                    $root_price = $calculated;
                    $count_commission ++;
                }


                $count_commission = 0;
                foreach ($seller_commissions as $commission){
                    $less_value = $seller_commissions[$count_commission + 1 ] ?? 0;
                    $calculated = $seller_commissions[$count_commission] - $less_value;
                    $seller_totals[$count_commission] = $calculated;
                    $count_commission ++;
                }
                $count_commission = 0;
                foreach ($array_sellers as $seller){
                    Sale::create([
                        'seller' => $seller->id,
                        'assignment' => $card->id,
                        'payment' =>  $seller_totals[$count_commission]
                    ]);
                    $count_commission ++;
                }
            }else{
                Sale::create([
                    'seller' => null,
                    'assignment' => $card->id,
                    'payment' =>  0
                ]);
            }



            $user->points = $user->points + $card->getCard()->points;
            $user->save();



            $notification = $this->notificationRepository->create([
                'detail' => "Se ha agrgado la tarjeta N° " . $card->number ." a su cuenta",
                'icon'   => 'fas fa-credit-card',
                'emisor'    =>  $user->id
            ]);
            $destiny = [
                ['receiver' => $user->id , 'type' => 'user', 'notification' => $notification->id]
            ];

            //setReceiver($destiny, $this->notificationReceiverRepository, $notification);


            $mail = $this->mailRepository->create([
                'subject' => "New card added",
                'body' => "Se ha agrgado la tarjeta N° " . $card->number ." a su cuenta"
            ]);



            if($user != null){
                $this->mailReceiverRepository->create([
                    'receiver' => $user->id,
                    'mail' => $mail->id
                ]);
            }

            Mail::to($user->email)->send(new \App\Mail\Notification($mail));

            DB::commit();
            return response()->json(['success' => true]);
        }catch (\Throwable $error){
            DB::rollBack();
            abort(403, $error->getMessage());
        }
    }

}
