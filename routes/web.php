<?php

use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConvertController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('index');
});

$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);

        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth');
        }
    }
});

// Documentations pages
Route::prefix('documentation')->group(function () {
    Route::get('getting-started/references', [ReferencesController::class, 'index']);
    Route::get('getting-started/changelog', [PagesController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    
    Route::get('index', [PagesController::class, 'index']);

    Route::get('pembelian', [PembelianController::class, 'index'])->name('pembelian');
    Route::post('create-transaction', [PembelianController::class, 'transaction'])->name('create_transaction');
    Route::post('create-no-print-transaction', [PembelianController::class, 'transaction_no_print'])->name('create_no_print_transaction');
    Route::get('cetakstruk', [PembelianController::class, 'cetakstruk'])->name('cetak_struk');


    Route::get('pengiriman', [PengirimanController::class, 'index'])->name('pengiriman');
    Route::post('create-pengiriman', [PengirimanController::class, 'create'])->name('create_pengiriman');

    Route::post('add-to-cart', [CartController::class, 'AddToCart']);
    Route::post('delete-cart', [CartController::class, 'DeleteCart'])->name('deleteCart');
    Route::get('delete-all-cart', [CartController::class, 'DeleteAllCart'])->name('deleteAllCart');

    Route::get('product', [ProductController::class, 'index'])->name('product');
    Route::post('create-product',[ProductController::class, 'create'])->name('create_product');
    Route::post('edit-product',[ProductController::class, 'edit'])->name('edit_product');
    Route::post('delete-product', [ProductController::class, 'delete'])->name('delete_product');
    Route::post('tambah-stock-product',[ProductController::class, 'tambah_stock'])->name('tambah_stock_product');

    Route::get('convert-product', [ConvertController::class, 'index'])->name('convert_product');
    Route::post('create-convert',[ConvertController::class, 'create'])->name('create_convert');

    Route::get('history', [HistoryController::class, 'index'])->name('history');

});


/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__.'/auth.php';
