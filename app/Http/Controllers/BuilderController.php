<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Repositories\BuilderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuilderController extends Controller
{
    /**
     * @var BuilderRepository
     */
    private $builderRepository;

    /**
     * BuilderController constructor.
     * @param BuilderRepository $builderRepo
     */
    public function __construct(BuilderRepository $builderRepo)
    {
        $this->builderRepository = $builderRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $builders = $this->builderRepository;
        if(isset($request['search'])) $builders = $builders->search($request['search']);
        $builders = $builders->paginate(15);
        return view('pages.builder.index')->with('builders', $builders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $code = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(65/strlen($x)) )),1,65);
        return view('pages.builder.create')->with('code' , $code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $current = Builder::where('session', $request['code'])->first();
        if(empty($current)){
            $current = $this->builderRepository->create([
                'name' => isset($request['name']) ?   $request['name'] : null,
                'session' => isset($request['code']) ?  $request['code']  : null,
                'slug' => isset($request['slug']) ?   $request['slug'] : null,
                'gjs-html' => isset($request['gjs-html']) ?  $request['gjs-html']  : null,
                'gjs-components' => isset($request['gjs-components']) ?  $request['gjs-components']  : null,
                'gjs-assets' => isset($request['gjs-assets']) ?  $request['gjs-assets']  : null,
                'gjs-css' => isset($request['gjs-css']) ?  $request['gjs-css']  : null,
                'gjs-styles' => isset($request['gjs-styles']) ? $request['gjs-styles']   : null,
            ]);
        }else{
            $current->update([
                'gjs-html' => isset($request['gjs-html']) ?  $request['gjs-html']  : null,
                'gjs-components' => isset($request['gjs-components']) ? $request['gjs-components']   : null,
                'gjs-assets' => isset($request['gjs-assets']) ? $request['gjs-assets']   : null,
                'gjs-css' => isset($request['gjs-css']) ?  $request['gjs-css']  : null,
                'gjs-styles' => isset($request['gjs-styles']) ?  $request['gjs-styles']  : null,
            ]);
        }
        return response()->json($current);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Builder  $builder
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Builder $builder)
    {
        if(empty($builder)) abort(404);
        else{
            return response()->json($builder);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Builder  $builder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Builder $builder)
    {
        if(empty($builder)) abort(404);
        else{
            return view('pages.builder.create')->with('code' , $builder->session)->with('builder', $builder);
        }
    }

    public function page($page){
        $current = Builder::where('slug', $page)->first();
        if(empty($current)) abort(404);
        else{
            return view('pages.builder.show')->with('builder', $current);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Builder  $builder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Builder $builder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Builder  $builder
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Builder $builder)
    {
        try {
            DB::beginTransaction();
            $builder->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
