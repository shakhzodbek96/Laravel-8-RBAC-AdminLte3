<?php

namespace App\Services;

use Illuminate\Http\Request;

class LogWriter
{

    public static function info($message)
    {
        return self::log($message,'info','info');
    }

    public static function requests(Request $request, $response,$execution_time = null)
    {
        $headers = logObj($request->header());
        $body = logObj($request->all());
        $response = logObj($response);

        $message = "Time [".date('H:i:s')."]\n";
        if (accessToken())
        {
            $user = logObj([
                'username' => apiAuth()->name,
                'token' => accessToken()->token
            ]);
            $name = apiAuth()->name;
            $message.= "User-----|  $user\n";
        }else
        {
            $name = "Undefined";
        }

        $message.= "Headers--|  $headers\n";
        $message.= "Body-----|  $body\n";
        $message.= "Response-|  $response\n";
        $message.= "Execution|  $execution_time ms\n------------------------------------------------------------------------------------------------------------------------\n";
        return self::log($message,date('M-d'),"API/$name/".date('Y-m'));
    }

    public static function exceptions($message)
    {
        return self::log($message,date('M-d'),'Exceptions/'.date('Y-m'));
    }

    public static function user_activity($message,$file = 'UserActivity' )
    {
        $message = "\n[\"DateTime\"]: [".date('Y-m-d H:i:s')."]".$message;
        return self::log($message,$file,'UserActivity');
    }

    // main log writer function
    public static function log($content, $file = 'app', $dir = 'AppLogs')
    {
        self::dirChecker($dir);
        $path = storage_path("logs/".$dir."/".$file.'.log');
        return fwrite(fopen($path,'a'),$content."\n");
    }

    // check existing of directory and create if not exists
    public static function dirChecker($dir)
    {
        $directories = explode("/",$dir);
        $dir_path = storage_path("logs");

        foreach ($directories as $directory) {

            $dir_path .= "/".$directory;

            if(is_dir($dir_path) === false )
            {
                mkdir($dir_path);
            }
        }
    }


}
