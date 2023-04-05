<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\User\TransferController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\WithdrawalController;
use App\Http\Controllers\User\AuthorizationController;


Route::prefix('user')->name('user.')->middleware('maintenance')->group(function () {
    Route::get('register',   [AuthController::class,'registerForm'])->name('register');
    Route::post('register',  [AuthController::class,'register']);
    Route::get('login',      [AuthController::class,'showLoginForm'])->name('login');
    Route::post('login',     [AuthController::class,'login'])->name('login');
    Route::get('logout',     [AuthController::class,'logout'])->name('logout');
    Route::get('forgot-password',      [AuthController::class,'forgotPassword'])->name('forgot.password');
    Route::post('forgot-password',     [AuthController::class,'forgotPasswordSubmit']);
    Route::get('forgot-password/verify-code',      [AuthController::class,'verifyCode'])->name('verify.code');
    Route::post('forgot-password/verify-code',     [AuthController::class,'verifyCodeSubmit']);

    Route::get('reset-password',      [AuthController::class,'resetPassword'])->name('reset.password');
    Route::post('reset-password',     [AuthController::class,'resetPasswordSubmit']);

    Route::get('verify-email',        [AuthorizationController::class,'verifyEmail'])->name('verify.email');
    Route::post('verify-email',       [AuthorizationController::class,'verifyEmailSubmit']);

    Route::get('two-step/verification',       [AuthorizationController::class,'twoStep'])->name('two.step.verification')->middleware('auth');

    Route::post('two-step/verification',      [AuthorizationController::class,'twoStepVerify'])->middleware('auth');

    Route::get('resend/two-step/verify-code', [AuthorizationController::class,'twoStepResendCode'])->name('two.step.resend')->middleware('auth');

    Route::middleware(['auth','email_verify','twostep'])->group(function () {
        Route::get('/',                        [UserController::class,'index'])->name('dashboard');
        Route::get('profile',                  [UserController::class,'profile'])->name('profile');
        Route::post('profile',                 [UserController::class,'profileSubmit']);
        Route::get('change-password',          [UserController::class,'changePass'])->name('change.pass');
        Route::post('change-password',         [UserController::class,'changePassSubmit']);
     
        Route::get('transactions',             [UserController::class,'transactions'])->name('transactions');
        Route::get('transaction/details/{id}', [UserController::class,'trxDetails'])->name('trx.details');

        //order
        Route::get('/new-order',        [UserOrderController::class,'newOrder'])->name('order.new');
        Route::post('/new-order',       [UserOrderController::class,'confirmOrder']);
        Route::get('/new-mass-order',   [UserOrderController::class,'newMassOrder'])->name('mass.order.new');
        Route::post('/new-mass-order',  [UserOrderController::class,'confirmMassOrder']);
        Route::get('/order-history',    [UserOrderController::class,'orderHistory'])->name('order.history');
        Route::post('/get-service',     [UserOrderController::class,'categoryService'])->name('order.category.service');
        Route::get('/get-orders',       [UserOrderController::class,'getOrders'])->name('get.orders');
        Route::post('/service-details', [UserOrderController::class,'getServiceDetails'])->name('order.service.detail');

        //services
        Route::get('/services',         [UserOrderController::class,'services'])->name('services');
        Route::get('/get-services',     [UserOrderController::class,'getServices'])->name('get.services');

        //balance transfer
        Route::post('check-receiver',           [TransferController::class,'checkReceiver'])->name('check.receiver');
        Route::get('transfer-balance',          [TransferController::class,'transferForm'])->name('transfer.balance');
        Route::post('transfer-balance',         [TransferController::class,'submitTransfer']);
        Route::get('balance-transfer/history',  [TransferController::class,'transferHistory'])->name('transfer.history');

        //referrals
        Route::get('referrals',           [UserController::class,'referrals'])->name('referrals');
        Route::get('api',                 [UserController::class,'apiDoc'])->name('api.doc');

        //withdraw
        Route::get('withdraw-money',    [WithdrawalController::class,'withdrawForm'])->name('withdraw.form');
        Route::post('withdraw-money',   [WithdrawalController::class,'withdrawSubmit']);
        Route::get('withdraw-methods',  [WithdrawalController::class,'methods'])->name('withdraw.methods');
        Route::get('withdraw-history',  [WithdrawalController::class,'history'])->name('withdraw.history');


        //deposit
        Route::get('deposit',          [DepositController::class,'index'])->name('deposit.index');
        Route::post('payment/submit',  [DepositController::class,'depositSubmit'])->name('deposit.submit');
        Route::post('payment-submit',  [DepositController::class,'depositPayment'])->name('deposit.payment');
        Route::get('deposit/history',  [DepositController::class,'dipositHistory'])->name('deposit.history');
        Route::get('gateway-methods',  [DepositController::class,'methods'])->name('gateway.methods');

        //twostep
        Route::get('/two-step/authentication',  [UserController::class,'twoStep'])->name('two.step');
        Route::get('/two-step/verify',          [UserController::class,'twoStepVerifyForm'])->name('two.step.verify');
        Route::post('/two-step/verify',         [UserController::class,'twoStepVerifySubmit']);
        Route::post('/two-step/authentication', [UserController::class,'twoStepSendCode']);

        // support ticket
        Route::get('support/tickets',              [SupportTicketController::class,'index'])->name('ticket.index');
        Route::post('open/support/tickets',        [SupportTicketController::class,'openTicket'])->name('ticket.open');
        Route::post('reply/ticket/{ticket_num}',   [SupportTicketController::class,'replyTicket'])->name('ticket.reply');

        Route::get('change-currency/{id}',         [UserController::class,'changeCurrency'])->name('change.currency');

        Route::get('gateway-methods',  [DepositController::class,'methods'])->name('gateway.methods');

        Route::get('generate-key',  [UserController::class,'generateKey'])->name('generate.key');


    });
});


