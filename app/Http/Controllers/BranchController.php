<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Store;
use App\Repositories\BranchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Branch $branch)
    {
        try {
            DB::beginTransaction();
            $branch->delete();
            DB::commit();
            return response()->json(['delete' => 'success']);
        }catch (\Throwable $e){
            DB::rollBack();
            abort(403, $e->getMessage());
        }
    }
}
