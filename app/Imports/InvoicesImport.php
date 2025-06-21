<?php

namespace App\Imports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class InvoicesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows, WithEvents
{
    use SkipsFailures;

    protected $totalRows;
    protected $currentRow = 0;

    public function __construct()
    {
        HeadingRowFormatter::default('none'); // Match exact Excel headers
    }

    public static function beforeImport(BeforeImport $event)
    {
        // Get total rows from the sheet
        $instance = $event->getConcernable();
        $instance->totalRows = $event->getReader()->getDelegate()->getActiveSheet()->getHighestRow();
    }

    // public function model(array $row)
    // {
    //     $this->currentRow++;

    //     // Skip last row
    //     if ($this->currentRow >= $this->totalRows) {
    //         return null;
    //     }

    //     return new Invoice([
    //         'sl_no'       => (int) $row['Sl. No.'],
    //         'brand'       => (string) $row['Brand'],
    //         'part_id'     => (string) $row['Part Id'],
    //         'description' => (string) $row['Descripion'], // typo matches Excel header
    //         'qty'         => (int) $row['Qty'],
    //         'rate'        => (float) $row['Rate'],
    //         'amount'      => (float) $row['Amount'],
    //     ]);
    // }

    public function model(array $row)
    {
        // Skip if all cells are blank
        if (collect($row)->filter()->isEmpty()) {
            return null;
        }

        // Skip known footer/summary row: e.g., if Part Id or Qty is missing
        // Skip row if any known footer pattern is detected
        if (
            strtolower(trim($row['Sl. No.'])) === 'total'
        ) {
            return null;
        }

        return new Invoice([
            'sl_no'       => (int) $row['Sl. No.'],
            'brand'       => (string) $row['Brand'],
            'part_id'     => (string) $row['Part Id'],
            'description' => (string) $row['Descripion'], // typo matches Excel
            'qty'         => (int) $row['Qty'],
            'rate'        => (float) $row['Rate'],
            'amount'      => (float) $row['Amount'],
        ]);
    }


    public function rules(): array
    {
        return [
            '*.Brand'       => 'required|string|max:255',
            '*.Part Id'     => 'required|string|max:255',
            '*.Descripion'  => 'nullable|string',
            '*.Qty'         => 'required|integer|min:1',
            '*.Rate'        => 'required|numeric|min:0',
            '*.Amount'      => 'required|numeric|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.Brand.required'       => 'Brand is required.',
            '*.Part Id.required'     => 'Part ID is required.',
            '*.Qty.required'         => 'Quantity is required and must be greater than 0.',
            '*.Rate.required'        => 'Rate is required and must be a number.',
            '*.Amount.required'      => 'Amount is required and must be a number.',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => [self::class, 'beforeImport'],
        ];
    }
}
