<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Repositories\ConfigurationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    private $configurationRepository;
    /**
     * ConfigurationController constructor.
     */
    public function __construct(ConfigurationRepository $configurationRepo)
    {
        $this->configurationRepository = $configurationRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $configurations = $this->configurationRepository;
        $configurations = $configurations->search(isset($request['search'])? $request['search'] : '');

        return view('pages.configuration.index')->with('configurations', $configurations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if($input['exists'] === 'false'){
            $request->validate([
                'name' => 'required|unique:configuration',
            ]);
        }
        DB::beginTransaction();
        try {
            $id = $input['id'];
            unset($input['id']);
            $input['boolean'] = $input['boolean'] === 'true' ;
            if($input['exists'] === 'true'){
                $configuration = $this->configurationRepository->find($id);
                unset($input['name']);
                $configuration->update($input);
            }else{
                $configuration = $this->configurationRepository->create($input);
            }
            DB::commit();
            response()->json(['config' => $configuration], 200);
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json(['error' => $e->getFile() . $e->getLine() . $e->getTraceAsString()]);
        }
    }

    public function delete(Request $request){
        $input = $request->all();
        DB::beginTransaction();
        try {
            $configuration = $this->configurationRepository->find($input['id']);
            $configuration->delete();
            DB::commit();
            return response()->json([], 200);
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json(['error' => $e->getFile() . $e->getLine() . $e->getTraceAsString()]);
        }
    }
}
