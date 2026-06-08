<?php

use App\Services\NimParser;
use App\Services\StudentProfileFormatter;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('builds the guessed class name from parsed nim data', function () {
    $parsed = app(NimParser::class)->parse('2311032');

    expect(app(StudentProfileFormatter::class)->guessedClassName($parsed))->toBe('IFB6A');
});
