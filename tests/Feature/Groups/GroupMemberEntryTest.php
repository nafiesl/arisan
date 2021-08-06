<?php

namespace Tests\Feature\Groups;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GroupMemberEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_add_members_to_a_group_by_email_address()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);
        $newMember = $this->createUser();

        $this->visit(route('groups.members.index', $group));
        $this->submitForm(__('group.add_member'), [
            'email' => $newMember->email,
        ]);

        $this->seePageIs(route('groups.members.index', $group));
        $this->see(__('group.member_added', ['name' => $newMember->name]));
        $this->see($newMember->name);

        $this->seeInDatabase('group_members', [
            'group_id' => $group->id,
            'user_id'  => $newMember->id,
        ]);
    }

    /** @test */
    public function user_can_remove_member_from_a_group()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);
        $newMember = $this->createUser();

        $group->addMember($newMember);

        $groupMember = \DB::table('group_members')->where([
            'group_id' => $group->id,
            'user_id'  => $newMember->id,
        ])->first();

        $this->visit(route('groups.members.index', $group));
        $this->press('remove-member-'.$groupMember->id);

        $this->seePageIs(route('groups.members.index', $group));
        $this->see(__('group.member_removed', ['name' => $newMember->name]));

        $this->dontSeeInDatabase('group_members', [
            'id'       => $groupMember->id,
            'group_id' => $group->id,
            'user_id'  => $newMember->id,
        ]);
    }

    /** @test */
    public function user_can_entry_non_exsits_user_to_the_group()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);

        $this->visit(route('groups.members.index', $group));
        $this->submitForm(__('group.add_member'), [
            'email' => 'nonexistsmember@mail.com',
        ]);

        $this->seePageIs(route('groups.members.index', $group));
        $this->see(__('group.member_added', ['name' => 'nonexistsmember']));

        $this->seeInDatabase('users', [
            'email' => 'nonexistsmember@mail.com',
        ]);

        $newMember = User::where('email', 'nonexistsmember@mail.com')->first();

        $this->seeInDatabase('group_members', [
            'group_id' => $group->id,
            'user_id'  => $newMember->id,
        ]);
    }
}
