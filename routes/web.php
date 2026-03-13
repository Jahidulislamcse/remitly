<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BankPayController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillPayController;
use App\Http\Controllers\CashInCashOutController;
use App\Http\Controllers\ColorSettingController;
use App\Http\Controllers\CommitionController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MobileBankingController;
use App\Http\Controllers\MobileRechargeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\MenualPaymentController;
use App\Http\Controllers\PayableAccountController;
use App\Http\Controllers\RemittanceController;
use App\Http\Controllers\Admin\ChatLinkController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Chat\GroupController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Frontend\UserAuthController;
use App\Http\Middleware\Otp;
use App\Http\Middleware\BlockBangladesh;
use App\Http\Middleware\DeviceRestrictionMiddleware;

use App\Models\BankPay;
use App\Models\BillPay;
use App\Models\Group;
use App\Models\MobileBanking;
use App\Models\MobileRecharge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Notifications\PushNotification;
require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('auth.login');
// });

// Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

Route::get('/app-only', function () {
    return view('android_app_only');
})->name('app.only');

Route::get('/install-guide', function () {
    return view('install_guide');
})->name('install.guide');

       
Route::get('/test-push', function() {
    $admin = User::first(); 
    if ($admin) {
        $admin->notify(new \App\Notifications\PushNotification(
            "New Topup", 
            "A customer has initiated a topup!"
        ));
    }
    return "Push sent to admin!";
});

Route::post('/push-subscribe', function(Request $request) {
    $user = auth()->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $subscription = $request->all();

    if (!isset($subscription['endpoint'], $subscription['keys']['p256dh'], $subscription['keys']['auth'])) {
        return response()->json(['error' => 'Invalid subscription data'], 422);
    }

    $user->updatePushSubscription(
        $subscription['endpoint'],
        $subscription['keys']['p256dh'],
        $subscription['keys']['auth']
    );

    return response()->json(['success' => true]);
});

