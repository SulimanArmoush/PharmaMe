<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    public function createMedicines(Request $request)
    {
        $this->validate($request, [
            'scName' => 'required|min:4',
            'trName' => 'required|min:4',
            'category_id' => 'required|integer',
            'manufacturer' => 'required|min:4',
            'quantity' => 'required|integer',
            'expDate' => 'required|date',
            'price' => 'required|integer',
        ]);
        Medicine::create([
            'scName' => $request->scName,
            'trName' => $request->trName,
            'category_id' => $request->category_id,
            'manufacturer' => $request->manufacturer,
            'quantity' => $request->quantity,
            'expDate' => $request->expDate,
            'price' => $request->price,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Product has been added successfuly'], 200);
    }

    public function getMedicines()
    {
        $medicine = Medicine::With('category:id,catName', 'user:id,name')->get();

        return response()->json($medicine, 200);
    }

    public function getMedicineId($MedicinetId)
    {
        $MedicineInfo = Medicine::with('category:id,catName', 'user:id,name')->find($MedicinetId);
        if (! $MedicineInfo) {
            return response()->json(['Medicine Not Found'], 404);
        }

        return response()->json($MedicineInfo, 200);
    }

    public function getMedicinesOwner($userId)
    {
        $user = User::find($userId);
        if (! $user) {
            return response()->json(['Invalid'], 404);
        }
        $medicines = Medicine::
             With('category:id,catName,image')
            ->where('user_id', $userId)
            ->get();

        return response()->json($medicines, 200);
    }

    public function getMyMedicines()
    {
        $medicines = Medicine::With('category:id,catName,image')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($medicines, 200);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required',
        ]);
        $keyword = $request->keyword;
        $medicine =  Medicine::With('category:id,catName,image')
            ->Where ('user_id' , Auth::id())
            ->where('medicines.trName', 'LIKE', '%'.$keyword.'%')
            ->get();

   if(count($medicine) <1)
    {
        return response()->json(['Medicine Not Found'], 404);
    }

        return response()->json($medicine, 200);
    }

    public function phSearch(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required',
        ]);
        $keyword = $request->keyword;
        $medicine =  Medicine::With('category:id,catName,image')
            ->With('user:id,name')
            ->where('medicines.trName', 'LIKE', '%'.$keyword.'%')
            ->get();

   if(count($medicine) <1)
    {
        return response()->json(['Medicine Not Found'], 404);
    }

        return response()->json($medicine, 200);
    }
}
