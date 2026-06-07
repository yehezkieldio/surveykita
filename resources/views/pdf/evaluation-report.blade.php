<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Hasil Evaluasi - {{ $form->title }}</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; line-height: 1.5; color: #18181b; }
        .header { margin-bottom: 30px; border-bottom: 2px solid #18181b; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .subtitle { font-size: 14px; color: #71717a; margin: 5px 0 0 0; }
        .meta { margin-bottom: 20px; }
        .meta-item { margin-bottom: 5px; }
        .meta-label { font-weight: bold; width: 120px; display: inline-block; }
        
        .section-title { font-size: 14px; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #e4e4e7; padding-bottom: 5px; margin: 25px 0 15px 0; color: #71717a; }
        
        .summary-grid { margin-bottom: 20px; width: 100%; }
        .summary-box { border: 1px solid #e4e4e7; padding: 15px; text-align: center; }
        .summary-value { font-size: 18px; font-weight: bold; display: block; }
        .summary-label { font-size: 10px; text-transform: uppercase; color: #71717a; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f4f4f5; text-align: left; padding: 8px 12px; font-size: 10px; text-transform: uppercase; border: 1px solid #e4e4e7; }
        td { padding: 8px 12px; border: 1px solid #e4e4e7; vertical-align: top; }
        
        .badge { display: inline-block; padding: 2px 8px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .badge-teal { background-color: #f0fdfa; color: #0f766e; }
        .badge-zinc { background-color: #f4f4f5; color: #3f3f46; }
        
        .suggestion-item { margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #e4e4e7; }
        .suggestion-student { font-size: 10px; font-weight: bold; color: #71717a; }
        .suggestion-text { font-style: italic; margin-top: 5px; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #a1a1aa; border-top: 1px solid #e4e4e7; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">SurveyKita</h1>
        <p class="subtitle">Laporan Hasil Evaluasi & Penjaminan Mutu</p>
    </div>

    <div class="meta">
        <div class="meta-item"><span class="meta-label">Formulir:</span> {{ $form->title }}</div>
        <div class="meta-item"><span class="meta-label">Periode:</span> {{ $form->evaluationPeriod->name }}</div>
        <div class="meta-item"><span class="meta-label">Target:</span> {{ ucfirst(str_replace('_', ' ', $form->target_type)) }}</div>
        <div class="meta-item"><span class="meta-label">Waktu Cetak:</span> {{ now()->translatedFormat('d F Y, H:i') }}</div>
    </div>

    <div class="section-title">Ringkasan Eksekutif</div>
    <table class="summary-grid">
        <tr>
            <td class="summary-box">
                <span class="summary-value">{{ number_format($result['total_respondents']) }}</span>
                <span class="summary-label">Total Responden</span>
            </td>
            <td class="summary-box">
                <span class="summary-value">{{ number_format($result['average_score'], 2) }}</span>
                <span class="summary-label">Rata-rata Skor</span>
            </td>
            <td class="summary-box">
                <span class="summary-value">{{ number_format($result['satisfaction_percentage'], 1) }}%</span>
                <span class="summary-label">Persentase Kepuasan</span>
            </td>
            <td class="summary-box">
                <span class="summary-value">{{ $result['satisfaction_category'] }}</span>
                <span class="summary-label">Kategori</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Rekapitulasi Kategori</div>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Total Jawaban</th>
                <th>Rata-rata</th>
                <th>Persentase</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result['average_score_per_category'] as $cat)
                <tr>
                    <td style="font-weight: bold;">{{ $cat['category'] }}</td>
                    <td>{{ number_format($cat['total_answers']) }}</td>
                    <td style="font-weight: bold;">{{ number_format($cat['average_score'], 2) }}</td>
                    <td style="color: #0f766e; font-weight: bold;">{{ number_format($cat['satisfaction_percentage'], 1) }}%</td>
                    <td>{{ $cat['satisfaction_category'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always;"></div>

    <div class="section-title">Analisis Butir Pertanyaan</div>
    <table>
        <thead>
            <tr>
                <th style="width: 60%;">Pertanyaan</th>
                <th>Kategori</th>
                <th>Rerata</th>
                <th>Kepuasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result['average_score_per_question'] as $q)
                <tr>
                    <td>{{ $q['question_text'] }}</td>
                    <td style="font-size: 10px;">{{ $q['category'] }}</td>
                    <td style="font-weight: bold;">{{ number_format($q['average_score'], 2) }}</td>
                    <td style="color: #0f766e; font-weight: bold;">{{ number_format($q['satisfaction_percentage'], 1) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Saran & Masukan Mahasiswa</div>
    @if(empty($result['suggestions']))
        <p style="color: #a1a1aa; font-style: italic;">Belum ada saran yang diberikan.</p>
    @else
        @foreach ($result['suggestions'] as $suggestion)
            <div class="suggestion-item">
                <div class="suggestion-student">{{ $suggestion['student_name'] }} ({{ $suggestion['submitted_at']->translatedFormat('d/m/y') }})</div>
                <div class="suggestion-text">"{{ $suggestion['suggestion'] }}"</div>
            </div>
        @endforeach
    @endif

    <div class="footer">
        &copy; {{ date('Y') }} SurveyKita - Generated automatically.
    </div>
</body>
</html>
