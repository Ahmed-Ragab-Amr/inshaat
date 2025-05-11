<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Payment;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserProfileResource;

class AuthController extends Controller
{

    use ApiTrait;
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }


    public function register(CreateUserRequest $request) {

        $data = $request->all();

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

            return $this->success('User successfully registered' , 200 , new UserResource($user));

    }




    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }



    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }



    public function userProfile() {

        $user = User::with('payments')->where('id' , auth()->id())->first();

        $main_payment = Payment::where('user_id' , auth()->id())->where('status' , 'main')->first();

        return $this->success('user information' , 200 , new UserProfileResource($user , $main_payment));

    }



    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
