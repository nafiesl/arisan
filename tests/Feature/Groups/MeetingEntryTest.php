<?php

namespace Tests\Feature\Groups;

use App\Group;
use App\Meeting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MeetingEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_set_new_meeting()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);
        $newMember = $this->createUser();
        $group->addMember($newMember);

        $meetingNumber = 1;
        $this->visit(route('groups.meetings.index', $group));
        $this->seeElement('a', ['id' => 'set-meeting-'.$meetingNumber]);
        $this->click('set-meeting-'.$meetingNumber);
        $this->seePageIs(route('groups.meetings.index', [$group, 'action' => 'set-meeting', 'number' => $meetingNumber]));

        $this->submitForm(__('meeting.create', ['number' => $meetingNumber]), [
            'number' => $meetingNumber,
            'date'   => '2017-01-06',
            'place'  => 'Inter Cafe',
            'notes'  => 'Si A belum transfer.',
        ]);

        $this->seePageIs(route('groups.meetings.index', $group));
        $this->see(__('meeting.created', [
            'number' => $meetingNumber,
            'date'   => '2017-01-06',
            'place'  => 'Inter Cafe',
        ]));

        $this->seeInDatabase('meetings', [
            'group_id' => $group->id,
            'number'   => $meetingNumber,
            'date'     => '2017-01-06',
            'place'    => 'Inter Cafe',
            'notes'    => 'Si A belum transfer.',
        ]);
    }

    /** @test */
    public function user_can_edit_existing_meeting()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);
        $newMember = $this->createUser();
        $group->addMember($newMember);
        $meeting = factory(Meeting::class)->create(['group_id' => $group->id]);

        $meetingNumber = 1;
        $this->visit(route('meetings.show', $meeting));
        $this->seeElement('a', ['id' => 'edit-meeting-'.$meetingNumber]);
        $this->click('edit-meeting-'.$meetingNumber);
        $this->seePageIs(route('meetings.show', [$meeting, 'action' => 'edit-meeting']));

        $this->submitForm(__('meeting.update', ['number' => $meetingNumber]), [
            'date'  => '2017-02-06',
            'place' => 'Inter Cafe 1',
            'notes' => 'Si B belum transfer.',
        ]);

        $this->seePageIs(route('meetings.show', $meeting));
        $this->see(__('meeting.updated', [
            'number' => $meetingNumber,
            'date'   => '2017-02-06',
            'place'  => 'Inter Cafe 1',
        ]));

        $this->seeInDatabase('meetings', [
            'group_id' => $group->id,
            'number'   => $meetingNumber,
            'date'     => '2017-02-06',
            'place'    => 'Inter Cafe 1',
            'notes'    => 'Si B belum transfer.',
        ]);
    }
}
