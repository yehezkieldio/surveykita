<?php

use App\Services\NimParser;
use App\Services\StudentProfileFormatter;
use Illuminate\Support\Carbon;

test('it normalizes Google display names from student accounts', function () {
    $formatter = new StudentProfileFormatter;

    expect($formatter->googleName('2311032 BUDI SANTOSO WIJAYA', '2311032@students.universitasmulia.ac.id'))
        ->toBe('Budi Santoso Wijaya');
});

test('it formats class names without separators using current semester', function () {
    Carbon::setTestNow('2026-06-01');

    $parsedNim = (new NimParser)->parse('2311032');
    $formatter = new StudentProfileFormatter;

    expect($formatter->className('IFB6A', $parsedNim))->toBe('IFB6A')
        ->and($formatter->className('IFB-23-A', $parsedNim))->toBe('IFB6A')
        ->and($formatter->className('IF-23A', $parsedNim))->toBe('IF6A')
        ->and($formatter->semesterForAdmissionYear(2023))->toBe(6);

    Carbon::setTestNow();
});