Route::middleware('auth.user')->group(function () {
    Route::get('/chat-messages', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
    Route::get('/new-chat', [ChatController::class, 'chatUsers'])->name('new.chat');
    Route::post('/new-send-message', [ChatController::class, 'send'])->name('new.send.message');
    Route::post('/create-group',[ChatController::class,'createGroup']);
    Route::post('/group-create', [GroupController::class,'store']);
});


// Route::middleware('auth')->group(function () {
//     Route::post('/send-message', [ChatController::class, 'send']);
// });

Route::match(['get', 'post'], 'upload-image', function (Request $request) {
    if ($request->hasFile('upload')) {
        $fileName = imageUpload($request->file('upload'));
        $url = asset($fileName);
        return response()->json(['fileNmae' => $fileName, 'uploaded' => 1, 'url' => $url]);
    }
    return response()->json(['error' => 'File upload failed'], 400);
})->name('upload.image');


Route::middleware([\App\Http\Middleware\TrackUserVisit::class])->group(function () {
    Route::get('/home', [MenuController::class, 'showDashboard'])->name('customer.dashboard')->middleware('block');
});


Route::get('blocked', [HomeController::class, 'blocked'])->name('blocked');

Route::get('/join-group-chat/{token}', [ChatLinkController::class, 'joinChat'])->name('guest.chat.join');


Route::post('/admin/guest-chat-links/toggle-status', [ChatLinkController::class, 'toggleStatus'])->name('admin.chat.links.toggle');
Route::get('/menual-payment', [MenualPaymentController::class, 'index'])->name('menual-payment.index');
Route::post('/menual-payment', [MenualPaymentController::class, 'store'])->name('menual-payment.store');
Route::get('/get-payment-data', [MenualPaymentController::class, 'getPaymentData'])->name('get-payment-data');

Route::get('payment-requests', [CashInCashOutController::class, 'index'])->name('cashincashout.index');
Route::post('payment-requests/store', [CashInCashOutController::class, 'store'])->name('cashincashout.store');
Route::post('payment-requests/update/{id}', [CashInCashOutController::class, 'updateStatus'])->name('cashincashout.update');

Route::get('cashincashout/{id}', [CashInCashOutController::class, 'show'])->name('cashincashout.show');
Route::put('cashincashout/updateStatus/{id}', [CashInCashOutController::class, 'updateStatus'])->name('cashincashout.updateStatus');



Route::get('otp', [HomeController::class, 'otp'])->name('otp');
Route::get('otp/{phone}/', [HomeController::class, 'otp'])->name('forget.otp');
Route::get('send/otp', [HomeController::class, 'sendotp'])->name('send.otp');
Route::post('otp/varify', [HomeController::class, 'otpvarify'])->name('otp.varify');

Route::post('password/forget', [HomeController::class, 'forget_password'])->name('password.phone');
Route::post('/change-password', [MenuController::class, 'changePassword'])->name('change.password');
Route::get('password/reset/{otp}/{phone}', [HomeController::class, 'reset_password'])->name('reset.password');
Route::post('password/reset', [HomeController::class, 'reset_password'])->name('reset.password.update');

Route::get('/get-notification', [NotificationController::class, 'getNotification']);
Route::get('/get-random-notification', [NotificationController::class, 'getRandomNotification']);
Route::get('/alert', [NotificationController::class, 'alert'])->name('alert');

Route::match(['get', 'post'], 'get-data', [HomeController::class, 'getData'])->name('register.data');
Route::match(['get', 'post'], 'get-image', [HomeController::class, 'getImage'])->name('register.image');
Route::match(['get', 'post'], 'get-final', [HomeController::class, 'getFinal'])->name('register.final');
Route::match(['get', 'post'], 'user-agree', [HomeController::class, 'agree'])->name('register.agree');


Route::get('review/upload', [ReviewController::class, 'create'])->name('review.upload');
Route::get('reviews/view', [ReviewController::class, 'index'])->name('reviews.view')->middleware('block');
Route::post('review/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
Route::patch('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');

Route::put('/user/reviews/{id}', [ReviewController::class, 'userReviewUpdate'])->name('user.reviews.update')->middleware('block');
Route::delete('/user/reviews/{id}', [ReviewController::class, 'userReviewDestroy'])->name('user.reviews.destroy');
Route::post('user/review/store', [ReviewController::class, 'storeFromUser'])->name('user.reviews.store');


Route::get('payable-accounts', [PayableAccountController::class, 'index'])->name('admin.payable_accounts.index');
Route::get('payable-accounts/create', [PayableAccountController::class, 'create'])->name('admin.payable_accounts.create');
Route::post('payable-accounts', [PayableAccountController::class, 'store'])->name('admin.payable_accounts.store');
Route::get('payable-accounts/{id}/edit', [PayableAccountController::class, 'edit'])->name('admin.payable_accounts.edit');
Route::put('payable-accounts/{id}', [PayableAccountController::class, 'update'])->name('admin.payable_accounts.update');
Route::delete('payable-accounts/{id}', [PayableAccountController::class, 'destroy'])->name('admin.payable_accounts.destroy');

Route::prefix('admin')->name('admin.')->middleware(['auth.admin'])->group(function () {
    Route::get('/colors', [ColorSettingController::class, 'index'])->name('colors.index');
    Route::put('/colors', [ColorSettingController::class, 'update'])->name('colors.update');

    Route::get('/guest-chat-links', [ChatLinkController::class, 'index'])->name('chat.links');
    Route::post('/guest-chat-links/store', [ChatLinkController::class, 'store'])->name('chat.links.store');
    Route::get('/guest-chat-links/delete/{id}', [ChatLinkController::class, 'destroy'])->name('chat.links.delete');

    Route::get('commission', [CommitionController::class, 'index'])->name('commission.index');
    Route::get('commission/create', [CommitionController::class, 'create'])->name('commission.create');
    Route::post('commission', [CommitionController::class, 'store'])->name('commission.store');
    Route::get('commission/{id}/edit', [CommitionController::class, 'edit'])->name('commission.edit');
    Route::put('commission/{id}', [CommitionController::class, 'update'])->name('commission.update');
    Route::delete('commission/{id}', [CommitionController::class, 'destroy'])->name('commission.destroy');

    Route::resource('banners', BannerController::class);
});


Route::group(['middleware' => ['auth.user']], function () {
    Route::get('/', [MenuController::class, 'index'])->name('user.index');
    Route::get('history', [HomeController::class, 'history'])->name('history')->middleware('block');

    Route::group(['controller' => MenuController::class], function () {
        Route::match(['get', 'post'], 'chat', 'chat')->name('chat');
        Route::match(['get', 'post'], 'support', 'support')->name('support');
        Route::match(['get', 'post'], 'helpline', 'helpline')->name('helpline');
        Route::match(['get', 'post'], 'cash_pickup', 'cash_pickup')->name('cash_pickup');
        Route::match(['get', 'post'], 'rate', 'rate')->name('rate');
        Route::match(['get', 'post'], 'about', 'about')->name('about');
        Route::match(['get', 'post'], 'user-profile', 'profile')->name('profile');
    });

    Route::group(['controller' => TopupController::class], function () {
        Route::match(['get', 'post'], 'user/topup', 'topup')->name('topup')->middleware('block');
        Route::match(['get', 'post'], 'bank/topup', 'bank_topup')->name('bank.topup')->middleware('block');
    });

    Route::group(['controller' => MobileRechargeController::class], function () {
        Route::match(['get', 'post'], 'user/recharge', 'recharge')->name('recharge')->middleware('block');
    });

    Route::group(['controller' => BillPayController::class], function () {
        Route::match(['get', 'post'], 'user/billpay', 'billpay')->name('billpay')->middleware('block');
    });

    Route::group(['controller' => BankPayController::class], function () {
        Route::match(['get', 'post'], 'user/bankpay', 'bankpay')->name('bankpay')->middleware('block');
    });

    Route::group(['controller' => RemittanceController::class], function () {
        Route::match(['get', 'post'], 'user/remittance', 'remittance')->name('remittance')->middleware('block');
    });

    Route::match(['get','post'], 'user/mobile-banking/{operator}',
        [MobileBankingController::class, 'mobileBanking'])->name('mobile.banking')->middleware('block');

    Route::group(['controller' => MobileBankingController::class], function () {
        Route::match(['get', 'post'], 'user/bkash', 'bkash')->name('bkash')->middleware('block');
        Route::match(['get', 'post'], 'user/nagad', 'nagad')->name('nagad')->middleware('block');
        Route::match(['get', 'post'], 'user/upay', 'upay')->name('upay')->middleware('block');
        Route::match(['get', 'post'], 'user/rocket', 'rocket')->name('rocket')->middleware('block');
    });

    Route::group(['controller' => CommonController::class], function () {
        Route::match(['get', 'post'], 'success/{id}/{page}', 'success')->name('success');
        Route::match(['get', 'post'], 'page', 'page')->name('page');
        Route::match(['get', 'post'], 'page/{id}/edit', 'page')->name('page.edit');
        Route::match(['get', 'post'], 'page/{id}/delete', 'pagedelete')->name('page.delete');
    });

    Route::resource('guides', GuideController::class);
    Route::get('/admin/resolve-chat-avatar/{phone}', [App\Http\Controllers\MenuController::class, 'resolveChatAvatar'])->name('admin.chat.avatar');
});



Route::group(['middleware' => ['auth.admin']], function () {

    Route::get('/admin', [MenuController::class, 'adminIndex'])->name('admin.index');

    Route::get('/admin-dashboard', [MenuController::class, 'showAdminDashboard'])
        ->name('super.admin.dashboard');

    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users/add', [UserController::class, 'store'])->name('admin.users.add');

    Route::get('notification', [NotificationController::class, 'index'])->name('notifications.index')->middleware('admin');
    Route::get('notification/create', [NotificationController::class, 'create'])->name('notifications.create')->middleware('admin');
    Route::post('notification/store', [NotificationController::class, 'store'])->name('notifications.store')->middleware('admin');
    Route::get('notification/{notification}/edit', [NotificationController::class, 'edit'])->name('notifications.edit')->middleware('admin');
    Route::post('notification/{notification}/update', [NotificationController::class, 'update'])->name('notifications.update')->middleware('admin');
    Route::get('notification/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete')->middleware('admin');

    Route::group(['controller' => MenuController::class], function () {
        Route::get('/admin/users/{user}', [MenuController::class, 'userInfo'])->name('admin.users.show');
        Route::patch('admin/users/{user}/modules', [MenuController::class, 'updateModules'])->name('admin.users.updateModules');
        Route::get('/user/block/{id}', [MenuController::class, 'blockUser'])->name('user.block');
        Route::match(['get', 'post'], 'announce', 'announce')->name('announce');
        Route::match(['get', 'post'], 'users', 'users')->name('user.list');
        Route::match(['get', 'post'], 'chat', 'chat')->name('chat');
        Route::match(['get', 'post'], 'chat-admin', 'chatAdmin')->name('chat.admin');
        Route::match(['get', 'post'], 'pending-chat', 'pendingChat')->name('pending-chat');
        Route::match(['get', 'post'], 'create-chat', 'createChat')->name('create-chat');
        Route::post('send-message', [MenuController::class, 'store'])->name('admin.send.message');
        
        Route::match(['get', 'post'], 'user-create', 'create')->name('user.new');
        Route::match(['get', 'post'], 'user-edit/{id}', 'create')->name('user.edit');
        Route::match(['get', 'post'], 'user-masjid', 'masjid')->name('user.masjid');
        Route::match(['get', 'post'], 'user-masjid/{id}', 'masjid')->name('user.masjid.edit');
        Route::match(['get'], 'user-status/{id}', 'userstatus')->name('user.status');
        Route::match(['get'], 'user-delete/{id}', 'userdelete')->name('user.delete');
        Route::match(['get', 'post'], 'user-add-balance/{id}', 'addbalance')->name('user.addbalance')->middleware('admin');

        Route::post('/user/{id}/push-send', [MenuController::class, 'sendUserPush'])
            ->name('admin.user.push.send');
        
        Route::get('/chat-admin/pending', 'pending')->name('admin.chat.pending');
        Route::post('/chat-admin/approve','approve')->name('admin.chat.approve');
        Route::post('/chat-admin/reject', 'reject')->name('admin.chat.reject');
    });

    Route::group(['controller' => TopupController::class], function () {
        Route::match(['get', 'post'], 'topup-list', 'topup_list')->name('topup.list')->middleware('admin');
        Route::match(['get', 'post'], 'topup-approve/{id}', 'topup_approve')->name('topup.approve')->middleware('admin');
        Route::match(['get', 'post'], 'topup-reject/{id}', 'topup_reject')->name('topup.reject')->middleware('admin');
        Route::match(['get', 'post'], 'topup-delete/{id}', 'topup_delete')->name('topup.delete')->middleware('admin');
    });

    Route::group(['controller' => MobileRechargeController::class], function () {
        Route::match(['get', 'post'], 'recharge-list', 'list')->name('recharge.list')->middleware('admin');
        Route::match(['get', 'post'], 'recharge-approve/{id}', 'approve')->name('recharge.approve')->middleware('admin');
        Route::match(['get', 'post'], 'recharge-reject/{id}', 'reject')->name('recharge.reject')->middleware('admin');
        Route::match(['get', 'post'], 'recharge-delete/{id}', 'delete')->name('recharge.delete')->middleware('admin');
    });

    Route::group(['controller' => BillPayController::class], function () {
        Route::match(['get', 'post'], 'billpay-list', 'list')->name('billpay.list')->middleware('admin');
        Route::match(['get', 'post'], 'billpay-approve/{id}', 'approve')->name('billpay.approve')->middleware('admin');
        Route::match(['get', 'post'], 'billpay-reject/{id}', 'reject')->name('billpay.reject')->middleware('admin');
        Route::match(['get', 'post'], 'billpay-delete/{id}', 'delete')->name('billpay.delete')->middleware('admin');
        Route::match(['get', 'post'], 'user/billpay', 'billpay')->name('billpay')->middleware('block');
    });

    Route::group(['controller' => BankPayController::class], function () {
        Route::match(['get', 'post'], 'bankpay-list', 'list')->name('bankpay.list')->middleware('admin');
        Route::match(['get', 'post'], 'bankpay-approve/{id}', 'approve')->name('bankpay.approve')->middleware('admin');
        Route::match(['get', 'post'], 'bankpay-reject/{id}', 'reject')->name('bankpay.reject')->middleware('admin');
        Route::match(['get', 'post'], 'bankpay-delete/{id}', 'delete')->name('bankpay.delete')->middleware('admin');
    });

    Route::group(['controller' => RemittanceController::class], function () {
        Route::match(['get', 'post'], 'remittance-list', 'list')->name('remittance.list');
        Route::match(['get', 'post'], 'remittance-approve/{id}', 'approve')->name('remittance.approve');
        Route::match(['get', 'post'], 'remittance-reject/{id}', 'reject')->name('remittance.reject');
        Route::match(['get', 'post'], 'remittance-delete/{id}', 'delete')->name('remittance.delete');

    });

    Route::group(['controller' => MobileBankingController::class], function () {
        Route::match(['get', 'post'], '{operator}-list', [MobileBankingController::class, 'mobileBankList'])
            ->name('mobilebank.list')
            ->middleware('admin');

        Route::match(['get', 'post'], 'mobilebanking-approve/{id}', 'approve')->name('mobilebankinglist.approve')->middleware('admin');
        Route::match(['get', 'post'], 'mobilebanking-reject/{id}', 'reject')->name('mobilebankinglist.reject')->middleware('admin');
        Route::match(['get', 'post'], 'mobilebanking-delete/{id}', 'delete')->name('mobilebankinglist.delete')->middleware('admin');
    });

    Route::group(['controller' => CommonController::class], function () {
        Route::match(['get', 'post'], 'page', 'page')->name('page');
        Route::match(['get', 'post'], 'page/{id}/edit', 'page')->name('page.edit');
        Route::match(['get', 'post'], 'page/{id}/delete', 'pagedelete')->name('page.delete');
    });

    Route::group(['controller' => SettingController::class], function () {
        Route::match(['get', 'post'], 'setting/general', 'general')->name('setting.general')->middleware('admin');

        Route::match(['get', 'post'], 'mobilebanking', 'mobilebanking')->name('mobilebanking')->middleware('admin');
        Route::match(['get', 'post'], 'mobilebanking/{id}/edit', 'mobilebanking')->name('mobilebanking.edit')->middleware('admin');
        Route::match(['get', 'post'], 'mobilebanking/{id}/delete', 'mobilebankingdelete')->name('mobilebanking.delete')->middleware('admin');

        Route::match(['get', 'post'], 'bank', 'bank')->name('bank')->middleware('admin');
        Route::match(['get', 'post'], 'bank/{id}/edit', 'bank')->name('bank.edit')->middleware('admin');
        Route::match(['get', 'post'], 'bank/{id}/delete', 'bankedelete')->name('bank.delete')->middleware('admin');

        Route::match(['get', 'post'], 'country', 'country')->name('country')->middleware('admin');
        Route::match(['get', 'post'], 'country/{id}/edit', 'country')->name('country.edit')->middleware('admin');
        Route::match(['get', 'post'], 'country/{id}/delete', 'countrydelete')->name('country.delete')->middleware('admin');

        Route::match(['get', 'post'], 'slider', 'slider')->name('slider')->middleware('admin');
        Route::match(['get', 'post'], 'slider/{id}/edit', 'slider')->name('slider.edit')->middleware('admin');
        Route::match(['get', 'post'], 'slider/{id}/delete', 'sliderdelete')->name('slider.delete')->middleware('admin');
    });

    Route::resource('guides', GuideController::class);
    Route::get('/admin/resolve-chat-avatar/{phone}', [App\Http\Controllers\MenuController::class, 'resolveChatAvatar'])->name('admin.chat.avatar');
});


Route::get('/debug-device-info', function (\Illuminate\Http\Request $request) {
    $user = auth()->user();
    
    $data = [
        'IP' => $request->ip(),
        'User_Agent' => $request->header('User-Agent'),
        'X_Requested_With' => $request->header('X-Requested-With'),
        'Is_Android_Detected' => stripos($request->header('User-Agent'), 'Android') !== false,
        'User_Logged_In' => $user ? 'YES' : 'NO',
        'User_ID' => $user ? $user->id : 'N/A',
        'User_Role' => $user ? $user->role : 'N/A',
        'Is_Super' => $user ? $user->is_super : 'N/A',
        'Session_ID' => session()->getId(),
    ];

    // Log::info('DEVICE_DEBUG_DATA:', $data);

    return response()->json([
        'message' => 'Data logged successfully. Please check storage/logs/laravel.log',
        'data' => $data 
    ]);
});

