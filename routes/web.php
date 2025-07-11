<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDFController;
use App\Http\Controllers\BarCodeController;

use App\Http\Controllers\ProfileController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Backend\DealerController;
use App\Http\Controllers\Backend\InvoiceController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\InvoicePrintController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.home.index');
    }
    // return view('backend.auth.login');
    return redirect()->route('login');
});


// =========================== //

Route::get('/qrcode', function () {
    return QrCode::size(300)->generate('A basic example of QR code!');
});

Route::get('/qrcode-email', function () {
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

// ========================================== //

Route::prefix('Dashboard')->name('dashboard.')->middleware('auth', 'verified')->group(function () {
    // Home
    Route::prefix('/Home')->name('home.')->controller(DashboardController::class)->group(
        function () {
            Route::get('/', 'index')->name('index');
        }
    );

    //Role Controller
    Route::prefix('/Role')->controller(RoleController::class)->name('role.')->group(function () {
        Route::get('/Index', 'index')->name('index');
        Route::get('/Create', 'create')->name('create');
        Route::post('/Store', 'store')->name('store');
        Route::get('/{id}/Edit', 'edit')->name('edit');
        Route::post('/{id}/Update', 'update')->name('update');
        Route::post('/{id}/Delete', 'destroy')->name('destroy');
        Route::post('/loadMoreRole', 'loadMoreRole')->name('loadMoreRole');
    });

    //Permission Controller
    Route::prefix('/Permission')->controller(PermissionController::class)->name('permission.')->group(function () {
        Route::get('/Index', 'index')->name('index');
        Route::get('/Create', 'create')->name('create');
        Route::post('/Store', 'store')->name('store');
        Route::get('/{id}/Edit', 'edit')->name('edit');
        Route::post('/{id}/Update', 'update')->name('update');
        Route::get('/{id}/Delete', 'destroy')->name('destroy');
        Route::post('/loadMorePermission', 'loadMorePermission')->name('loadMorePermission');
    });

    // User Route
    Route::prefix('/User')->controller(UserController::class)->name('user.')->group(function () {
        Route::get('/Index', 'index')->name('index');
        Route::get('/Create', 'create')->name('create');
        Route::post('/Store', 'store')->name('store');
        Route::get('/{id}/Edit', 'edit')->name('edit');
        Route::post('/{id}/Update', 'update')->name('update');
        Route::get('/{id}/Delete', 'destroy')->name('softdelete');
        Route::post('/loadMoreUser', 'loadMoreUser')->name('loadMoreUser');
        Route::post('/filterUserData', 'filterUserData')->name('filterUserData');
    });

    //Invoice Route
    Route::prefix('/Invoice')->controller(InvoiceController::class)->name('invoice.')->group(function () {
        Route::get('/Index', 'index')->name('index');
        Route::post('/loadMoreData', 'loadMoreData')->name('loadMoreData');
        Route::post('/filterData', 'filterData')->name('filterData');
        Route::get('/Import', 'import_index')->name('import_index');
        Route::post('/Invoices-import', 'import')->name('import');
        Route::post('/Clear', 'clear')->name('clear');
        Route::post('/Delete', 'delete')->name('delete');
    });

    //Invoice Print Route
    Route::prefix('/Invoice')->controller(InvoicePrintController::class)->name('invoicePrint.')->group(function () {
        Route::get('/Print', 'print')->name('print');
    });

    // Dealer Route
    Route::prefix('/Dealer')->controller(DealerController::class)->name('dealer.')->group(function () {
        Route::get('/Index', 'index')->name('index');
        Route::get('/Create', 'create')->name('create');
        Route::post('/Store', 'store')->name('store');
        Route::get('/{id}/Edit', 'edit')->name('edit');
        Route::post('/{id}/Update', 'update')->name('update');
        Route::get('/{id}/Delete', 'destroy')->name('softdelete');
        Route::post('/loadMoreDealer', 'loadMoreDealer')->name('loadMoreDealer');
        Route::post('/filterDealerData', 'filterDealerData')->name('filterDealerData');
    });

    //Profile Route
    Route::prefix('/Profile')->controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
    });

    Route::prefix('Password')->name('password.')->controller(PasswordController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/Reset', 'reset')->name('reset');
    });

});

require __DIR__ . '/auth.php';
