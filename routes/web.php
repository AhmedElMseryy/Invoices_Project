<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});


Auth::routes();
// Auth::routes(['register' => false]);

##----------------------------------------------------------HOME ROUTE
Route::get('/home', [HomeController::class, 'index'])->name('home');

##----------------------------------------------------------INVOICES 
Route::resource('/invoices', InvoicesController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);
Route::get('/edit_invoice/{id}', [InvoicesController::class, 'edit']);
Route::get('/Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');
Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice']);

Route::get('Invoice_Paid', [InvoicesController::class, 'Invoice_Paid'])->name('Invoice_Paid');
Route::get('Invoice_UnPaid', [InvoicesController::class, 'Invoice_UnPaid'])->name('Invoice_UnPaid');
Route::get('Invoice_Partial', [InvoicesController::class, 'Invoice_Partial'])->name('Invoice_Partial');

Route::get('export_excel', [InvoicesController::class, 'export'])->name('export.excel');

##----------------------------------------------------------SECTIONS 
Route::resource('/sections', SectionsController::class);

##----------------------------------------------------------PRODUCTS 
Route::resource('/products', ProductsController::class);

##----------------------------------------------------------INVOICES DETAILS 
Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit'])->name('invoices.details');
Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

##----------------------------------------------------------INVOICES ATTACHMENTS 
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);

##----------------------------------------------------------Archive 
Route::resource('Archive', InvoiceAchiveController::class);

##----------------------------------------------------------PERMESSION
Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

##----------------------------------------------------------Reports 
Route::get('invoices_report', [Invoices_Report::class, 'index'])->name('Invoice.Report');
Route::post('Search_invoices', [Invoices_Report::class, 'Search_invoices']);

Route::get('customers_report', [Customers_Report::class, 'index'])->name('customers_report');
Route::post('Search_customers', [Customers_Report::class, 'Search_customers']);


Route::get('/{page}', [AdminController::class, 'index']);
