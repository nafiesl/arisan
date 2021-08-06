<?php

namespace App\Http\Controllers\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index(Group $group)
    {
        $meetings = $group->meetings;

        return view('groups.members', compact('group', 'meetings'));
    }

    public function store(Request $request, Group $group)
    {
        $userData = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::firstOrNew(['email' => $userData['email']]);

        if (!$user->exists) {
            $newUserName = explode('@', $userData['email']);
            $user->name = $newUserName[0];
            $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm';
            $user->save();
        }

        if ($group->addMember($user) == false) {
            flash(__('group.member_add_failed'), 'error');
        } else {
            flash(__('group.member_added', ['name' => $user->name]), 'success');
        }

        return back();
    }

    public function destroy(Request $request, Group $group, User $member)
    {
        $request->validate([
            'group_member_id' => 'required|numeric|exists:group_members,id',
        ]);
        $group->removeMember($request->get('group_member_id'));

        flash(__('group.member_removed', ['name' => $member->name]), 'warning');

        return back();
    }
}
