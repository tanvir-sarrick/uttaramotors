<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\BarCodeController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qrcode', function () {
    return QrCode::size(300)->generate('A basic example of QR code!');
});


Route::get('/qrcode-email', function() {
     return QrCode::size(500)
                 ->email('hardik@itsolutionstuff.com', 'Welcome to ItSolutionStuff.com!', 'This is !.');
 });



// Single Qr Code
 Route::get('singleqrcode-pdf', [PDFController::class, 'singleqecodePDF']);

// Multiple QRCode
 Route::get('multipleqrcode-pdf', [PDFController::class, 'multipleqrcodePDF']);

// Single Barcode
Route::get('/generate-qr', [BarCodeController::class, 'singleBarCode']);


Route::get('barcode', function () {

    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
    $image = $generatorPNG->getBarcode('www.globalinformatics.com.bd/', $generatorPNG::TYPE_CODE_128);

    return response($image)->header('Content-type','image/png');
});
