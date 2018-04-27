<?php

namespace Tests\Feature\Groups;

use App\Group;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class GroupMemberEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_add_members_to_a_group_by_email_address()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);
        $newMember = $this->createUser();

        $this->visit(route('groups.show', $group));
        $this->submitForm(__('group.add_member'), [
            'email' => $newMember->email,
        ]);

        $this->seePageIs(route('groups.show', $group));
        $this->see(__('group.member_added'));
        $this->see($newMember->name);

        $this->seeInDatabase('group_members', [
            'group_id' => $group->id,
            'user_id'  => $newMember->id,
        ]);
    }
}
