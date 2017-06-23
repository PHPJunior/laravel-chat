<?php

namespace PhpJunior\LaravelChat\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpJunior\LaravelChat\Events\GroupCreated;
use PhpJunior\LaravelChat\Models\Group;

class GroupController extends Controller
{
    public function store()
    {
        $group = Group::create(['name' => request('name')]);

        $users = collect(request('users'));
        $users->push(request('user_id'));

        $group->users()->attach($users);

        broadcast(new GroupCreated($group))->toOthers();

        return $group;
    }
}
