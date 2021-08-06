<?php

namespace Tests\Feature\Groups;

use App\Group;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GroupDateEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_set_group_as_active_by_set_start_date()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);

        $this->visit(route('groups.show', $group));
        $this->see(__('group.planned'));

        $this->submitForm(__('group.set_start_date'), [
            'start_date' => '2017-01-01',
        ]);

        $this->seePageIs(route('groups.show', $group));
        $this->see(__('group.started'));
        $this->see(__('group.active'));

        $this->seeInDatabase('groups', [
            'id'         => $group->id,
            'start_date' => '2017-01-01',
        ]);
    }

    /** @test */
    public function user_can_set_group_as_closed_by_set_end_date()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create([
            'start_date' => '2017-01-01',
            'creator_id' => $user->id,
        ]);

        $this->visit(route('groups.show', $group));
        $this->see(__('group.active'));

        $this->submitForm(__('group.set_end_date'), [
            'end_date' => '2017-12-31',
        ]);

        $this->seePageIs(route('groups.show', $group));
        $this->see(__('group.ended'));
        $this->see(__('group.closed'));

        $this->seeInDatabase('groups', [
            'id'       => $group->id,
            'end_date' => '2017-12-31',
        ]);
    }
}
