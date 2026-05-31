<?php

namespace App\Exports\Sheets;

trait FormatsExportValues
{
    protected function exportValue(mixed $value): mixed
    {
        if ($value === 0 || $value === 0.0) {
            return '0';
        }

        return $value;
    }
}
