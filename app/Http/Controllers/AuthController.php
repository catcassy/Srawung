<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|alpha_dash|max:30|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ],[
            'username.unique' => 'Username sudah dipakai.',
            'email.unique'    => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('pilih.mode');
    }

    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email','password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $gUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Login Google gagal.']);
        }

        $user = User::where('google_id', $gUser->getId())
                    ->orWhere('email', $gUser->getEmail())
                    ->first();

        if ($user) {
            $user->update(['google_id' => $gUser->getId(), 'avatar_url' => $gUser->getAvatar()]);
        } else {
            $base = Str::slug(explode('@', $gUser->getEmail())[0]);
            $username = $base;
            $i = 1;
            while (User::where('username', $username)->exists()) {
                $username = $base . $i++;
            }
            $user = User::create([
                'name'       => $gUser->getName(),
                'username'   => $username,
                'email'      => $gUser->getEmail(),
                'google_id'  => $gUser->getId(),
                'avatar_url' => $gUser->getAvatar(),
            ]);
        }

        Auth::login($user);
        return $user->wasRecentlyCreated
            ? redirect()->route('pilih.mode')
            : redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    public function showPilihMode() { return view('auth.pilih-mode'); }

    public function setPilihMode(Request $request)
    {
        $request->validate(['mode' => 'required|in:publik,anonim']);
        $request->user()->update(['mode' => $request->mode]);
        return redirect()->route('dashboard');
    }
}
