<?php

namespace App\Http\Controllers\Groups;

use App\Group;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function index(Group $group)
    {
        $members = $group->members;
        $meetings = $group->meetings()->whereNotNull('winner_id')->orderBy('number')->get();

        return view('groups.outstanding-payments', compact('group', 'members', 'meetings'));
    }
}
