<?php
/**
 * Created by PhpStorm.
 * User: nyinyilwin
 * Date: 6/23/17
 * Time: 11:49 AM.
 */

namespace PhpJunior\LaravelChat\Models;

trait UserGroup
{
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }
}
