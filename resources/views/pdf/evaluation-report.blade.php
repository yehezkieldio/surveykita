<!DOCTYPE html>
<html lang="id">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan {{ $form->title }}</title>
        <style>
            body {
                color: #18181b;
                font-family: DejaVu Sans, sans-serif;
                font-size: 12px;
                line-height: 1.45;
            }

            h1 {
                font-size: 22px;
                margin: 0 0 4px;
            }

            h2 {
                border-bottom: 1px solid #d4d4d8;
                font-size: 15px;
                margin: 24px 0 8px;
                padding-bottom: 4px;
            }

            table {
                border-collapse: collapse;
                margin-top: 8px;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #d4d4d8;
                padding: 7px;
                text-align: left;
                vertical-align: top;
            }

            th {
                background: #f4f4f5;
                font-weight: bold;
            }

            .muted {
                color: #52525b;
            }

            .summary {
                margin-top: 16px;
            }

            .summary td {
                width: 25%;
            }
        </style>
    </head>
    <body>
        <p class="muted">SurveyKita - Laporan Hasil Evaluasi Kepuasan Mahasiswa</p>
        <h1>{{ $form->title }}</h1>
        <p>
            Periode: {{ $form->evaluationPeriod->name }}
            ({{ $form->evaluationPeriod->semester }} {{ $form->evaluationPeriod->academic_year }})
        </p>

        <table class="summary">
            <tr>
                <th>Total Responden</th>
                <th>Rata-rata Skor</th>
                <th>Persentase Kepuasan</th>
                <th>Kategori Kepuasan</th>
            </tr>
            <tr>
                <td>{{ $result['total_respondents'] }}</td>
                <td>{{ $result['average_score'] }}</td>
                <td>{{ $result['satisfaction_percentage'] }}%</td>
                <td>{{ $result['satisfaction_category'] }}</td>
            </tr>
        </table>

        @if ($result['is_empty'])
            <p class="muted">Belum ada respons mahasiswa untuk form evaluasi ini.</p>
        @endif

        <h2>Rekap per Kategori</h2>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah Jawaban</th>
                    <th>Rata-rata Skor</th>
                    <th>Persentase</th>
                    <th>Kategori Kepuasan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($result['average_score_per_category'] as $row)
                    <tr>
                        <td>{{ $row['category'] }}</td>
                        <td>{{ $row['total_answers'] }}</td>
                        <td>{{ $row['average_score'] }}</td>
                        <td>{{ $row['satisfaction_percentage'] }}%</td>
                        <td>{{ $row['satisfaction_category'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada kategori pertanyaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h2>Rekap per Pertanyaan</h2>
        <table>
            <thead>
                <tr>
                    <th>Pertanyaan</th>
                    <th>Kategori</th>
                    <th>Jumlah Jawaban</th>
                    <th>Rata-rata Skor</th>
                    <th>Kategori Kepuasan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($result['average_score_per_question'] as $row)
                    <tr>
                        <td>{{ $row['question_text'] }}</td>
                        <td>{{ $row['category'] }}</td>
                        <td>{{ $row['total_answers'] }}</td>
                        <td>{{ $row['average_score'] }}</td>
                        <td>{{ $row['satisfaction_category'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada pertanyaan evaluasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h2>Saran Mahasiswa</h2>
        <table>
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Saran / Komentar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($result['suggestions'] as $suggestion)
                    <tr>
                        <td>{{ $suggestion['student_name'] }}</td>
                        <td>{{ $suggestion['suggestion'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Belum ada saran mahasiswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </body>
</html>
