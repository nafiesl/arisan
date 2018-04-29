<?php

namespace App\Http\Controllers\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Meeting;
use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    public function index(Group $group)
    {
        $meetings = $group->meetings;

        return view('groups.meetings', compact('group', 'meetings'));
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

    public function update(Request $request, Group $group, Meeting $meeting)
    {
        $this->authorize('update', $group);

        $meetingData = $request->validate([
            'date'  => 'required|date|date_format:Y-m-d',
            'place' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $meeting->update($meetingData);

        flash(__('meeting.updated', [
            'number' => $meeting->number,
            'date'   => $meetingData['date'],
            'place'  => $meetingData['place'],
        ]), 'success');

        return redirect()->route('groups.meetings.index', $group);
    }
}
