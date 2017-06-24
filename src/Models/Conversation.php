<?php

namespace PhpJunior\LaravelChat\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['message', 'user_id', 'group_id','created_at'];

    public function user()
    {
        return $this->belongsTo(config('laravel-chat.user'));
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
