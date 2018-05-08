<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('auth.passwords.change');
    }

    protected function update(Request $request)
    {
        $input = $request->validate([
            'old_password'          => 'required',
            'password'              => 'required|between:6,15|confirmed',
            'password_confirmation' => 'required',
        ], [
            'old_password.required'          => 'Password lama harus diisi.',
            'password.required'              => 'Password baru harus diisi.',
            'password.between'               => 'Password baru harus antara 6 - 15 karakter.',
            'password.confirmed'             => 'Konfirmasi password baru tidak sesuai.',
            'password_confirmation.required' => 'Konfirmasi password baru harus diisi.',
        ]);

        if (app('hash')->check($input['old_password'], auth()->user()->password)) {
            $user = auth()->user();
            $user->password = bcrypt($input['password']);
            $user->save();

            flash(trans('auth.password_changed'), 'success');

            return back();
        }

        flash(trans('auth.old_password_failed'), 'error');

        return back();
    }
}
