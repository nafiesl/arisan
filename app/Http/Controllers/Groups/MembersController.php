<?php

namespace App\Http\Controllers\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->get('email'))->first();
        $group->addMember($user);

        flash(__('group.member_added'), 'success');

        return back();
    }
}
