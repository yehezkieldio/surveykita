<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasCompleteStudentProfile()) {
            return redirect()->route('student.profile.complete')
                ->with('error', 'Lengkapi profil mahasiswa sebelum mengisi evaluasi.');
        }

        return $next($request);
    }
}
