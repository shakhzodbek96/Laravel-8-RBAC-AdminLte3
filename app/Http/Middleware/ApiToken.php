<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\TokenController;
use App\Services\LogWriter;
use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $start_time = microtime(true);
        $validate = TokenController::validateToken($request->bearerToken());

        if ($validate['status'])
        {
            try {
                $result = $next($request);
            }
            catch (\Exception $exception)
            {
                $result = response()->json([
                    'status' => false,
                    'error' => [
                        "message" => $exception->getMessage(),
                        "line" => $exception->getLine(),
                        "file" => $exception->getFile()
                    ]
                ],500);
            }
        }
        else
            $result = response()->json($validate,401);

        // Calculate script execution time
        $execution_time = round((microtime(true) - $start_time) * 1000);

        LogWriter::requests($request,json_decode($result->content(),true),$execution_time);

        return $result;
    }
}
