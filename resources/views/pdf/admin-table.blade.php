<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        @page { margin: 1.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; line-height: 1.5; color: #18181b; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #18181b; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { margin: 6px 0 0 0; color: #52525b; }
        .meta { margin-top: 8px; font-size: 10px; color: #71717a; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f4f4f5; border: 1px solid #d4d4d8; padding: 8px 10px; text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: 0.08em; }
        td { border: 1px solid #e4e4e7; padding: 8px 10px; vertical-align: top; }
        tbody tr:nth-child(even) { background-color: #fafafa; }
        .empty { padding: 24px; text-align: center; color: #71717a; border: 1px solid #e4e4e7; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">{{ $title }}</h1>
        <p class="subtitle">{{ $subtitle }}</p>
        <div class="meta">Waktu cetak: {{ $generatedAt->translatedFormat('d F Y, H:i') }}</div>
    </div>

    @if (count($rows) === 0)
        <div class="empty">Tidak ada data untuk diekspor.</div>
    @else
        <table>
            <thead>
                <tr>
                    @foreach ($headings as $heading)
                        <th>{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        @foreach ($row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
