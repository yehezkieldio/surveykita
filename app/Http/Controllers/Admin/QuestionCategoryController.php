<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionCategoryRequest;
use App\Http\Requests\Admin\UpdateQuestionCategoryRequest;
use App\Models\QuestionCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class QuestionCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => QuestionCategory::query()
                ->withCount('questions')
                ->latest()
                ->paginate(10),
        ]);
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
