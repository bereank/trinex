<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Nav\SharedNavController;
use App\Http\Controllers\Nav\ApprovalStagesNavController;
use App\Http\Controllers\Nav\ApprovalTemplatesNavController;

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

Route::get('/reset-sap-password', [SharedNavController::class, 'resetSAPPassword'])->name('resetsappassword');

// Route::group(['middleware' => ['auth',]], function () {
//     Route::get('/', [SharedNavController::class, 'getDashboard']);
//     Route::get('/home', [SharedNavController::class, 'getDashboard'])->name('home');
//     Route::group(['prefix' => 'v1'], function () {
//         Route::get('/dashboard', [SharedNavController::class, 'getDashboard'])->name('dashboard');
//         Route::get('/approval-request/{client_id}', [SharedNavController::class, 'getApprovalRequest'])->name('approvalrequest.index');
//         Route::get('/approval-report/{client_id}', [SharedNavController::class, 'getApprovalReport'])->name('approvalrequest.reports');
//         Route::get('/document/{client_id}/{ObjType}/{WddCode}/{draftEntry}', [SharedNavController::class, 'getApprovalRequestDocumentDraft'])->name('approvalrequest.document.draft');
//         Route::get('/attachments/{client_id}/{ObjType}/{draftEntry}/{LineAttach}', [SharedNavController::class, 'getApprovalRequestDocumentAttachment'])->name('approvalrequest.attachment');
//         Route::get('/system-users', [SharedNavController::class, 'getSystemUsers'])->name('system.users');
//         Route::get('/system-users/{id}', [SharedNavController::class, 'getSystemUsersEdit'])->name('users.edit');
//         Route::get('/setting', [SharedNavController::class, 'getSettings'])->name('settings');

//         Route::get('stock', [StockController::class, 'index'])->name('stock.index');
//         Route::get('stocks-in-kenya', [StockController::class, 'stockCountKenya'])->name('stockCountKenya');
//         Route::get('stocks-in-tanzania', [StockController::class, 'stockCountTanzania'])->name('stockCountTanzania');
//         Route::get('stocks-in-uganda', [StockController::class, 'stockCountUganda'])->name('stockCountUganda');


        Route::get('/expense/{client_id}', [SharedNavController::class, 'getExpense'])->name('expense');
        Route::get('/expense-report/{client_id}', [SharedNavController::class, 'getExpenseReport'])->name('expense.report');
        Route::get('/expense/create/{client_id}', [SharedNavController::class, 'getCreateExpense'])->name('expense.new');
        Route::get('/expense/view/{client_id}/{expense_id}', [SharedNavController::class, 'getViewExpense'])->name('expense.view');
        Route::get('/expense-report/{client_id}/export', [SharedNavController::class, 'exportExpenseReport'])->name('expense.report.export');


//         Route::get('/approval-templates/tindex', [ApprovalTemplatesNavController::class, 'index'])->name('templates.index');
//         Route::get('/approval-templates/create', [ApprovalTemplatesNavController::class, 'create'])->name('templates.create');
//         Route::get('/approval-templates/edit/{id}', [ApprovalTemplatesNavController::class, 'edit'])->name('templates.edit');

//         Route::get('/approval-stages/index', [ApprovalStagesNavController::class, 'index'])->name('stages.index');
//         Route::get('/approval-stages/create', [ApprovalStagesNavController::class, 'create'])->name('stages.create');
//         Route::get('/approval-stages/edit/{id}', [ApprovalStagesNavController::class, 'edit'])->name('stages.edit');

//         Route::get('/reports/{expenseId}/print', [ReportController::class, 'printStudentStatement'])->name('print.expense');
//     });
// });
