<?php

namespace App\Http\Controllers;

use PDF;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PDFController extends Controller
{
    public function singleqecodePDF()
    {
        // Generate the QR code image
        $qrCode = QrCode::size(70)->generate('https://globalinformatics.com.bd/');

        // Pass the QR code to the view
        $data = [
            'title' => 'Welcome to Global Informatics Limited.',
            'date' => date('m/d/Y'),
            'qrCode' => $qrCode
        ];
        // Load the Blade view
        $pdfView = View::make('singleqecodePDF', $data);
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




    public function multipleqrcodePDF()
    {
        // Fetch data from the API
        $response = Http::get('https://jsonplaceholder.typicode.com/posts?_limit=10');
        $data = $response->json();

        // Initialize an array to store QR code image data
        $qrCodes = [];

        // Generate QR codes for each data entry
        foreach ($data as $entry) {
            // Generate the QR code image
            $qrCode = QrCode::size(70)->generate($entry['title']);

            // Store QR code image data in the array
            $qrCodes[] = [
                'id' => $entry['id'],
                'title' => $entry['title'],
                'qrCode' => $qrCode,
            ];
        }

        // Pass the QR codes data to the Blade view
        $viewData['qrCodes'] = $qrCodes;

        // Render the Blade view to generate the HTML content
        $html = view('multipleqrcodePDF', $viewData)->render();

        // Initialize Dompdf
        $dompdf = new Dompdf();

        // Load HTML content
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper([0, 0, 165, 300], 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF
        return response($dompdf->output())->header('Content-Type', 'application/pdf');
    }

}
