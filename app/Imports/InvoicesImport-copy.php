<?php

namespace App\Imports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class InvoicesImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    SkipsEmptyRows,
    WithEvents
{
    use SkipsFailures;

    protected Collection $cleanRows;

    public function __construct()
    {
        HeadingRowFormatter::default('none'); // keep original Excel header casing
        $this->cleanRows = collect();
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $sheet = $event->getReader()->getDelegate()->getActiveSheet();
                $highestRow = $sheet->getHighestDataRow();
                $highestCol = $sheet->getHighestDataColumn();

                $headers = $sheet->rangeToArray("A1:{$highestCol}1")[0];
                $data = $sheet->rangeToArray("A2:{$highestCol}{$highestRow}", null, true, true, true);

                $rows = collect($data)->map(function ($row) use ($headers) {
                    $mapped = [];
                    $i = 0;
                    foreach ($headers as $header) {
                        $mapped[$header] = $row[array_keys($row)[$i]] ?? null;
                        $i++;
                    }
                    return $mapped;
                });

                // Filter out "Total" rows and blank rows
                $this->cleanRows = $rows->filter(function ($row) {
                    $sl = strtolower(trim($row['Sl. No.'] ?? ''));
                    return $sl !== 'total' && collect($row)->filter()->isNotEmpty();
                })->values();
            },
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($this->cleanRows as $row) {
            Invoice::create([
                'sl_no'       => (int) $row['Sl. No.'],
                'brand'       => trim($row['Brand']),
                'part_id'     => trim($row['Part Id']),
                'description' => trim($row['Descripion']),
                'qty'         => (int) $row['Qty'],
                'rate'        => (float) $row['Rate'],
                'amount'      => (float) $row['Amount'],
            ]);
        }
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
            '*.Qty.required'         => 'Qty is required and must be a positive number.',
            '*.Rate.required'        => 'Rate must be a valid number.',
            '*.Amount.required'      => 'Amount must be a valid number.',
        ];
    }
}
