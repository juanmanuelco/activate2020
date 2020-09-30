<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Repositories\BuilderRepository;
use Illuminate\Http\Request;

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
        return view('pages.builder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Builder  $builder
     * @return \Illuminate\Http\Response
     */
    public function show(Builder $builder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Builder  $builder
     * @return \Illuminate\Http\Response
     */
    public function edit(Builder $builder)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Builder $builder)
    {
        //
    }
}
