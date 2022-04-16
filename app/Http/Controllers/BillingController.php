<?php

namespace App\Http\Controllers;

use App\Models\BillingDetail;
use App\Repositories\BillingRepository;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{


    private $billingRepository;

    /**
     * @param $categoryRepository
     */
    public function __construct(BillingRepository $billingRepo ) {
        $this->billingRepository = $billingRepo;
    }


    public function store(Request $request){
        try {
            DB::beginTransaction();
            $input = $request->all();
            $billing = $this->billingRepository->create([
                'subtotal' => $input['subtotal'],
                'discount' => $input['discount'],
                'total' => $input['total'],
            ]);
            foreach ($input['products'] as $product){
                BillingDetail::query()->create([
                    'name' => $product['name'],
                    'description' =>  $product['description'],
                    'billing' => $billing->id,
                    'image' => $product['image'] == null ? null :  $product['image']['id'],
                    'code' => $product['code'],
                    'price' => $product['price'],
                    'quantity' => $product['selected']
                ]);
            }
            DB::commit();
            return response()->json(['saved' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            return  response($e->getMessage() . ' in line '. $e->getLine() , 500);
        }
    }

    public function index(Request $request){
        $billings= $this->billingRepository;
        $billings = $billings->search(isset($request['search'])? $request['search'] : '');
        $billings = $billings->with('details')->paginate(15);

        return view('pages.billings.index')->with('billings', $billings);
    }
}
