<?php

namespace App\Http\Traits;


use App\Models\File;

trait HasFile
{
    public function files()
    {
        $table = (new self())->getTable();
        return hasMany(File::class,'model_id')->where('model_table',$table);
    }
}
