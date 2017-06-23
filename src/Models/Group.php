<?php

namespace PhpJunior\LaravelChat\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

    protected $with = ['users'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class,'group_id','id');
    }

    public function hasUser($user_id)
    {
        foreach ($this->users as $user) {
            if($user->id == $user_id) {
                return true;
            }
        }
    }
}
