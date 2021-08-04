<?php

namespace Tests\Unit\Models;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_belongs_to_many_groups_relation()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $user->groups()->attach($group->id);

        $this->seeInDatabase('group_members', [
            'user_id'  => $user->id,
            'group_id' => $group->id,
        ]);

        $this->assertInstanceOf(Collection::class, $user->groups);
        $this->assertInstanceOf(Group::class, $user->groups->first());
    }
}
