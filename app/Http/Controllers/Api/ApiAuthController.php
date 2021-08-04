<?php

namespace App\Http\Controllers\Api;

use App\Models\ApiUser;
use App\Models\Token;
use Illuminate\Http\Request;

class ApiAuthController extends ResponseController
{
    public function me()
    {
       return self::successResponse(accessToken()->me());
    }

    public function login(Request $request)
    {
        $v = $this->validate($request->all(),[
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($v !== true) return $v;

        $user = ApiUser::where('name',$request->username)
            ->where('password',$request->password)
            ->first();


        // User is not active
        if (!$user->is_active)
        {
            return self::errorResponse("User is not active!");
        }

        if (is_null($user))
        {
            return self::authFailed();
        }
        else
        {
            return (new TokenController())->getToken($request->all());
        }
    }

    public function getAllTokens(Request $request)
    {
        return self::successResponse([
            'tokens' => apiAuth()->tokenList()
        ]);
    }

    public function logout(Request $request)
    {
        accessToken()->forget($request->bearerToken());

        return self::successResponse([
            'message' => 'Logged out',
            'access_token' => accessToken()->token
        ]);
    }
}
