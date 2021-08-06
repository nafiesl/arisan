<?php

namespace Tests\Unit\Models;

use App\Group;
use App\Meeting;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_group_has_name_link_method()
    {
        $group = factory(Group::class)->create();

        $this->assertEquals(
            link_to_route('groups.show', $group->name, [$group], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $group->name, 'type' => trans('group.group')]
                ),
            ]), $group->nameLink()
        );
    }

    /** @test */
    public function a_group_has_belongs_to_many_members_relation()
    {
        $group = factory(Group::class)->create();
        $member = factory(User::class)->create();

        $group->members()->attach($member->id);

        $this->seeInDatabase('group_members', [
            'group_id' => $group->id,
            'user_id'  => $member->id,
        ]);

        $this->assertInstanceOf(Collection::class, $group->members);
        $this->assertInstanceOf(User::class, $group->members->first());
    }

    /** @test */
    public function a_group_has_add_member_method()
    {
        $user = $this->createUser();
        $group = factory(Group::class)->create();

        $group->addMember($user);

        $this->seeInDatabase('group_members', [
            'group_id' => $group->id,
            'user_id'  => $user->id,
        ]);
    }

    /** @test */
    public function new_member_addition_is_limited_to_group_capacity()
    {
        $user = $this->createUser();
        $group = factory(Group::class)->create(['capacity' => 2]);

        $group->addMember($user);
        $group->addMember($user);
        $this->assertFalse($group->addMember($user));

        $this->assertCount(2, $group->members);
    }

    /** @test */
    public function a_group_has_is_full_method()
    {
        $user = $this->createUser();
        $group = factory(Group::class)->create(['capacity' => 2]);

        $group->addMember($user);
        $group->addMember($user);

        $this->assertTrue($group->isFull());
    }

    /** @test */
    public function a_group_has_remove_member_method()
    {
        $user = $this->createUser();
        $group = factory(Group::class)->create();

        $group->addMember($user);

        $groupMember = \DB::table('group_members')->where([
            'group_id' => $group->id,
            'user_id'  => $user->id,
        ])->first();

        $group->removeMember($groupMember->id);

        $this->dontSeeInDatabase('group_members', [
            'id'       => $groupMember->id,
            'group_id' => $group->id,
            'user_id'  => $user->id,
        ]);
    }

    /** @test */
    public function a_group_has_belongs_to_creator_relation()
    {
        $group = factory(Group::class)->make();

        $this->assertInstanceOf(User::class, $group->creator);
        $this->assertEquals($group->creator_id, $group->creator->id);
    }

    /** @test */
    public function a_group_has_planned_status_by_default()
    {
        $group = factory(Group::class)->make();

        $this->assertTrue($group->isPlanned());
        $this->assertEquals(trans('group.planned'), $group->status);
    }

    /** @test */
    public function a_group_has_active_status_if_start_date_has_filled()
    {
        $group = factory(Group::class)->make(['start_date' => date('Y-m-d')]);

        $this->assertTrue($group->isActive());
        $this->assertEquals(trans('group.active'), $group->status);
    }

    /** @test */
    public function a_group_has_closed_status_if_end_date_has_filled()
    {
        $group = factory(Group::class)->make([
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);

        $this->assertTrue($group->isClosed());
        $this->assertEquals(trans('group.closed'), $group->status);
    }

    /** @test */
    public function a_group_has_has_many_meetings_relation()
    {
        $group = factory(Group::class)->create();
        $meeting = factory(Meeting::class)->create(['group_id' => $group->id]);

        $this->assertInstanceOf(Collection::class, $group->meetings);
        $this->assertInstanceOf(Meeting::class, $group->meetings->first());
    }

    /** @test */
    public function a_group_has_winner_payoff_attribute()
    {
        $group = factory(Group::class)->create(['payment_amount' => 50]);
        $member = factory(User::class)->create();

        $group->addMember($member);
        $group->addMember($member);

        $this->assertEquals(100, $group->winner_payoff);
    }
}
