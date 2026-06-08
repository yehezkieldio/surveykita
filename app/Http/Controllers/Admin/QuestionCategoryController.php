<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionCategoryRequest;
use App\Http\Requests\Admin\UpdateQuestionCategoryRequest;
use App\Models\QuestionCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class QuestionCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index');
    }

    public function data(): JsonResponse
    {
        return DataTables::eloquent(
            QuestionCategory::query()
                ->withCount('questions')
        )
            ->addColumn('slug', fn (QuestionCategory $category): string => Str::slug($category->name, '_'))
            ->addColumn('actions', fn (QuestionCategory $category): string => 
                view('admin.categories.partials.actions', ['category' => $category])->render()
            )
            ->rawColumns(['actions'])
            ->toJson()
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreQuestionCategoryRequest $request): RedirectResponse
    {
        QuestionCategory::query()->create($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori pertanyaan berhasil dibuat.');
    }

    public function show(QuestionCategory $category): View
    {
        return view('admin.categories.show', [
            'category' => $category->load([
                'questions.evaluationForm.evaluationPeriod',
            ])->loadCount('questions'),
        ]);
    }

    public function edit(QuestionCategory $category): View
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(UpdateQuestionCategoryRequest $request, QuestionCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori pertanyaan berhasil diperbarui.');
    }

    public function destroy(QuestionCategory $category): RedirectResponse
    {
        if ($category->questions()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh pertanyaan.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori pertanyaan berhasil dihapus.');
    }
}
