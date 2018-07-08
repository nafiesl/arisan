<?php

namespace App\Http\Controllers\Groups;

use App\Group;
use App\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeetingsController extends Controller
{
    public function index(Group $group)
    {
        $acceptableNumber = null;
        $meetings = $group->meetings;
        $number = (int) request('number');
        $groupMembersCount = $group->members()->count();

        if ($number && $number <= $groupMembersCount) {
            $acceptableNumber = $number;
        }

        return view('groups.meetings', compact('group', 'meetings', 'acceptableNumber'));
    }

    public function store(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        $newMeeting = $request->validate([
            'number' => 'required|numeric|max:'.$group->members()->count(),
            'date'   => 'required|date|date_format:Y-m-d',
            'place'  => 'nullable|string|max:255',
            'notes'  => 'nullable|string|max:255',
        ]);
        $newMeeting['group_id'] = $group->id;
        $newMeeting['creator_id'] = auth()->id();

        Meeting::create($newMeeting);

        flash(__('meeting.created', [
            'number' => $newMeeting['number'],
            'date'   => $newMeeting['date'],
            'place'  => $newMeeting['place'],
        ]), 'success');

        return redirect()->route('groups.meetings.index', $group);
    }
}
