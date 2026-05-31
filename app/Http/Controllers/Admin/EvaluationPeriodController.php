<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEvaluationPeriodRequest;
use App\Http\Requests\Admin\UpdateEvaluationPeriodRequest;
use App\Models\EvaluationPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EvaluationPeriodController extends Controller
{
    public function index(): View
    {
        return view('admin.periods.index', [
            'periods' => EvaluationPeriod::query()
                ->withCount('evaluationForms')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.periods.create');
    }

    public function store(StoreEvaluationPeriodRequest $request): RedirectResponse
    {
        $period = EvaluationPeriod::query()->create($request->validated());

        return redirect()->route('admin.periods.show', $period)
            ->with('success', 'Periode evaluasi berhasil dibuat.');
    }

    public function show(EvaluationPeriod $period): View
    {
        return view('admin.periods.show', [
            'period' => $period->loadCount('evaluationForms'),
        ]);
    }

    public function edit(EvaluationPeriod $period): View
    {
        return view('admin.periods.edit', ['period' => $period]);
    }

    public function update(UpdateEvaluationPeriodRequest $request, EvaluationPeriod $period): RedirectResponse
    {
        $period->update($request->validated());

        return redirect()->route('admin.periods.show', $period)
            ->with('success', 'Periode evaluasi berhasil diperbarui.');
    }

    public function destroy(EvaluationPeriod $period): RedirectResponse
    {
        if ($period->evaluationForms()->exists()) {
            return redirect()->route('admin.periods.index')
                ->with('error', 'Periode tidak dapat dihapus karena masih memiliki form evaluasi.');
        }

        $period->delete();

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode evaluasi berhasil dihapus.');
    }
}
