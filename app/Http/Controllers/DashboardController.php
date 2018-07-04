<?php

namespace App\Http\Controllers;

use App\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = auth()->user()->groups;
        $membershipIds = [];
        foreach ($groups as $group) {
            $membershipIds[$group->id] = $group->pivot->id;
        }
        $outstandingPayments = $this->getUserOutstandingPayments(auth()->user());

        return view('home', compact('groups', 'membershipIds', 'outstandingPayments'));
    }

    public function getUserOutstandingPayments(User $user)
    {
        $userGroups = $user->groups->load('meetings.payments');
        $meetings = $userGroups->pluck('meetings')->flatten()->sortBy('number');

        return $meetings;
    }
}
