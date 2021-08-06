<?php

namespace Tests\Feature\Meetings;

use App\Group;
use App\Meeting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PaymentEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_entry_payment_on_a_meeting_in_payment_list()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);
        $newMember = $this->createUser();
        $group->addMember($newMember);
        $meetingNumber = 1;
        $meeting = factory(Meeting::class)->create([
            'number'   => $meetingNumber,
            'group_id' => $group->id,
        ]);

        $membershipId = $group->members->first()->pivot->id;
        $this->visit(route('meetings.show', $meeting));
        $this->seeElement('input', ['id' => 'payment-entry-'.$membershipId]);

        $this->submitForm('payment-entry-'.$membershipId, [
            'membership_id'       => $membershipId,
            'amount'              => 123,
            'date'                => date('Y-m-d'),
            'payment_receiver_id' => $newMember->id,
        ]);

        $this->seePageIs(route('meetings.show', $meeting));
        $this->see(__('payment.updated'));

        $this->seeInDatabase('payments', [
            'membership_id'       => $membershipId,
            'meeting_id'          => $meeting->id,
            'payment_receiver_id' => $newMember->id,
            'amount'              => 123,
            'date'                => date('Y-m-d'),
            'creator_id'          => $user->id,
        ]);
    }
}
