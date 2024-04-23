<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CatController extends Controller
{
    public function getCategories()
    {
        $category = Category::get();

        return response()->json($category , 200);
    }


    public function getCatMedicines($catId)
    {
        $catInfo = Category::find($catId);
        if (! $catInfo) {
            return response()->json(['Category Not Found'], 404);
        }

        $medicines = DB::table('medicines')
        ->where('category_id', $catId)
        ->get();

        return response()->json($medicines, 200);
    }
    

    
public function getCatOwner($catId , $userId)
{
    $catInfo = Category::find($catId);
    $user = User::find($userId);
    if (! $catInfo || !$user) {
        return response()->json(['Invalid'], 404);
    }

    $medicines = DB::table('medicines')
    ->where('category_id', $catId)
    ->where('user_id', $userId)
    ->get();

    return response()->json($medicines, 200);
}
}
