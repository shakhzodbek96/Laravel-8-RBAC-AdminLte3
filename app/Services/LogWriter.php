<?php

namespace App\Services;

class LogWriter
{

    public static function info($message)
    {
        return self::log($message,'info','info');
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
