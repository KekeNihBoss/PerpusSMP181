<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateExport implements FromArray, WithHeadings
{
    protected array $headers;

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function array(): array
    {
        return [];
    }
}
