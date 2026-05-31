<?php

use App\Services\NimParser;

test('it parses Universitas Mulia NIM details', function () {
    $result = (new NimParser)->parse('2311032');

    expect($result)->toMatchArray([
        'nim' => '2311032',
        'enrollment_year' => 2023,
        'program_code' => '11',
        'study_program' => 'S1 Informatika',
        'sequence_number' => '032',
    ]);
});

test('it maps every configured program code', function (string $programCode, string $studyProgram) {
    $result = (new NimParser)->parse('23'.$programCode.'001');

    expect($result['program_code'])->toBe($programCode)
        ->and($result['study_program'])->toBe($studyProgram)
        ->and($result['sequence_number'])->toBe('001')
        ->and($result['enrollment_year'])->toBe(2023);
})->with([
    'S1 Informatika' => ['11', 'S1 Informatika'],
    'S1 Teknologi Informasi' => ['12', 'S1 Teknologi Informasi'],
    'S1 Sistem Informasi' => ['13', 'S1 Sistem Informasi'],
    'S1 Desain Komunikasi Visual' => ['15', 'S1 Desain Komunikasi Visual'],
    'S1 Akuntansi' => ['21', 'S1 Akuntansi'],
    'S1 Manajemen' => ['22', 'S1 Manajemen'],
    'S1 Hukum' => ['31', 'S1 Hukum'],
    'S1 PG PAUD' => ['32', 'S1 Pendidikan Guru Anak Usia Dini / PG PAUD'],
    'S1 Farmasi' => ['33', 'S1 Farmasi'],
    'S1 Sistem Informasi PSDKU' => ['41', 'S1 Sistem Informasi, Kampus Kota Samarinda / PSDKU'],
    'S1 Teknik Industri' => ['51', 'S1 Teknik Industri'],
    'S1 Teknik Sipil' => ['52', 'S1 Teknik Sipil'],
    'S1 Teknologi Pangan' => ['53', 'S1 Teknologi Pangan dan Hasil Pertanian'],
]);

test('it rejects malformed NIM values', function (string $nim) {
    expect(fn () => (new NimParser)->parse($nim))->toThrow(InvalidArgumentException::class);
})->with([
    'empty' => [''],
    'too short' => ['231103'],
    'too long' => ['23110321'],
    'contains letters' => ['23AA032'],
    'contains spaces' => ['231 032'],
]);

test('it rejects unknown program codes', function () {
    expect(fn () => (new NimParser)->parse('2399001'))->toThrow(InvalidArgumentException::class);
});
