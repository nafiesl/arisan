<?php

namespace Tests\Feature\Meetings;

use App\Group;
use App\Meeting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MeetingWinnerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_set_winner_of_a_meeting()
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
        $this->seeElement('a', ['id' => 'set-winner']);
        $this->click('set-winner');
        $this->seePageIs(route('meetings.show', [$meeting, 'action' => 'set-winner']));

        $this->submitForm(__('meeting.set_winner'), [
            'winner_id' => $membershipId,
        ]);

        $this->seePageIs(route('meetings.show', $meeting));
        $this->see(__('meeting.winner_set', ['name' => $newMember->name]));

        $this->seeInDatabase('meetings', [
            'id'        => $meeting->id,
            'winner_id' => $membershipId,
        ]);
    }
}
