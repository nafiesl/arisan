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
        $meeting = factory(Meeting::class)->create([
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

    /** @test */
    public function user_can_only_select_winner_from_winner_candidates_who_has_not_win()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);

        $oldWinner = $this->createUser();
        $winnerCandidate = $this->createUser();
        $group->addMember($oldWinner);
        $group->addMember($winnerCandidate);

        $winnerMembershipId = $group->members->first()->pivot->id;
        $winnerCandidateMembershipId = $group->members->last()->pivot->id;

        $firstMeeting = factory(Meeting::class)->create([
            'number'    => 1,
            'group_id'  => $group->id,
            'winner_id' => $winnerMembershipId,
        ]);

        $secondMeeting = factory(Meeting::class)->create([
            'number'   => 2,
            'group_id' => $group->id,
        ]);

        $this->visit(route('meetings.show', $secondMeeting));
        $this->click('set-winner');
        $this->seePageIs(route('meetings.show', [$secondMeeting, 'action' => 'set-winner']));
        $this->dontSee('<option value="'.$winnerMembershipId.'">'.$oldWinner->name.'</option>');
        $this->see('<option value="'.$winnerCandidateMembershipId.'">'.$winnerCandidate->name.'</option>');
    }
}
