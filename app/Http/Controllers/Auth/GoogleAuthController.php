<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Services\NimParser;
use App\Services\StudentProfileFormatter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;
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

    public function callback(StudentProfileFormatter $formatter, NimParser $parser): RedirectResponse
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

        $user = DB::transaction(function () use ($email, $formatter, $googleUser, $name, $parser, $user): User {
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

            $nim = $formatter->googleNim((string) $googleUser->getName(), $email);

            if ($nim) {
                try {
                    $parsed = $parser->parse($nim);
                } catch (InvalidArgumentException) {
                    $parsed = null;
                }

                if ($parsed) {
                    $student = $user->student ?: new Student(['user_id' => $user->id]);
                    $guessedClassName = $formatter->guessedClassName($parsed);

                    $student->fill([
                        'nim' => $parsed['nim'],
                        'name' => $name,
                        'program_code' => $parsed['program_code'],
                        'study_program' => $parsed['study_program'],
                        'enrollment_year' => $parsed['enrollment_year'],
                        'sequence_number' => $parsed['sequence_number'],
                        'class_name' => $student->class_name ?: $guessedClassName,
                        'class_name_confirmed' => $student->exists
                            ? (bool) $student->class_name_confirmed
                            : false,
                    ])->save();

                    $user->setRelation('student', $student);
                }
            }

            return $user;
        });

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->route(
            $user->hasCompleteStudentProfile() ? 'student.dashboard' : 'student.profile.complete'
        );
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
