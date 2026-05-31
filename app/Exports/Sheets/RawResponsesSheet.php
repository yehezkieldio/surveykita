<?php

namespace App\Exports\Sheets;

use App\Models\EvaluationForm;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class RawResponsesSheet implements FromArray, WithTitle
{
    public function __construct(private readonly EvaluationForm $form) {}

    public function array(): array
    {
        $rows = [
            ['Response ID', 'Mahasiswa', 'NIM', 'Waktu Submit', 'Pertanyaan', 'Kategori', 'Skor', 'Saran / Komentar'],
        ];

        $this->form->responses()
            ->with(['student', 'answers.question.category'])
            ->orderBy('submitted_at')
            ->get()
            ->each(function (Response $response) use (&$rows): void {
                $response->answers
                    ->sortBy(fn (ResponseAnswer $answer): int => $answer->question->sort_order)
                    ->each(function (ResponseAnswer $answer) use ($response, &$rows): void {
                        $rows[] = [
                            $response->id,
                            $response->student?->name,
                            $response->student?->nim,
                            $response->submitted_at?->format('Y-m-d H:i:s'),
                            $answer->question->question_text,
                            $answer->question->category?->name,
                            $answer->score,
                            $response->suggestion,
                        ];
                    });
            });

        return $rows;
    }

    public function title(): string
    {
        return 'Respons Mentah';
    }
}
