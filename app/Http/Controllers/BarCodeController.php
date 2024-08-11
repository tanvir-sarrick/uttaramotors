<?php

namespace App\Http\Controllers;

use PDF;
use Dompdf\Dompdf;
use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BarCodeController extends Controller
{
    public function singleBarCode()
    {
        // Generate the QR code image
        $dns1d = new DNS1D();
        $barcode  = $dns1d->getBarcodePNG('https://globalinformatics.com.bd/', 'C128');

        // Pass the QR code to the view
        $data = [
            'title' => 'Welcome to Global Informatics Limited.',
            'date' => date('m/d/Y'),
            'barcode' => $barcode
        ];
        // Load the Blade view
        $pdfView = View::make('qrcode', $data);
        // Initialize Dompdf
        $dompdf = new Dompdf();

        //$dompdf->loadHtml($html);
        $dompdf->loadHtml($pdfView->render());



        // (Optional) Set the paper size and orientation
        //$dompdf->setPaper('A4', 'portrait');
        // Set paper size and orientation
        $dompdf->setPaper(array(0, 0, 150, 270), 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF
        //return $dompdf->stream("example.pdf");
        return response($dompdf->output())->header('Content-Type', 'application/pdf');
    }
}
