<?php

namespace App\Services;

use InvalidArgumentException;

class NimParser
{
    /**
     * @var array<string, string>
     */
    public const PROGRAMS = [
        '11' => 'S1 Informatika',
        '12' => 'S1 Teknologi Informasi',
        '13' => 'S1 Sistem Informasi',
        '15' => 'S1 Desain Komunikasi Visual',
        '21' => 'S1 Akuntansi',
        '22' => 'S1 Manajemen',
        '31' => 'S1 Hukum',
        '32' => 'S1 Pendidikan Guru Anak Usia Dini / PG PAUD',
        '33' => 'S1 Farmasi',
        '41' => 'S1 Sistem Informasi, Kampus Kota Samarinda / PSDKU',
        '51' => 'S1 Teknik Industri',
        '52' => 'S1 Teknik Sipil',
        '53' => 'S1 Teknologi Pangan dan Hasil Pertanian',
    ];

    /**
     * @return array{nim: string, enrollment_year: int, program_code: string, study_program: string, sequence_number: string}
     */
    public function parse(string $nim): array
    {
        if (! preg_match('/^\d{7}$/', $nim)) {
            throw new InvalidArgumentException('NIM harus terdiri dari 7 digit angka.');
        }

        $programCode = substr($nim, 2, 2);

        if (! array_key_exists($programCode, self::PROGRAMS)) {
            throw new InvalidArgumentException('Kode program studi pada NIM tidak dikenal.');
        }

        return [
            'nim' => $nim,
            'enrollment_year' => 2000 + (int) substr($nim, 0, 2),
            'program_code' => $programCode,
            'study_program' => self::PROGRAMS[$programCode],
            'sequence_number' => substr($nim, 4, 3),
        ];
    }
}
