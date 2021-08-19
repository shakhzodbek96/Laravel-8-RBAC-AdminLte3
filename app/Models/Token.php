<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\This;

class
Token extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'api_user_id',
        'token',
        'token_expires_at',
        'is_active',
        'removed_by',
    ];

    public function user()
    {
        return $this->belongsTo(ApiUser::class,'api_user_id');
    }

    public function me()
    {
        $user = $this->user;
        return [
            'username' => $user->name,
            'access_token' => $this->token,
            'token_valid_period' => $user->token_valid_period,
            'token_expires_at' => $this->token_expires_at
        ];
    }

    public static function generateToken(int $user_id):self
    {
        $user = ApiUser::find($user_id);
        return self::create([
            'api_user_id' => $user_id,
            'token' => Str::uuid(),
            'token_expires_at' => date('Y-m-d H:i:s',strtotime("+ $user->token_valid_period days")),
        ]);
    }

    public function toggleTokenActivation()
    {
        $this->is_active = !$this->is_active;
        $this->save();
        return $this->is_active;
    }

    public function forget()
    {
        $this->is_active = 0;
        $this->save();
    }
}
