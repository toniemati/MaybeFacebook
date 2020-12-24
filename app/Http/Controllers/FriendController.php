<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function store($id, User $user)
    {
        $auth = User::findOrFail($id);

        return $auth->friends()->toggle($user->profile);
    }

    public function status($id, User $user)
    {
        $auth = User::findOrFail($id);

        if ($auth->friends) {
            $status = false;
        }

        foreach ($auth->friends as $friend) {
            if ($friend->id == $user->id)
                $status = true;
            else
                $status = false;
        }

        return $status;
    }
}
