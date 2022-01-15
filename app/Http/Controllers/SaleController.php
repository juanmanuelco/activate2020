<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Sale;
use App\Models\Seller;
use App\Repositories\CardRepository;
use App\Repositories\MailReceiverRepository;
use App\Repositories\MailRepository;
use App\Repositories\NotificationReceiverRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use http\Client\Curl\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SaleController extends Controller
{

    private CardRepository $cardRepository;
    private NotificationRepository $notificationRepository;
    private NotificationReceiverRepository $notificationReceiverRepository;

    private MailRepository $mailRepository;
    private MailReceiverRepository $mailReceiverRepository;

    private UserRepository $userRepository;

    public function __construct(
        CardRepository $cardRepository,
        NotificationRepository $notificationRepo,
        NotificationReceiverRepository $notificationReceiverRepo,
        MailRepository $mailRepo,
        MailReceiverRepository $mailReceiverRepo,
        UserRepository $userRepo,
    ) {
        $this->cardRepository = $cardRepository;
        $this->notificationRepository = $notificationRepo;
        $this->notificationReceiverRepository = $notificationReceiverRepo;
        $this->mailRepository = $mailRepo;
        $this->mailReceiverRepository =  $mailReceiverRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('Vendedor')){
            $seller = Seller::query()->where('user', auth()->user()->id )->first();
            if($seller != null){
                $cards = $this->cardRepository
                    ->search(isset($request['search'])? $request['search'] : '')
                    ->whereHas('assignments', function ($q) use($seller){
                        $q->whereNull('email');
                        $q->where('seller', $seller->id);
                    })->paginate(1);

                return view('pages.sales.index')->with('cards', $cards);
            }
        }
        return redirect()->back()->with('error', __('Not allowed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $today = date('Y-m-d h:i:sa');
            $card = Assignment::find($input['card']);
            $card->email = $input['email'];
            $card->start = CarbonImmutable::parse($today);
            $card->end = CarbonImmutable::parse(strtotime($today . ' + ' . $card->getCard()->days . ' days'));
            $card->type = 'web';
            $card->price =  $card->getCard()->price;
            $card->sale_date = CarbonImmutable::parse($today);
            $card->save();


            $current_seller = $card->getSeller();
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

            auth()->user()->points = auth()->user()->points + $card->getCard()->points;
            auth()->user()->save();



            $user = \App\Models\User::query()->where('email', $input['email'])->first();
            $notification = $this->notificationRepository->create([
                'detail' => "Se ha agrgado la tarjeta N° " . $card->number ." a su cuenta",
                'icon'   => 'fas fa-credit-card',
                'emisor'    =>  Auth::user()->id
            ]);
            if($user != null){
                $destiny = [
                    ['receiver' => $user->id , 'type' => 'card', 'notification' => $notification->id]
                ];
                setReceiver($destiny, $this->notificationReceiverRepository, $notification);
            }

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


            Mail::to($input['email'])->send(new \App\Mail\Notification($mail));


            DB::commit();
            return redirect()->route('sale.index')->with('status', __('updated_success'));
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage() . ' in line '. $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function sale(int $id){
        $card = Assignment::find($id);
        if($card == null){
            return redirect()->route('sale.index');
        }
        $seller = Seller::query()->where('user', auth()->user()->id)->first();
        if($seller == null){
            return redirect()->route('sale.index');
        }
        if($card->seller != $seller->id){
            return redirect()->route('sale.index');
        }
        return view('pages.sales.sale', ['card'=> $card, 'seller', $seller]);

    }
}
