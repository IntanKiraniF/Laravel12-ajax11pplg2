<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('beranda', ['title' => 'Beranda']);
});

// Tampilan halaman item
Route::get('/items', [ItemController::class, 'index']);

// Data untuk DataTables (AJAX)
Route::get('/items/get_data', [ItemController::class, 'getData']);

// Get satu item untuk edit
Route::get('/items/{idItem}', [ItemController::class, 'getDataById']);

// Simpan item baru
Route::post('/items/form', [ItemController::class, 'storeData']);

// Update item lama
Route::put('/items/form/{idItem}', [ItemController::class, 'updateData']);

// Hapus item
Route::delete('/items/form/{idItem}', [ItemController::class, 'destroyData']);
