<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\V1\EditUser\EditUserFactory;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateStatusSubscription(Request $request)
    {
        $request->validate([
            "status"=> "required|in:1,2"
        ]);  
        auth()->user()->status_subscription =  $request->status;
        auth()->user()->save();
        return JsonSend([
            "status"=> $request->status
        ]);
    }

    public function editUser(Request $request)
    {
        $user = EditUserFactory::edit(auth()->user(), $request->all());       
        return JsonSend($user->getResponse());
    }

    public function editPushToken(Request $request)
    {
        $request->validate([
            "user_id"=> "required|integer",
            "push_token"=> "nullable|string|min:1|max:250"
        ]);
        User::where('id', $request->user_id)
        ->update(['push_token' => $request->push_token]);

        return JsonSend(['push_token' => $request->push_token]);
    }

    public function showPushToken(int $id, Request $request)
    {
        return JsonSend(User::select('id', 'push_token')->find($id));
    }
}
