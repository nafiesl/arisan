<?php

namespace Tests\Unit\Policies;

use App\Group;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GroupPolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_group()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Group));
    }

    /** @test */
    public function user_can_view_group()
    {
        $user = $this->createUser();
        $group = factory(Group::class)->create();
        $this->assertTrue($user->can('view', $group));
    }

    /** @test */
    public function only_group_creator_that_can_update_group()
    {
        $user = $this->createUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);

        $this->assertTrue($user->can('update', $group));

        $user = $this->createUser();
        $this->assertFalse($user->can('update', $group));
    }

    /** @test */
    public function only_group_creator_that_can_delete_group()
    {
        $user = $this->createUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);

        $this->assertTrue($user->can('delete', $group));

        $user = $this->createUser();
        $this->assertFalse($user->can('delete', $group));
    }
}
