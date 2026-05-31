<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateProfileRequest;
use App\Models\Student;
use App\Services\NimParser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('student.profile.complete', [
            'student' => auth()->user()?->student,
        ]);
    }

    public function update(UpdateProfileRequest $request, NimParser $parser): RedirectResponse
    {
        $parsed = $parser->parse($request->validated('nim'));
        $user = $request->user();

        $student = $user->student ?: new Student(['user_id' => $user->id]);

        $student->fill([
            'nim' => $parsed['nim'],
            'name' => $request->validated('name'),
            'program_code' => $parsed['program_code'],
            'study_program' => $parsed['study_program'],
            'enrollment_year' => $parsed['enrollment_year'],
            'sequence_number' => $parsed['sequence_number'],
            'class_name' => $request->validated('class_name'),
        ])->save();

        $user->update(['name' => $request->validated('name')]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Profil mahasiswa berhasil dilengkapi.');
    }
}
