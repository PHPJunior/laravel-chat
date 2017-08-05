<?php

namespace PhpJunior\LaravelChat\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpJunior\LaravelChat\Events\NewMessage;
use PhpJunior\LaravelChat\Models\Conversation;

class ConversationController extends Controller
{
    public function show($id)
    {
        return Conversation::with('user')->where('group_id', $id)->get()->toJson();
    }

    public function store()
    {
        $conversation = Conversation::create([
            'message'  => request('message'),
            'group_id' => request('group_id'),
            'user_id'  => request('user_id'),
        ]);

        broadcast(new NewMessage($conversation))->toOthers();

        return $conversation->load('user');
    }
}
