<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChangePasswordTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_change_password()
    {
        $user = $this->loginAsUser();

        $this->visit(route('home'));
        $this->click(trans('auth.change_password'));

        $this->submitForm(trans('auth.change_password'), [
            'old_password'          => 'secret',
            'password'              => 'rahasia',
            'password_confirmation' => 'rahasia',
        ]);

        $this->see(trans('auth.password_changed'));

        $this->assertTrue(
            app('hash')->check('rahasia', $user->password),
            'The password should changed!'
        );
    }

    /** @test */
    public function user_cannot_change_password_if_old_password_wrong()
    {
        $user = $this->loginAsUser();

        $this->visit(route('home'));
        $this->click(trans('auth.change_password'));

        $this->submitForm(trans('auth.change_password'), [
            'old_password'          => 'member1',
            'password'              => 'rahasia',
            'password_confirmation' => 'rahasia',
        ]);

        $this->see(trans('auth.old_password_failed'));

        $this->assertTrue(
            app('hash')->check('secret', $user->password),
            'The password shouldn\'t changed!'
        );
    }
}
