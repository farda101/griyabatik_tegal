<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
<<<<<<< HEAD
use Illuminate\Auth\Events\Registered;
=======
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required|unique:users,email|max:255',
            'password' => 'string|required|confirmed|min:8',
            'terms' => 'accepted', // pastikan checkbox terms disetujui
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

<<<<<<< HEAD
        event(new Registered($user));

        return redirect(route('verification.notice'));
=======
        return redirect()->route('login')->with('success', 'Akun Anda berhasil dibuat, silakan masuk.');
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
    }
}
