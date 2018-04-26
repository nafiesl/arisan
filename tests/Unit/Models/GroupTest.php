<?php

namespace Tests\Unit\Models;

use App\User;
use App\Group;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

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
    public function a_group_has_belongs_to_creator_relation()
    {
        $group = factory(Group::class)->make();

        $this->assertInstanceOf(User::class, $group->creator);
        $this->assertEquals($group->creator_id, $group->creator->id);
    }
}
