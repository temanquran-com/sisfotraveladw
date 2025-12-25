<?php

use App\Models\Booking;
use App\Models\Payment;
use App\Livewire\Beranda;
use App\Livewire\Gallery;
use App\Models\PaketSaya;
use App\Livewire\HomePage;
use App\Livewire\PaketList;
use App\Livewire\Testimoni;
use Illuminate\Support\Facades\Route;
use Filament\Http\Controllers\Auth\LogoutController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', HomePage::class)->name('beranda');

//using filament
Route::get('/login', function () {
    return redirect('customer/login');
})->name('login');


// Route::middleware('guest')->group(function () {
//     Route::get('/login', Login::class)->name('login');
//     Route::get('/register', Register::class)->name('register');
// });

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');



Route::get('/', Beranda::class)->name('beranda');
Route::get('/testimoni', Testimoni::class)->name('testimoni');
Route::get('/gallery', Gallery::class)->name('gallery');
Route::get('/paket-list', PaketList::class)->name('paketumroh');

// Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
//     Route::get('/paket-saya', [PaketSaya::class, 'index'])->name('paket-saya.index');
//     Route::get('/booking/{paketSayaId}', [Booking::class, 'create'])->name('booking.create');
//     Route::post('/booking/{paketSayaId}', [Booking::class, 'store'])->name('booking.store');
//     Route::get('/payment/{bookingId}', [Payment::class, 'create'])->name('payment.create');
//     Route::post('/payment/{bookingId}', [Payment::class, 'store'])->name('payment.store');
//     Route::get('/jadwal/{bookingId}', [Booking::class, 'showJadwal'])->name('jadwal.show');
// });

Route::get('/logout', LogoutController::class)->name('logout');
