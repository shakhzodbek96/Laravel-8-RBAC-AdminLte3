<?php

namespace App\Http\Controllers\Api;

use App\Models\ApiUser;
use App\Models\Token;

class TokenController extends ResponseController
{
    public function getToken(array $params)
    {
        $this->validate($params,[
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = ApiUser::where('name',$params['username'])
            ->where('password',$params['password'])
            ->first();

        if (is_null($user))
        {
            return self::authFailed();
        }

        $token = Token::generateToken($user->id);

        return self::successResponse([
            'access_token' => $token->token,
            'token_expires_at' => $token->token_expires_at
        ]);
    }

    public static function validateToken($token)
    {
        $token = Token::where('token',$token)
            ->with('user')
            ->first();

        // existing
        if (is_null($token))
        {
            return self::authFailed();
        }
        // date expire
        if (strtotime($token->token_expires_at) < strtotime(date('r')))
        {
            return self::errorResponse("Token is expired!");
        }
        // User is not active
        if (!$token->user->is_active)
        {
            return self::errorResponse("User is not active!");
        }

        // status
        if (!$token->is_active)
        {
            return self::errorResponse('Your token is deactivated!');
        }
        return self::successResponse([
            'token_expires_at' => $token->token_expires_at
        ]);
    }
}
