<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\StudentProfileFormatter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class GoogleAuthController extends Controller
{
    private const STUDENT_DOMAIN = '@students.universitasmulia.ac.id';

    public function redirect(): SymfonyRedirectResponse|RedirectResponse
    {
        return Socialite::driver('google')
            ->with(['hd' => ltrim(self::STUDENT_DOMAIN, '@')])
            ->redirect();
    }

    public function callback(StudentProfileFormatter $formatter): RedirectResponse
    {
        try {
            /** @var SocialiteUser $googleUser */
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable) {
            return $this->reject('Login Google dibatalkan atau tidak dapat diverifikasi.');
        }

        $email = Str::of((string) $googleUser->getEmail())->lower()->trim()->toString();
        $name = $formatter->googleName((string) $googleUser->getName(), $email);

        if (! str_ends_with($email, self::STUDENT_DOMAIN)) {
            return $this->reject('Gunakan email mahasiswa Universitas Mulia.');
        }

        $user = User::query()->where('email', $email)->first();

        if ($user?->isAdmin()) {
            return $this->reject('Google login hanya tersedia untuk mahasiswa.');
        }

        if (! $user) {
            $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'role' => 'mahasiswa',
                'password' => null,
            ]);
        }

        $user->forceFill([
            'name' => $name,
            'google_id' => (string) $googleUser->getId(),
        ])->save();

        Auth::login($user);
        request()->session()->regenerate();

        return redirect('/student/profile/complete');
    }

    public function rejected(): View
    {
        return view('auth.google-rejected');
    }

    private function reject(string $message): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('auth.google.rejected')
            ->with('error', $message);
    }
}
