<?php

namespace App\Http\Controllers;

use App\Transformer\UserTransformer;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => 'required|min:5|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:10'
        ]);

        $storeToDatabase = $user->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => bcrypt($request->email)
        ]);

        $response = fractal()
                        ->item($storeToDatabase)
                        ->transformWith(new UserTransformer)
                        ->toArray();

        return response()->json($response, 201);
    }

    public function login(Request $request, User $user)
    {
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json(['message' => 'Your credential is wrong'], 401);
        }

        $findUser = $user->findOrFail(Auth::user()->id);

        return fractal()
            ->item($findUser)
            ->transformWIth(new UserTransformer)
            ->addMeta(['token' =>$findUser->api_token])
            ->toArray();
    }
}
