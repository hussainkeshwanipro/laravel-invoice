<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\InvoiceController;

Auth::routes();

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('postLogin', [AuthController::class, 'postLogin'])->name('postLogin');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('postRegister', [AuthController::class, 'postRegister'])->name('postRegister');


Route::get('/user', [AuthController::class, 'user'])->name('user');

Route::get('All-invoice', [InvoiceController::class, 'index'])->name('invoice');
Route::get('/addInvoice', [InvoiceController::class, 'addInvoice'])->name('addInvoice');
Route::post('postInvoice', [InvoiceController::class, 'postInvoice'])->name('postInvoice');
Route::get('invoice/delete/{id}', [InvoiceController::class, 'delete']);
Route::get('invoice/edit/{id}', [InvoiceController::class, 'edit']);
Route::post('updateInvoice', [InvoiceController::class, 'update'])->name('updateInvoice');
Route::get('invoice/pdf/{id}', [InvoiceController::class, 'pdf']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

//pie chart
Route::get('piechart', [ChartController::class, 'piechart'])->name('piechart');
Route::get('amountchart', [ChartController::class, 'amountchart'])->name('amountchart');