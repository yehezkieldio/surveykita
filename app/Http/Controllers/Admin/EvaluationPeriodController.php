<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEvaluationPeriodRequest;
use App\Http\Requests\Admin\UpdateEvaluationPeriodRequest;
use App\Models\EvaluationPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class EvaluationPeriodController extends Controller
{
    public function index(): View
    {
        return view('admin.periods.index');
    }

    public function data(): JsonResponse
    {
        return DataTables::eloquent(
            EvaluationPeriod::query()
                ->withCount('evaluationForms')
        )
            ->editColumn('start_date', fn (EvaluationPeriod $period): string => $period->start_date->translatedFormat('d M Y'))
            ->editColumn('end_date', fn (EvaluationPeriod $period): string => $period->end_date->translatedFormat('d M Y'))
            ->addColumn('actions', fn (EvaluationPeriod $period): string => 
                view('admin.periods.partials.actions', ['period' => $period])->render()
            )
            ->rawColumns(['actions'])
            ->toJson();
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
