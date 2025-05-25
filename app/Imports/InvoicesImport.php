<?php

namespace App\Imports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class InvoicesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct()
    {
        HeadingRowFormatter::default('none'); // ⚠️ Use headers exactly as in Excel
    }

    public function model(array $row)
    {
        // dd($row);
        return new Invoice([
            // 'sl_no'      => (int) $row[0],
            // 'brand'      => $row[1],
            // 'part_id'    => $row[2],
            // 'description'=> $row[3], // typo in original header!
            // 'qty'        => (int) $row[4],
            // 'rate'       => (float) $row[5],
            // 'amount'     => (float) $row[6],


            'sl_no'       => (int) $row['Sl. No.'],
            'brand'       => (string) $row['Brand'],
            'part_id'     => (string) $row['Part Id'],
            'description' => (string) $row['Descripion'], // typo matches Excel header
            'qty'         => (int) $row['Qty'],
            'rate'        => (float) $row['Rate'],
            'amount'      => (float) $row['Amount'],
        ]);
    }

    //old
    // public function rules(): array
    // {
    //     return [
    //         '*.sl_no'       => 'required|string',
    //         '*.brand'       => 'required|string|max:255',
    //         '*.part_id'     => 'required|string|max:255',
    //         '*.descripion'  => 'nullable|string',
    //         '*.qty'         => 'required|integer|min:1',
    //         '*.rate'        => 'required|numeric|min:0',
    //         '*.amount'      => 'required|numeric|min:0',
    //     ];
    // }
    public function rules(): array
    {
        return [
            // '*.Sl. No.'     => 'required|integer',
            '*.Brand'       => 'required|string|max:255',
            '*.Part Id'     => 'required|string|max:255',
            '*.Descripion'  => 'nullable|string',
            '*.Qty'         => 'required|integer|min:1',
            '*.Rate'        => 'required|numeric|min:0',
            '*.Amount'      => 'required|numeric|min:0',
        ];
    }


    //old
    // public function customValidationMessages()
    // {
    //     return [
    //         '*.sl_no.required'      => 'Sl. No. is required.',
    //         '*.brand.required'      => 'Brand is required.',
    //         '*.part_id.required'    => 'Part Id is required.',
    //         '*.qty.required'        => 'Quantity is required and must be greater than 0.',
    //         '*.rate.required'       => 'Rate is required and must be a number.',
    //         '*.amount.required'     => 'Amount is required and must be a number.',
    //     ];
    // }
    public function customValidationMessages()
    {
        return [
            '*.Sl. No..required'     => 'Sl. No. is required.',
            '*.Brand.required'       => 'Brand is required.',
            '*.Part Id.required'     => 'Part ID is required.',
            '*.Qty.required'         => 'Quantity is required and must be greater than 0.',
            '*.Rate.required'        => 'Rate is required and must be a number.',
            '*.Amount.required'      => 'Amount is required and must be a number.',
        ];
    }

}
