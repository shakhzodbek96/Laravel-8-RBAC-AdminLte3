<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\DB;

class ApiAjax
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_user = User::where('password',$request->get('_token'))->count();

        if ($is_user)
            return $next($request);
        else
            return response()->json([
                'error' => [
                    'message' => 'Authorization failed!'
                ]
            ],403);
    }
}
