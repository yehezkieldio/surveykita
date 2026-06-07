<?php

namespace App\Services;

use Illuminate\Support\Str;

class StudentProfileFormatter
{
    /**
     * @var array<string, string>
     */
    private const PROGRAM_ABBREVIATIONS = [
        '11' => 'IF',
        '12' => 'TI',
        '13' => 'SI',
        '15' => 'DKV',
        '21' => 'AK',
        '22' => 'MN',
        '31' => 'HK',
        '32' => 'PGPAUD',
        '33' => 'FA',
        '41' => 'SI',
        '51' => 'TI',
        '52' => 'TS',
        '53' => 'TP',
    ];

    public function googleName(string $name, string $email): string
    {
        $withoutNim = preg_replace('/^\s*\d{7}\s+/', '', $name) ?? $name;
        $normalized = trim(preg_replace('/\s+/', ' ', $withoutNim) ?? $withoutNim);

        if ($normalized === '') {
            $normalized = Str::before($email, '@');
        }

        return Str::title(Str::lower($normalized));
    }

    public function googleNim(string $name, string $email): ?string
    {
        if (preg_match('/\b(\d{7})\b/', $name, $matches) === 1) {
            return $matches[1];
        }

        $localPart = Str::before($email, '@');

        if (preg_match('/\b(\d{7})\b/', $localPart, $matches) === 1) {
            return $matches[1];
        }

        return null;
    }

    /**
     * @param  array{nim: string, enrollment_year: int, program_code: string, study_program: string, sequence_number: string}  $parsedNim
     */
    public function className(string $className, array $parsedNim): string
    {
        $program = self::PROGRAM_ABBREVIATIONS[$parsedNim['program_code']] ?? $parsedNim['program_code'];
        $semester = $this->semesterForAdmissionYear($parsedNim['enrollment_year']);
        $normalized = Str::upper(preg_replace('/[^A-Za-z0-9]/', '', $className) ?? '');
        $normalized = Str::after($normalized, $program);
        $normalized = preg_replace('/'.preg_quote((string) $parsedNim['enrollment_year'], '/').'/', '', $normalized, 1) ?? $normalized;
        $normalized = preg_replace('/'.preg_quote(substr((string) $parsedNim['enrollment_year'], -2), '/').'/', '', $normalized, 1) ?? $normalized;
        $normalized = preg_replace('/'.preg_quote((string) $semester, '/').'/', '', $normalized, 1) ?? $normalized;
        
        // Remove 'B' if it was already there to avoid double B
        $normalized = Str::after($normalized, 'B');
        
        $suffix = preg_replace('/[^A-Z]/', '', $normalized) ?: 'A';

        return $program . 'B' . $semester . $suffix;
    }

    public function semesterForAdmissionYear(int $admissionYear): int
    {
        $today = now();
        $semester = (($today->year - $admissionYear) * 2) + ($today->month >= 8 ? 1 : 0);

        return max(1, $semester);
    }
}
