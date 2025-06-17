<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\BarCodeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Backend\DashboardController;

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
    if (Auth::check()) {
        return redirect()->route('dashboard.index'); // Adjust to your dashboard route
    }
    return view('backend.auth.login');
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

});


//Invoice Import
Route::get('invoices', [InvoiceController::class, 'manage']);
Route::post('invoices-import', [InvoiceController::class, 'import'])->name('invoices.import');


Route::prefix('Dashboard/')->middleware('auth', 'verified')->group(function () {
    // Dashboard
    Route::prefix('Home/')->name('dashboard.')->controller(DashboardController::class)->group(
        function () {
            Route::get('/', 'index')->name('index');
        }
    );
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
