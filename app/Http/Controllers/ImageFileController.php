<?php

namespace App\Http\Controllers;

use App\Models\ImageFile;
use App\Repositories\ImageFileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageFileController extends Controller
{

    /**
     * @var ImageFileRepository
     */
    private $imageRepository;

    /**
     * ImageFileController constructor.
     * @param ImageFileRepository $imageFileRepo
     */
    public function __construct(ImageFileRepository $imageFileRepo)
    {
        $this->imageRepository = $imageFileRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($roles)){
            $images = ImageFile::select('id', 'extension', 'name', 'permalink')->orderBy('id', 'desc')->paginate(20);
        }else{
            $images = ImageFile::where('owner', Auth::id())
                                           ->select('id', 'extension', 'name', 'permalink')
                                           ->orderBy('id', 'desc')->paginate(20);
        }
        return $images;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|image|mimes:jpeg,png,jpg',
        ]);
        try {
            DB::beginTransaction();
            $image = $request->file('files');
            $current_image = $this->imageRepository->create([
                'name'=> $image->getClientOriginalName(),
                'extension' => $image->getClientOriginalExtension(),
                'size' =>   $image->getSize(),
                'mimetype' =>   $image->getClientMimeType(),
                'owner' =>  Auth::id(),
            ]);
            $current_image->uuid = $current_image->id . '-' . uniqid() . '-' . uniqid();
            $current_image->permalink = "/images/system/" .$current_image->uuid . '.' . $current_image->extension;
            $current_image->save();
            $url = 'images/system/';
            $image->move($url,$current_image->uuid . '.' . $image->getClientOriginalExtension());
            DB::commit();
            return response()->json($current_image);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageFile  $imageFile
     * @return \Illuminate\Http\Response
     */
    public function show(ImageFile $imageFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImageFile  $imageFile
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageFile $imageFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImageFile  $imageFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageFile $imageFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageFile  $imageFile
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ImageFile $imageFile)
    {

    }
}
