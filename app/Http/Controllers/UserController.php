<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::Where('role_id', '1')->get();

        return response()->json($users, 200);
    }

    public function getUserInfo()
    {
        $user = User::Where('id', Auth::id())->get();

        return response()->json($user, 200);
    }

    public function addToFav($medicine_id)
    {
        // تحقق من عدم وجود الدواء في المفضلة مسبقاً
        $favoriteExists = Favorite::where('user_id', Auth::id())
            ->where('medicine_id', $medicine_id)
            ->exists();

        if ($favoriteExists) {
            return response()->json(['message' => 'The medicine is already in favorites']);
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'medicine_id' => $medicine_id,
        ]);

        return response()->json(['message' => 'The medicine was added to favorites successfully'], 200);
    }

    public function getFavs()
    {
        $favs = Favorite::
          With('medicine' )
        ->Where('user_id', Auth::id())->get();

        return response()->json($favs, 200);
    }
}
