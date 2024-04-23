<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;

class AuthController extends Controller
{
    public function createPharmacistAccount(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'min:10', 'regex:/^[0-9]+$/'], //syrian number
            'email' => ['required', 'string', 'email', 'max:255', ValidationRule::unique(table: 'users')],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $request['password'] = Hash::make($request['password']); // encode password

        $user = User::query()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 2,
        ]);

        //add token to user
        $tokenResult = $user->createToken('personal Access Token');

        $data['user'] = $user;
        $data['token_type'] = 'Bearer';
        $data['access_token'] = $tokenResult->accessToken;

        return response()->json([$data, 'status' => 200, 'message' => 'signed up successfully']);
    }


    public function createWarehouseAccount(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'min:10', 'regex:/^[0-9]+$/'], //syrian number
            'email' => ['required', 'string', 'email', 'max:255', ValidationRule::unique(table: 'users')],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        $request['password'] = Hash::make($request['password']); // encode password

        $user = User::query()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 1,
        ]);

        //add token to user
        $tokenResult = $user->createToken('personal Access Token');

        $data['user'] = $user;
        $data['token_type'] = 'Bearer';
        $data['access_token'] = $tokenResult->accessToken;

        return response()->json([$data, 'status' => 200, 'message' => 'signed up successfully']);

    }


    public function login(Request $request)
    {
        $validator = validator::make($request->all(), [
            'loginame' => ['required', 'string', 'max:255'], //Email or Phone
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 422);
        }

        $login_type = filter_var($request->input('loginame'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        //   @   .  validate
        $request->merge([
            $login_type => $request->input('loginame'),
        ]);

        if (! Auth::attempt($request->only($login_type, 'password'))) {
            return response()->json(['message' => 'this Account does not exist'], 401);
        }

        $user = $request->user();
        //add token to user
        $tokenResult = $user->createToken('personal Access Token'); //->accessToken;

        $user = User::where('id', '=', auth()->id())->first();
        $role = Role::where('id', '=', $user->role_id)->first();

        $data['user'] = $user;
        $data['token_type'] = 'Bearer';
        $data['access_token'] = $tokenResult->accessToken;
        $data['role'] = $role;

        return response()->json([$data, 'status' => 200, 'message' => 'logedd In successfully']);
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'logged out ', 'status' => 200]);
    }
}
