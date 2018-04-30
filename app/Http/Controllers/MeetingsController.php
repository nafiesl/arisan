<?php

namespace App\Http\Controllers;

use App\Meeting;
use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    public function show(Meeting $meeting)
    {
        return view('meetings.show', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting->group);

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

        return redirect()->route('meetings.show', $meeting);
    }
}
