<?php

namespace PhpJunior\LaravelChat\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpJunior\LaravelChat\Events\NewMessage;
use PhpJunior\LaravelChat\Models\Conversation;

class ConversationController extends Controller
{
    public function show($id)
    {
        $conversations = Conversation::with('user')->where('group_id' , $id)->get();
        return $conversations->toJson();
    }

    public function store()
    {
        $conversation = Conversation::create([
            'message' => request('message'),
            'group_id' => request('group_id'),
            'user_id' => request('user_id'),
            'created_at' => Carbon::now()->timezone('Asia/Rangoon')
        ]);

        broadcast(new NewMessage($conversation))->toOthers();

        return $conversation->load('user');
    }
}
