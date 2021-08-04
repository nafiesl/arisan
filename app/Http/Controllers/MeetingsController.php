<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Payment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MeetingsController extends Controller
{
    public function show(Meeting $meeting)
    {
        $group = $meeting->group;
        $members = $group->members;
        $payments = $meeting->payments;
        $winnerCadidateList = $this->getWinnerCandidates($meeting, $members);

        return view('meetings.show', compact('meeting', 'group', 'members', 'payments', 'winnerCadidateList'));
    }

    private function getWinnerCandidates(Meeting $meeting, Collection $members)
    {
        $winnerCandidateList = [];

        $winnerMemberIds = Meeting::where('id', '!=', $meeting->id)->pluck('winner_id')->all();

        foreach ($members as $member) {
            $memberId = $member->pivot->id;

            if (in_array($memberId, $winnerMemberIds) == false) {
                $winnerCandidateList[$memberId] = $member->name;
            }
        }

        return $winnerCandidateList;
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

    public function setWinner(Request $request, Meeting $meeting)
    {
        $winnerData = $request->validate(['winner_id' => 'required|numeric|exists:group_members,id']);

        $meeting->winner_id = $winnerData['winner_id'];
        $meeting->save();

        $userId = \DB::table('group_members')->where('id', $winnerData['winner_id'])->first()->user_id;
        $user = User::find($userId);

        flash(__('meeting.winner_set', ['name' => $user->name]), 'success');

        return redirect()->route('meetings.show', $meeting);
    }
}
