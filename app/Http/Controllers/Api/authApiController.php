<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use Response;
use App\User;

use App\Http\Resources\UserResource;

class authApiController extends Controller
{
    public function register(Request $request)
    {
    	$this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

    	$user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'api_token' => Str::random(80)
        ]);
        
			return (new UserResource($user))->additional([
				'meta' => [
						'api_token' => $user->api_token,
				],
			]);
    }

    public function login(Request $request)
    {
    	$this->validate($request, [
    			'email' => ['required', 'string', 'email'],
            	'password' => ['required', 'min:8'],
    		]);

    	$auth = auth()->attempt($request->only('email','password'));

    	if ($auth) {
    		$currentUser = auth()->user();

    		return (new UserResource($currentUser))->additional([
				'meta' => [
						'api_token' => $currentUser->api_token,
				],
			]);
    	}else{
    		return "Email atau password salah";
    	}


    }
}
