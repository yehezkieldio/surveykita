<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStudentRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Services\NimParser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('admin.students.index');
    }

    public function data(): JsonResponse
    {
        return DataTables::eloquent(
            Student::query()
                ->with('user')
                ->select('students.*')
        )
            ->addColumn('email', fn (Student $student): string => $student->user?->email ?? '-')
            ->addColumn('actions', fn (Student $student): string => view('admin.students.partials.actions', ['student' => $student])->render())
            ->rawColumns(['actions'])
            ->toJson()
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create(): View
    {
        return view('admin.students.create');
    }

    public function store(StoreStudentRequest $request, NimParser $parser): RedirectResponse
    {
        $student = DB::transaction(function () use ($request, $parser): Student {
            $parsed = $parser->parse($request->validated('nim'));

            $user = User::query()->create([
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
                'role' => 'mahasiswa',
                'password' => Hash::make($request->validated('password')),
                'email_verified_at' => now(),
            ]);

            return Student::query()->create([
                'user_id' => $user->id,
                'nim' => $parsed['nim'],
                'name' => $request->validated('name'),
                'program_code' => $parsed['program_code'],
                'study_program' => $parsed['study_program'],
                'enrollment_year' => $parsed['enrollment_year'],
                'sequence_number' => $parsed['sequence_number'],
                'class_name' => $request->validated('class_name'),
                'class_name_confirmed' => true,
            ]);
        });

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Data mahasiswa berhasil dibuat.');
    }

    public function show(Student $student): View
    {
        return view('admin.students.show', [
            'student' => $student->load(['user', 'responses.evaluationForm']),
        ]);
    }

    public function edit(Student $student): View
    {
        return view('admin.students.edit', [
            'student' => $student->load('user'),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student, NimParser $parser): RedirectResponse
    {
        DB::transaction(function () use ($request, $student, $parser): void {
            $parsed = $parser->parse($request->validated('nim'));

            $userData = [
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
            ];

            if (filled($request->validated('password'))) {
                $userData['password'] = Hash::make($request->validated('password'));
            }

            $student->user->update($userData);
            $student->update([
                'nim' => $parsed['nim'],
                'name' => $request->validated('name'),
                'program_code' => $parsed['program_code'],
                'study_program' => $parsed['study_program'],
                'enrollment_year' => $parsed['enrollment_year'],
                'sequence_number' => $parsed['sequence_number'],
                'class_name' => $request->validated('class_name'),
                'class_name_confirmed' => true,
            ]);
        });

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        DB::transaction(function () use ($student): void {
            $user = $student->user;
            $student->delete();
            $user?->delete();
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
