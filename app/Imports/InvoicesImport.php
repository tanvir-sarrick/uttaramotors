<?php

namespace App\Imports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class InvoicesImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    protected array $rows = [];
    protected string $invoiceNumber;
    protected string $userId;

    public function __construct(string $invoiceNumber, $userId)
    {
        $this->invoiceNumber    = $invoiceNumber;
        $this->userId           = $userId;
        // Preserve original header casing (no formatting)
        HeadingRowFormatter::default('none');
    }

    public static function beforeImport(BeforeImport $event)
    {
        // Optional: code before import starts
    }

    /**
     * Remove empty and summary ("total") rows before validation.
     */
    public function prepareForValidation($data, $index)
    {
        if ($this->shouldSkipRow($data)) {
            return []; // Empty array => row skipped by validator
        }

        $this->rows[$index] = $data; // Store for rules access
        return $data;
    }

    /**
     * Validation rules for each row.
     */
    public function rules(): array
    {
        return [
            '*.Brand' => function ($attribute, $value, $fail) {
                $row = $this->getRow($attribute);
                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Brand is required.');
                elseif (!is_string($value)) $fail('Brand must be a string.');
            },

            '*.Part Id' => function ($attribute, $value, $fail) {
                $row = $this->getRow($attribute);
                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Part ID is required.');
                elseif (!is_string($value)) $fail('Part ID must be a string.');
            },

            '*.Descripion' => function ($attribute, $value, $fail) {
                $row = $this->getRow($attribute);
                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Description is required.');
                elseif (!is_string($value)) $fail('Description must be a string.');
            },

            '*.Qty' => function ($attribute, $value, $fail) {
                $row = $this->getRow($attribute);
                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Qty is required.');
                elseif (!is_numeric($value) || intval($value) != $value) $fail('Qty must be an number.');
                elseif (intval($value) <= 0) $fail('Qty must be greater than 0.');
            },

            '*.Rate' => function ($attribute, $value, $fail) {
                $row = $this->getRow($attribute);
                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Rate is required.');
                elseif (!is_numeric($value)) $fail('Rate must be a number.');
                elseif (intval($value) <= 0) $fail('Rate must be greater than 0.');
            },

            '*.Amount' => function ($attribute, $value, $fail) {
                $row = $this->getRow($attribute);
                if ($this->shouldSkipRow($row)) return;

                if ($value === null || $value === '') $fail('Amount is required.');
                elseif (!is_numeric($value)) $fail('Amount must be a number.');
                elseif (intval($value) <= 0) $fail('Amount must be greater than 0.');
            },
        ];
    }

    /**
     * Helper to get row data by attribute index.
     */
    private function getRow(string $attribute): array
    {
        $index = explode('.', $attribute)[0] ?? null;
        return $this->rows[$index] ?? [];
    }

    /**
     * Skip row if empty or if it's a summary "Total" row.
     */
    private function shouldSkipRow(array $row): bool
    {
        return collect($row)->filter()->isEmpty() ||
            (isset($row['Sl. No.']) && strtolower(trim($row['Sl. No.'])) === 'total');
    }

    /**
     * This method runs only if validation passes for all rows.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($this->shouldSkipRow($row->toArray())) {
                continue;
            }

            Invoice::create([
                'sl_no'         => (int) $row['Sl. No.'],
                'invoice_number'=> $this->invoiceNumber,
                'user_id'       => $this->userId,
                'brand'         => (string) $row['Brand'],
                'part_id'       => (string) $row['Part Id'],
                'description'   => (string) $row['Descripion'],
                'qty'           => (int) $row['Qty'],
                'rate'          => (float) $row['Rate'],
                'amount'        => (float) $row['Amount'],
            ]);
        }
    }

    /**
     * Register import events (optional).
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => [self::class, 'beforeImport'],
        ];
    }
}
