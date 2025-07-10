<?php

namespace App\Http\Controllers\Backend;

// use Dompdf\Dompdf;
use Mpdf\Mpdf;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoicePrintController extends Controller
{
    // public function printBasic(Request $request)
    // {
    //     $items = Invoice::where('invoice_number', $request->invoice_number)->get();


    //     $expandedItems = collect();

    //     foreach ($items as $item) {
    //         for ($i = 0; $i < $item->qty; $i++) {
    //             $clone = clone $item;
    //             $clone->qty = 1;
    //             $clone->amount = $item->rate;
    //             $expandedItems->push($clone);
    //         }
    //     }


    //     // Generate the QR code image
    //     $qrCode = QrCode::size(70)->generate('https://globalinformatics.com.bd/');

    //     // Pass the QR code to the view
    //     $data = [
    //         'title' => 'Welcome to Global Informatics Limited.',
    //         'date' => date('m/d/Y'),
    //         'qrCode' => $qrCode,
    //         'items' => $expandedItems,
    //     ];
    //     // Load the Blade view
    //     $pdfView = View::make('backend.pages.sticker.print', $data);
    //     // Initialize Dompdf
    //     $dompdf = new Dompdf();

    //     //$dompdf->loadHtml($html);
    //     $dompdf->loadHtml($pdfView->render());



    //     // (Optional) Set the paper size and orientation
    //     //$dompdf->setPaper('A4', 'portrait');
    //     // Set paper size and orientation
    //     $dompdf->setPaper(array(0, 0, 150, 270), 'landscape');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     // Output the generated PDF
    //     //return $dompdf->stream("example.pdf");
    //     return response($dompdf->output())->header('Content-Type', 'application/pdf');
    // }

    // public function printDOMPDF(Request $request)
    // {
    //     $items = Invoice::where('invoice_number', $request->invoice_number)->get();

    //     $expandedItems = collect();

    //     foreach ($items as $item) {
    //         for ($i = 0; $i < $item->qty; $i++) {
    //             $clone = clone $item;
    //             $clone->qty = 1;
    //             $clone->amount = $item->rate;
    //             $expandedItems->push($clone);
    //         }
    //     }

    //     // Generate QR Code
    //     $qrCode = QrCode::size(70)->generate('https://globalinformatics.com.bd/');

    //     $data = [
    //         'title' => 'Welcome to Global Informatics Limited.',
    //         'date' => now()->format('m/d/Y'),
    //         'qrCode' => $qrCode,
    //         'items' => $expandedItems,
    //     ];

    //     // Load Blade view as HTML
    //     $pdfView = View::make('backend.pages.sticker.print', $data);

    //     // Initialize Dompdf
    //     $dompdf = new Dompdf();
    //     $dompdf->loadHtml($pdfView->render());
    //     $dompdf->setPaper([0, 0, 150, 270], 'landscape');
    //     $dompdf->render();

    //     $pdfOutput = $dompdf->output();
    //     $filename = 'sticker-' . $request->invoice_number . '.pdf';

    //     // If download=1 exists in the query, force download
    //     if ($request->has('download')) {
    //         return response($pdfOutput)
    //             ->header('Content-Type', 'application/pdf')
    //             ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    //     }

    //     // Default behavior: open in browser
    //     return response($pdfOutput)
    //         ->header('Content-Type', 'application/pdf')
    //         ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    // }

    public function printSnappy(Request $request)
    {
        $items = Invoice::where('invoice_number', $request->invoice_number)->get();

        $expandedItems = collect();

        foreach ($items as $item) {
            for ($i = 0; $i < $item->qty; $i++) {
                $clone = clone $item;
                $clone->qty = 1;
                $clone->amount = $item->rate;
                $expandedItems->push($clone);
            }
        }

        // Generate QR Code (you can keep your existing code)
        $qrContent = QrCode::format('svg')->size(70)->generate('https://globalinformatics.com.bd/');
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrContent);

        $data = [
            'title' => 'Welcome to Global Informatics Limited.',
            'date' => date('m/d/Y'),
            'qrCode' => $qrCode,
            'items' => $expandedItems,
        ];

        $filename = 'sticker-' . $request->invoice_number . '.pdf';

        $pdf = PDF::loadView('backend.pages.sticker.print', $data)
            ->setOption('orientation', 'landscape')
            ->setOption('page-width', '150pt')
            ->setOption('page-height', '270pt')
            ->setOption('margin-top', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0);

        if ($request->has('download')) {
            // Force download
            return $pdf->download($filename);
        }

        // Stream in browser (print preview)
        return $pdf->stream($filename);
    }

    public function print(Request $request)
    {
        // Just this one line is enough in most cases:
        ini_set('pcre.backtrack_limit', '10000000');

        $items = Invoice::where('invoice_number', $request->invoice_number)->get();

        $expandedItems = collect();

        foreach ($items as $item) {
            for ($i = 0; $i < $item->qty; $i++) {
                $clone = clone $item;
                $clone->qty = 1;
                $clone->amount = $item->rate;
                $expandedItems->push($clone);
            }
        }

        // Generate QR code
        $qrContent = QrCode::format('svg')->size(70)->generate('https://globalinformatics.com.bd/');
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrContent);

        $data = [
            'title' => 'Welcome to Global Informatics Limited.',
            'date' => date('m/d/Y'),
            'qrCode' => $qrCode,
            'items' => $expandedItems,
        ];

        $filename = 'sticker-' . $request->invoice_number . '.pdf';

        // Render Blade view into HTML
        $html = view('backend.pages.sticker.print', $data)->render();

        // Convert dimensions from points to mm (1pt = 0.3528mm)
        $pageWidth = 135 * 0.3528; // ~52.92mm
        $pageHeight = 235 * 0.3528; // ~95.26mm

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [$pageWidth, $pageHeight],
            'orientation' => 'L', // Landscape
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);

        // Single large WriteHTML call — no splitting
        $mpdf->WriteHTML($html);

        if ($request->has('download')) {
            return response($mpdf->Output($filename, 'S'))
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=\"$filename\"");
        }

        return response($mpdf->Output($filename, 'I'))
            ->header('Content-Type', 'application/pdf');
    }

}
