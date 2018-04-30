<?php

namespace App\Http\Controllers;

use App\Meeting;

class MeetingsController extends Controller
{
    public function show(Meeting $meeting)
    {
        return view('meetings.show', compact('meeting'));
    }
}
