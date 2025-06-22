<?php

namespace App\Imports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class InvoicesImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows, WithEvents
{
    use SkipsFailures;

    protected array $rows = [];
    protected array $rawData = [];

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public static function beforeImport(BeforeImport $event)
    {
        //
    }

    public function prepareForValidation($data, $index)
    {
        $this->rows[$index] = $data;
        return $data;
    }

    public function rules(): array
    {
        return [

            '*.Brand' => function ($attribute, $value, $fail) {
                $row = $this->rows[explode('.', $attribute)[0]] ?? [];

                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Brand is required.');
                elseif (!is_string($value)) $fail('Brand must be a string.');
            },

            '*.Part Id' => function ($attribute, $value, $fail) {
                $row = $this->rows[explode('.', $attribute)[0]] ?? [];

                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Part ID is required.');
                elseif (!is_string($value)) $fail('Part ID must be a string.');
            },

            '*.Descripion' => function ($attribute, $value, $fail) {
                $row = $this->rows[explode('.', $attribute)[0]] ?? [];

                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Descripion is required.');
                elseif (!is_string($value)) $fail('Descripion must be a string.');
            },

            '*.Qty' => function ($attribute, $value, $fail) {
                $row = $this->rows[explode('.', $attribute)[0]] ?? [];

                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Qty is required.');
                elseif (!is_numeric($value) || intval($value) != $value) $fail('Qty must be an integer.');
                elseif (intval($value) <= 0) $fail('Qty must be greater than 0.');
            },

            '*.Rate' => function ($attribute, $value, $fail) {
                $row = $this->rows[explode('.', $attribute)[0]] ?? [];

                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Rate is required.');
                elseif (!is_numeric($value)) $fail('Rate must be a number.');
            },

            '*.Amount' => function ($attribute, $value, $fail) {
                $row = $this->rows[explode('.', $attribute)[0]] ?? [];

                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Amount is required.');
                elseif (!is_numeric($value)) $fail('Amount must be a number.');
            },
        ];
    }

    private function shouldSkipRow(array $row): bool
    {
        return collect($row)->filter()->isEmpty() ||
            (isset($row['Sl. No.']) && strtolower(trim($row['Sl. No.'])) === 'total');
    }



    public function collection(Collection $rows)
    {
        // Store raw data for later insertion after validation
        $this->rawData = $rows->toArray();

        // If there were failures, abort DB saving from outside the import
        if (!empty($this->failures())) {
            return;
        }

        foreach ($rows as $row) {
            if ($this->shouldSkipRow($row)) continue;

            Invoice::create([
                'sl_no'       => (int) $row['Sl. No.'],
                'brand'       => (string) $row['Brand'],
                'part_id'     => (string) $row['Part Id'],
                'description' => (string) $row['Descripion'],
                'qty'         => (int) $row['Qty'],
                'rate'        => (float) $row['Rate'],
                'amount'      => (float) $row['Amount'],
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => [self::class, 'beforeImport'],
        ];
    }
}
