<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inisiatif;

class InisiatifApiController extends Controller
{
    public function toggle($id)
    {
        $inisiatif = Inisiatif::findOrFail($id);
        $inisiatif->status = !$inisiatif->status;
        $inisiatif->save();

        return response()->json([
            'success' => true,
            'id'      => $inisiatif->id,
            'status'  => $inisiatif->status
        ]);
    }
     public function update(Request $request, $id)
    {
        $inisiatif = Inisiatif::findOrFail($id);
        $inisiatif->update($request->only(['judul', 'dokumen']));
        return response()->json(['success' => true, 'data' => $inisiatif]);
    }

    public function destroy($id)
    {
        $inisiatif = Inisiatif::findOrFail($id);
        $inisiatif->delete();
        return response()->json(['success' => true, 'id' => $id]);
    }
}
