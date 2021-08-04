<?php

namespace Tests\Feature;

use App\Group;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageGroupsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_group_list_in_group_index_page()
    {
        $otherGroup = factory(Group::class)->create();

        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);

        $this->visit(route('groups.index'));
        $this->dontSee($otherGroup->name);
        $this->see($group->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'           => 'Group 1 name',
            'capacity'       => 20,
            'currency'       => 'IDR',
            'payment_amount' => 100000,
            'description'    => 'Group 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_group()
    {
        $this->loginAsUser();
        $this->visit(route('groups.index'));

        $this->click(trans('group.create'));
        $this->seePageIs(route('groups.create'));

        $this->submitForm(trans('group.create'), $this->getCreateFields());

        $this->seePageIs(route('groups.show', Group::first()));

        $this->seeInDatabase('groups', $this->getCreateFields());
    }

    /** @test */
    public function create_group_action_must_pass_validations()
    {
        $this->loginAsUser();

        // Name empty
        $this->post(route('groups.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');

        // Name 70 characters
        $this->post(route('groups.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');

        // Description 256 characters
        $this->post(route('groups.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'           => 'Group 1 name',
            'capacity'       => 24,
            'currency'       => 'IDR',
            'payment_amount' => 100000,
            'start_date'     => '2017-01-01',
            'end_date'       => '2017-12-31',
            'description'    => 'Group 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_group()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['name' => 'Testing 123', 'creator_id' => $user->id]);

        $this->visit(route('groups.show', $group));
        $this->click('edit-group-'.$group->id);
        $this->seePageIs(route('groups.edit', $group));

        $this->submitForm(trans('group.update'), $this->getEditFields());

        $this->seePageIs(route('groups.show', $group));

        $this->seeInDatabase('groups', [
            'id' => $group->id,
        ] + $this->getEditFields());
    }

    /** @test */
    public function edit_group_action_must_pass_validations()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['name' => 'Testing 123', 'creator_id' => $user->id]);

        // Name empty
        $this->patch(route('groups.update', $group), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');

        // Name 70 characters
        $this->patch(route('groups.update', $group), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');

        // Description 256 characters
        $this->patch(route('groups.update', $group), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_group()
    {
        $user = $this->loginAsUser();
        $group = factory(Group::class)->create(['creator_id' => $user->id]);

        $this->visit(route('groups.edit', $group));
        $this->click('del-group-'.$group->id);
        $this->seePageIs(route('groups.edit', [$group, 'action' => 'delete']));

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('groups', [
            'id' => $group->id,
        ]);
    }
}
