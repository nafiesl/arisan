<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Payment;
use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    public function show(Meeting $meeting)
    {
        $group = $meeting->group;
        $members = $group->members;
        $payments = $meeting->payments;

        return view('meetings.show', compact('meeting', 'group', 'members', 'payments'));
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

    public function paymentEntry(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting->group);

        $paymentData = $request->validate([
            'membership_id'       => 'required|numeric|exists:group_members,id',
            'amount'              => 'required|numeric',
            'date'                => 'required|date|date_format:Y-m-d',
            'payment_receiver_id' => 'required|numeric|exists:users,id',
        ]);

        $payment = Payment::firstOrNew([
            'membership_id' => $paymentData['membership_id'],
            'meeting_id'    => $meeting->id,
        ]);

        $payment->amount = $paymentData['amount'];
        $payment->date = $paymentData['date'];
        $payment->payment_receiver_id = $paymentData['payment_receiver_id'];
        $payment->creator_id = auth()->id();
        $payment->save();

        flash(__('payment.updated'), 'success');

        return back();
    }
}
