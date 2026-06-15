<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\DraftController;
use App\Http\Controllers\v1\MAuthController;
use App\Http\Controllers\v1\StockInfoController;
use App\Http\Controllers\v1\CostCenterController;
use App\Http\Controllers\v1\ApprovalRequestController;
use App\Http\Controllers\v1\PurchaseRequestController;
use App\Http\Controllers\v1\ApprovalDecisionController;
use App\Http\Controllers\v1\ApprovalRequestVerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * INTEGRATOR APIS
 */
Route::group([
    'prefix' => 'v1',
], function () {
    Route::post('login', [MAuthController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('approval-decisions', [ApprovalDecisionController::class, 'createOrUpdateApprovalDecision'])->name('create.approval.decisions');
        Route::get('sync-approval-decison/{databaseID}', [ApprovalDecisionController::class, 'syncApprovalDecision'])->name('sync.approval.decisions');
        Route::post('update-approval-decison/{databaseID}', [ApprovalDecisionController::class, 'updateApprovalDecision'])->name('update.approval.decisions');
        Route::post('approval-requests', ApprovalRequestController::class)->name('approval.requests');
        Route::post('users', [UserController::class, 'createOrUpdateUsers'])->name('users');
        Route::get('approvers/{id}', [UserController::class, 'getApproversUserIDs'])->name('approvers');
        Route::get('drafts-entries/{id}', [DraftController::class, 'getDraftDocEntries'])->name('draft-entries');
        Route::post('drafts-entries/{id}', [DraftController::class, 'createDraftDocEntries'])->name('create-draft-entries');

        Route::get('wdd-entries/{id}', [ApprovalRequestVerificationController::class, 'getWddEntries'])->name('wdd-entries');
        Route::post('wdd-entries/{id}', [ApprovalRequestVerificationController::class, 'updateWddEntries'])->name('update-wdd-entries');


        Route::post('stock-info/{id}', StockInfoController::class)->name('stockInfo');



        Route::get('purchase-requests/{id}', [PurchaseRequestController::class, 'index'])->name('purchase-requests.index');
        Route::post('purchase-requests/{id}', [PurchaseRequestController::class, 'update'])->name('purchase-requests.update');
        Route::get('purchase-requests-payment/{id}', [PurchaseRequestController::class, 'getPurchaseRequestPaymentDetails'])->name('purchase-requests.getPurchaseRequestPaymentDetails');
        Route::post('purchase-requests-payment/{id}', [PurchaseRequestController::class, 'purchaseRequestPaymentDetails'])->name('purchase-requests.purchaseRequestPaymentDetails');
        Route::post('purchase-requests-paidsum/{id}', [PurchaseRequestController::class, 'purchaseRequestPaymentSumDetails'])->name('purchase-requests.purchaseRequestPaymentSumDetails');

        Route::post('cost-centers', CostCenterController::class)->name('cost-centes');
    });
});


