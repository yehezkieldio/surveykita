<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEvaluationFormRequest;
use App\Http\Requests\Admin\UpdateEvaluationFormRequest;
use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class EvaluationFormController extends Controller
{
    public function index(): View
    {
        return view('admin.forms.index');
    }

    public function data(): JsonResponse
    {
        $query = EvaluationForm::query()
            ->with('evaluationPeriod')
            ->withCount(['questions', 'responses']);

        if (request()->filled('period_id')) {
            $query->where('evaluation_period_id', request('period_id'));
        }

        return DataTables::eloquent($query)
            ->addColumn('period_name', fn (EvaluationForm $form): string => $form->evaluationPeriod->name)
            ->addColumn('actions', fn (EvaluationForm $form): string => 
                view('admin.forms.partials.actions', ['form' => $form])->render()
            )
            ->rawColumns(['actions'])
            ->toJson()
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create(): View
    {
        return view('admin.forms.create', [
            'periods' => EvaluationPeriod::query()->latest()->get(),
        ]);
    }

    public function store(StoreEvaluationFormRequest $request): RedirectResponse
    {
        $form = EvaluationForm::query()->create($request->validated());

        return redirect()->route('admin.forms.show', $form)
            ->with('success', 'Form evaluasi berhasil dibuat.');
    }

    public function show(EvaluationForm $form): View
    {
        return view('admin.forms.show', [
            'form' => $form->load(['evaluationPeriod', 'questions.category'])->loadCount('responses'),
        ]);
    }

    public function edit(EvaluationForm $form): View
    {
        return view('admin.forms.edit', [
            'form' => $form,
            'periods' => EvaluationPeriod::query()->latest()->get(),
        ]);
    }

    public function update(UpdateEvaluationFormRequest $request, EvaluationForm $form): RedirectResponse
    {
        $form->update($request->validated());

        return redirect()->route('admin.forms.show', $form)
            ->with('success', 'Form evaluasi berhasil diperbarui.');
    }

    public function destroy(EvaluationForm $form): RedirectResponse
    {
        if ($form->responses()->exists() || $form->questions()->exists()) {
            return redirect()->route('admin.forms.index')
                ->with('error', 'Form tidak dapat dihapus karena masih memiliki pertanyaan atau respons.');
        }

        $form->delete();

        return redirect()->route('admin.forms.index')
            ->with('success', 'Form evaluasi berhasil dihapus.');
    }
}
