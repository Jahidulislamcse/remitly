<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announc;
use App\Models\BankPay;
use App\Models\Banner;
use App\Models\BlockedUser;
use App\Models\ColorSetting;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\MasjidAccount;
use App\Models\MobileBanking;
use App\Models\MobileRecharge;
use DataTables;
use App\Models\Order;
use App\Models\Remittance;
use App\Models\UserVisit;
use App\Models\Topup;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Traits\SendUserPushNotification;

class MenuController extends Controller
{
    use SendUserPushNotification;
    private string $base;
    private string $token;

    public function __construct()
    {
        $this->base  = rtrim(config('app.chat_api_base', env('CHAT_API_BASE')), '/');
        $this->token = (string) env('CHAT_API_TOKEN');
    }


    public function index()
    {

        $user = auth()->user();

        if ($user->is_blocked == 1) {
            return redirect()->route('blocked');
        }

        // if ($user->role == 'super admin') {
        //     return redirect()->route('super.admin.dashboard');
        // }

        return redirect()->route('customer.dashboard');
    }

    public function adminIndex()
    {

        return redirect()->route('super.admin.dashboard');

    }

    public function showDashboard()
    {
        $title = 'Welcome to Dashboard';
        $user = auth()->user()->load('country');
        $rate = null;
        $country = null;
        $banners = Banner::all();
        $generalSettings = GeneralSetting::first();
        $colors = ColorSetting::first();

        $hasPushSubscription = $user->pushSubscriptions()->exists();

        if ($user->location) {
            $country = Country::find($user->location);
            if ($country) {
                $rate = $country->rate;
            }
        }

        $topups = Topup::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Deposit',
                    'title' => $item->gateway->name ?? 'Topup',
                    'amount' => $item->amount,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'direction' => 'in'
                ];
            });

        $mobileBanking = MobileBanking::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Mobile Banking',
                    'title' => $item->operator,
                    'amount' => $item->amount,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'direction' => 'out'
                ];
            });

        $bankPay = BankPay::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Bank Withdraw',
                    'title' => $item->operator,
                    'amount' => $item->amount,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'direction' => 'out'
                ];
            });

        $recharge = MobileRecharge::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Recharge',
                    'title' => $item->operator,
                    'amount' => $item->amount,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'direction' => 'out'
                ];
            });

        $remittance = Remittance::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Remittance',
                    'title' => $item->operator,
                    'amount' => $item->amount,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'direction' => 'out'
                ];
            });

        $transactions = collect()
            ->merge($topups)
            ->merge($mobileBanking)
            ->merge($bankPay)
            ->merge($recharge)
            ->merge($remittance)
            ->sortByDesc('created_at')
            ->take(10);

        return view('frontend.dashboard', compact(
            'title',
            'hasPushSubscription',
            'country',
            'rate',
            'banners',
            'generalSettings',
            'colors',
            'transactions'
        ))->with('balance', $user->balance);
    }


    public function sendUserPush(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|max:1000',
        ]);

        $user = User::findOrFail($id);

        $this->dispatchUserPush(
            $request->title,
            $request->body,
            $user
        );

        return back()->with([
            'response' => true,
            'msg' => 'Notification sent to user'
        ]);
    }

   public function showAdminDashboard()
    {
        $title = 'Welcome to Dashboard';

        $user = auth()->user();
        $rate = null;
        $country = null;

        $generalSettings = GeneralSetting::first();
        $colors = ColorSetting::first();

        /* --------------------------
        Currency API
        --------------------------- */

        if ($user->location) {
            $country = Country::find($user->location);

            if ($country && $country->currency_code) {

                try {

                    $apiKey = '55dfd34b7d585b2674304254';

                    $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$country->currency_code}");

                    if ($response->successful() && isset($response['conversion_rates']['BDT'])) {
                        $rate = $response['conversion_rates']['BDT'];
                    }

                } catch (\Exception $e) {}
            }
        }

        /* --------------------------
        SYSTEM STATS
        --------------------------- */

        $systemBalance = User::sum('balance');

        $totalUsers = User::count();

        $topupCount = Topup::where('status',1)->sum('amount');
        $remittanceCount = Remittance::where('status',1)->sum('amount');
        $mobileRechargeCount = MobileRecharge::where('status',1)->sum('amount');
        $mobileBankingCount = MobileBanking::where('status',1)->sum('amount');
        $bankPayCount = BankPay::where('status',1)->sum('amount');

        $balance = $topupCount - ($remittanceCount + $mobileRechargeCount + $mobileBankingCount + $bankPayCount);

        $totalTransactions =
            Topup::count() +
            Remittance::count() +
            MobileRecharge::count() +
            MobileBanking::count() +
            BankPay::count();

        $totalAddMoney = Topup::where('status',1)->sum('amount');

        $pendingAddMoney = Topup::where('status',0)->sum('amount');

        $rejectedAddMoney = Topup::where('status',2)->sum('amount');

        $addMoneyCharge = Topup::where('status',1)->sum('commision');

        $totalWithdrawal =
            MobileBanking::where('status',1)->sum('amount') +
            BankPay::where('status',1)->sum('amount');

        $pendingWithdrawal = 
            MobileBanking::where('status',0)->sum('amount') +
            BankPay::where('status',0)->sum('amount');

        $rejectedWithdrawal = 
            MobileBanking::where('status',2)->sum('amount') +
            BankPay::where('status',2)->sum('amount');

        $totalRemittance =Remittance::where('status',1)->sum('amount');

        $pendingRemittance = Remittance::where('status',0)->sum('amount');

        $rejectedRemittance = Remittance::where('status',2)->sum('amount');

        $pendingTopup = Topup::where('status',0)->count();

        $pendingRecharge = MobileRecharge::where('status',0)->count();

        $pendingMobileBanking = MobileBanking::where('status',0)->count();

        $pendingBankPay = BankPay::where('status',0)->count();


        $activeUsers = User::where('balance', '>', 0)
            ->where('is_blocked', 0)
            ->count();

        $inactiveUsers = User::where(function ($q) {
            $q->where('balance', 0)
            ->orWhereNull('balance');
        })->count();

        $pendingUsers = User::where('status', 0)->count();

        $blockedUsers = User::where('is_blocked', 1)->count();

        $months = [];

        $topupGraph = [];

        $rechargeGraph = [];

        $remittanceGraph = [];

        for ($i = 11; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $months[] = $date->format('M');

            $topupGraph[] = Topup::where('status',1)
            ->where('status', 1)
            ->whereMonth('created_at',$date->month)
            ->whereYear('created_at',$date->year)
            ->sum('amount');

            $remittanceGraph[] = Remittance::whereMonth('created_at',$date->month)->where('status', 1)
                ->whereYear('created_at',$date->year)
                  ->sum('amount');
        }


        return view('admin.dashboard', compact(

            'title',
            'country',
            'rate',
            'generalSettings',
            'colors',

            'topupCount',
            'remittanceCount',
            'mobileRechargeCount',
            'mobileBankingCount',
            'bankPayCount',
            'balance',

            'systemBalance',
            'totalUsers',
            'totalTransactions',

            'totalAddMoney',
            'pendingAddMoney',
            'rejectedAddMoney',
            'addMoneyCharge',

            'totalWithdrawal',
            'pendingWithdrawal',
            'rejectedWithdrawal',

            'totalRemittance',
            'pendingRemittance',
            'rejectedRemittance',

            'pendingTopup',
            'pendingRemittance',
            'pendingRecharge',
            'pendingMobileBanking',
            'pendingBankPay',

            'activeUsers',
            'inactiveUsers',
            'pendingUsers',
            'blockedUsers',

            'months',
            'topupGraph',
            'remittanceGraph'

        ));
    }


    public function addbalance(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'amount' => 'required|numeric',
            ]);

            $user = User::findOrFail($id);

            $newBalance = $user->balance + $request->amount;

            if ($newBalance < 0) {
                return redirect()->back()->with([
                    'response' => false,
                    'msg' => 'Balance cannot be negative!',
                ]);
            }

            $user->balance = $newBalance;

            if ($user->save()) {
                return redirect()->back()->with([
                    'response' => true,
                    'msg' => 'User balance updated successfully.',
                ]);
            } else {
                return redirect()->back()->with([
                    'response' => false,
                    'msg' => 'Failed to update user balance.',
                ]);
            }
        }

        $title = "Add balance";
        $user = User::findOrFail($id);
        return view('backend.user.add_balance', compact('title', 'user'));
    }

    public function support()
    {
        $title = "Live Support";
        return view('frontend.support', compact(['title']));
    }

    public function helpline()
    {
        $title = "Helpline";
        return view('backend.helpline', compact(['title']));
    }


    public function cash_pickup()
    {
        $title = "Cash Pickup";
        return view('frontend.cash_pickup', compact(['title']));
    }

    public function rate()
    {
        $title = "Rate Calculation";
        return view('backend.rate', compact(['title']));
    }

    public function news()
    {
        $title = "News";
        return view('backend.news', compact(['title']));
    }

    public function tutorials()
    {
        $title = "Tutorials";
        return view('backend.tutorials', compact(['title']));
    }

    public function about()
    {
        $title = "Abouts us";
        return view('frontend.about', compact(['title']));
    }


    public function users(Request $request)
    {
        $title = 'User List';
        $tab = $request->get('tab', 'with_balance');

        if ($tab === 'visitors') {

            $lists = UserVisit::with('user')
                ->whereNotNull('user_id')
                ->latest('created_at')
                ->paginate(50)
                ->appends($request->all());

            return view('backend.user.index', compact('title', 'lists', 'tab'));
        }

        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($tab === 'with_balance') {
            $query->where('balance', '>', 0);
        } else {
            $query->where(function ($q) {
                $q->where('balance', '<=', 0)
                    ->orWhereNull('balance');
            });
        }

        $lists = $query->paginate(50)->appends($request->all());

        return view('backend.user.index', compact('title', 'lists', 'tab'));
    }




    public function userInfo(Request $request, User $user)
    {
        $title = 'User Details';
        $activeTab = $request->get('tab', 'deposits');
        $hasPushSubscription = $user->pushSubscriptions()->exists();

        $qTopup = trim($request->get('topup_q', ''));
        $topupQuery = Topup::with('gateway')->where('user_id', $user->id);
        if ($qTopup !== '') {
            $topupQuery->where(function ($s) use ($qTopup) {
                $s->where('transaction_id', 'like', "%{$qTopup}%")
                    ->orWhere('amount', 'like', "%{$qTopup}%")
                    ->orWhere('type', 'like', "%{$qTopup}%")
                    ->orWhere('mobile', 'like', "%{$qTopup}%")
                    ->orWhere('account', 'like', "%{$qTopup}%")
                    ->orWhereHas('gateway', fn($g) => $g->where('name', 'like', "%{$qTopup}%"));
            });
        }
        $topups = $topupQuery->latest()->paginate(50, ['*'], 'deposit_page');

        $qMb = trim($request->get('mb_q', ''));
        $mbQuery = MobileBanking::where('user_id', $user->id);
        if ($qMb !== '') {
            $mbQuery->where(function ($s) use ($qMb) {
                $s->where('transaction_id', 'like', "%{$qMb}%")
                    ->orWhere('amount', 'like', "%{$qMb}%")
                    ->orWhere('type', 'like', "%{$qMb}%")
                    ->orWhere('operator', 'like', "%{$qMb}%")
                    ->orWhere('mobile', 'like', "%{$qMb}%");
            });
        }
        $mobileWithdraws = $mbQuery->latest()->paginate(50, ['*'], 'mobile_withdraw_page');

        $qBank = trim($request->get('bank_q', ''));
        $bankQuery = BankPay::where('user_id', $user->id);
        if ($qBank !== '') {
            $bankQuery->where(function ($s) use ($qBank) {
                $s->where('transaction_id', 'like', "%{$qBank}%")
                    ->orWhere('amount', 'like', "%{$qBank}%")
                    ->orWhere('type', 'like', "%{$qBank}%")
                    ->orWhere('operator', 'like', "%{$qBank}%")
                    ->orWhere('mobile', 'like', "%{$qBank}%")
                    ->orWhere('number', 'like', "%{$qBank}%")
                    ->orWhere('branch', 'like', "%{$qBank}%")
                    ->orWhere('achold', 'like', "%{$qBank}%");
            });
        }
        $bankPays = $bankQuery->latest()->paginate(50, ['*'], 'bank_withdraw_page');

        $qRc = trim($request->get('rc_q', ''));
        $mrQuery = MobileRecharge::where('user_id', $user->id);
        if ($qRc !== '') {
            $mrQuery->where(function ($s) use ($qRc) {
                $s->where('operator', 'like', "%{$qRc}%")
                    ->orWhere('type', 'like', "%{$qRc}%")
                    ->orWhere('mobile', 'like', "%{$qRc}%")
                    ->orWhere('amount', 'like', "%{$qRc}%");
            });
        }
        $mobileRecharges = $mrQuery->latest()->paginate(50, ['*'], 'recharge_page');

        $qRemit = trim($request->get('remit_q', ''));
        $remitQuery = \App\Models\Remittance::where('user_id', $user->id);
        if ($qRemit !== '') {
            $remitQuery->where(function ($s) use ($qRemit) {
                $s->where('transaction_id', 'like', "%{$qRemit}%")
                    ->orWhere('operator', 'like', "%{$qRemit}%")
                    ->orWhere('account', 'like', "%{$qRemit}%")
                    ->orWhere('branch', 'like', "%{$qRemit}%")
                    ->orWhere('achold', 'like', "%{$qRemit}%")
                    ->orWhere('amount', 'like', "%{$qRemit}%");
            });
        }
        $remittances = $remitQuery->latest()->paginate(50, ['*'], 'remittance_page');

        $visitQuery = UserVisit::where('user_id', $user->id);

        $totalVisits = $visitQuery->count();
        $lastVisit   = $visitQuery->latest()->first();

        $visits = $visitQuery
            ->latest()
            ->paginate(50, ['*'], 'visit_page');

        return view('backend.user.show', compact(
            'title',
            'user',
            'activeTab',
            'topups',
            'qTopup',
            'mobileWithdraws',
            'qMb',
            'bankPays',
            'qBank',
            'mobileRecharges',
            'qRc',
            'remittances',
            'qRemit',
            'hasPushSubscription',
            'visits',
            'totalVisits',
            'lastVisit',
        ));
    }

    public function updateModules(Request $request, User $user)
    {
        $request->validate([
            'modules' => 'nullable|array',
            'modules.*' => 'string|in:home,deposit,recharge,withdraw,billpay',
        ]);

        $user->modules = $request->modules ? json_encode($request->modules) : null;
        $user->save();

        return redirect()->back()->with('msg', 'Modules updated successfully.');
    }

    public function announce()
    {
        $title = 'User List';
        $list = Announc::all();
        return view('backend.partner.announce', compact(['title', 'list']));
    }
    public function pendingChat()
    {
        self::chat();
        $title = 'Pending Chat';

        return view('backend.pending-chat', compact(['title']));
    }


    public function createChat()
    {
        self::chat();
        $title = 'Create Chat';

        return view('backend.create-chat', compact(['title']));
    }


    public function profile(Request $request)
    {

        if ($request->isMethod('post')) {

            $data = User::find(auth()->id());

            $request->validate([
                'name' => 'required',
                'email' => 'nullable|unique:users,email,' . auth()->id(),
                'phone' => 'required|unique:users,phone,' . auth()->id(),
                'username' => 'nullable|unique:users,username,' . auth()->id(),
            ]);

            $data->employee_id = $request->filled('employee_id') ? $request->employee_id : $data->employee_id;
            $data->name        = $request->filled('name') ? $request->name : $data->name;
            $data->phone       = $request->filled('phone') ? $request->phone : $data->phone;
            $data->address     = $request->filled('address') ? $request->address : $data->address;
            $data->location    = $request->filled('location') ? $request->location : $data->location;
            $data->email       = $request->filled('email') ? $request->email : $data->email;
            $data->username    = $request->filled('username') ? $request->username : $data->username;

            if ($request->hasFile('image')) {
                $data->image = imageUpload($request->file('image'));
            }

            if ($request->filled('password')) {
                $data->password = bcrypt($request->password);
                $data->hp       = Crypt::encryptString($request->password);
            }

            if ($data->save()) {
                return redirect()->back()->with(['response' => true, 'msg' => 'User update successful']);
            } else {
                return redirect()->back()->with(['response' => false, 'msg' => 'User update failed!']);
            }
        }


        $data  = User::find(auth()->id());
        $title = 'Update Profile';

        $query = Topup::with('gateway')->where('user_id', auth()->id());

        if ($q = trim($request->get('q', ''))) {
            $query->where(function ($s) use ($q) {
                $s->where('transaction_id', 'like', "%{$q}%")
                    ->orWhere('amount', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%")
                    ->orWhere('mobile', 'like', "%{$q}%")
                    ->orWhere('account', 'like', "%{$q}%")
                    ->orWhereHas('gateway', function ($g) use ($q) {
                        $g->where('name', 'like', "%{$q}%");
                    });
            });
        }

        $topups = $query->latest()->paginate(50, ['*'], 'deposit_page');

        $queryMB = MobileBanking::where('user_id', auth()->id());
        if ($qmb = trim($request->get('q_mb', ''))) {
            $queryMB->where(function ($s) use ($qmb) {
                $s->where('transaction_id', 'like', "%{$qmb}%")
                    ->orWhere('amount', 'like', "%{$qmb}%")
                    ->orWhere('type', 'like', "%{$qmb}%")
                    ->orWhere('operator', 'like', "%{$qmb}%")
                    ->orWhere('mobile', 'like', "%{$qmb}%");
            });
        }

        $mobileWithdraws = $queryMB->latest()->paginate(50, ['*'], 'mobile_withdraw_page');

        $queryBP = BankPay::where('user_id', auth()->id());
        if ($qbp = trim($request->get('q_bank', ''))) {
            $queryBP->where(function ($s) use ($qbp) {
                $s->where('transaction_id', 'like', "%{$qbp}%")
                    ->orWhere('amount', 'like', "%{$qbp}%")
                    ->orWhere('type', 'like', "%{$qbp}%")
                    ->orWhere('operator', 'like', "%{$qbp}%")
                    ->orWhere('mobile', 'like', "%{$qbp}%")
                    ->orWhere('number', 'like', "%{$qbp}%")
                    ->orWhere('branch', 'like', "%{$qbp}%")
                    ->orWhere('achold', 'like', "%{$qbp}%");
            });
        }

        $bankPays = $queryBP->latest()->paginate(5, ['*'], 'bank_withdraw_page');

        $queryMR = MobileRecharge::where('user_id', auth()->id());
        if ($qrc = trim($request->get('q_rc', ''))) {
            $queryMR->where(function ($s) use ($qrc) {
                $s->where('operator', 'like', "%{$qrc}%")
                    ->orWhere('type', 'like', "%{$qrc}%")
                    ->orWhere('mobile', 'like', "%{$qrc}%")
                    ->orWhere('amount', 'like', "%{$qrc}%");
            });
        }

        $mobileRecharges = $queryMR->latest()->paginate(50, ['*'], 'recharge_page');

        $showDeposit        = $request->get('show') === 'deposit';
        $showMobileWithdraw = $request->get('show') === 'mobile_withdraw';
        $showBankWithdraw   = $request->get('show') === 'bank_withdraw';
        $showRecharge = $request->get('show') === 'recharge';

        return view('frontend.profile', compact(
            'title',
            'data',
            'topups',
            'mobileWithdraws',
            'bankPays',
            'showDeposit',
            'showMobileWithdraw',
            'showBankWithdraw',
            'mobileRecharges',
            'showRecharge'
        ));
    }




    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $user = auth()->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = bcrypt($request->new_password);
        $user->hp = Crypt::encryptString($request->new_password);
        $user->save();

        return redirect()->back()->with(['response' => true, 'msg' => 'Password changed successfully.']);
    }


    //     public function chat()
    // {
    //     // Logged-in user
    //     $user = auth()->user();

    //     // If not logged in, redirect to login page
    //     if (!$user) {
    //         return redirect()->route('user.login');
    //     }

    //     // Get name and number (adjust field names to match your users table)
    //     $name   = urlencode($user->name ?? $user->full_name ?? 'Guest');
    //     $number = urlencode($user->phone ?? $user->phone_number ?? '');

    //     // Build external redirect URL
    //     $chatUrl = rtrim(env('GROUP_CHAT_URL'), '/');
    //     $redirectUrl = "{$chatUrl}?name={$name}&number={$number}";

    //     // Redirect to external chat
    //     return redirect()->away($redirectUrl);
    // }


    public function chat()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('user.login');
        }

        $name   = urlencode($user->name ?? $user->full_name ?? 'Guest');
        $number = urlencode($user->phone ?? $user->phone_number ?? '');
        $profile = '';

        if (!empty($user->image)) {
            // 🟢 Case 1: If image is Base64
            if (str_starts_with($user->image, 'data:image')) {
                try {
                    [$meta, $base64] = explode(',', $user->image, 2);
                    $extension = str_contains($meta, 'png') ? 'png' : 'jpg';

                    // Ensure public/images directory exists
                    $folder = public_path('images');
                    if (!File::exists($folder)) {
                        File::makeDirectory($folder, 0775, true);
                    }

                    // Generate unique filename
                    $fileName = time() . '_' . Str::random(6) . '.' . $extension;
                    $filePath = $folder . '/' . $fileName;

                    // Save decoded file into public/images/
                    File::put($filePath, base64_decode($base64));

                    // Create full public URL
                    $profile = urlencode(url('public/images/' . $fileName));
                } catch (\Exception $e) {
                    $profile = '';
                }
            }
            // 🟢 Case 2: If it's a stored local file path
            elseif (file_exists(public_path($user->image))) {
                $profile = urlencode(asset($user->image));
            }
            // 🟢 Case 3: Already a full URL
            else {
                $profile = urlencode($user->image);
            }
        }

        // External chat redirect
        $chatUrl = rtrim(env('GROUP_CHAT_URL'), '/');
        $redirectUrl = "{$chatUrl}?name={$name}&number={$number}&profile={$profile}";

        return redirect()->away($redirectUrl);
    }



    public function store(Request $req)
    {
        $req->validate([
            'name'    => 'required|string|max:255',
            'message' => 'nullable|string',
            'profile' => 'nullable|file|mimes:jpg,jpeg,png|max:10120', // 5 MB
            'audio'   => 'nullable|file|mimes:mp3,wav,webm,m4a|max:40480', // 20 MB
        ]);

        try {
            $multipart = [
                ['name' => 'name', 'contents' => $req->input('name')],
                ['name' => 'message', 'contents' => $req->input('message', '')],
            ];

            if ($req->hasFile('profile')) {
                $profileFile = $req->file('profile');
                $safeName = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $profileFile->getClientOriginalName());
                $multipart[] = [
                    'name'     => 'profile',
                    'contents' => fopen($profileFile->getRealPath(), 'r'),
                    'filename' => $safeName,
                    'headers'  => ['Content-Type' => $profileFile->getMimeType()],
                ];
            }

            if ($req->hasFile('audio')) {
                $audioFile = $req->file('audio');
                $safeName = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $audioFile->getClientOriginalName());
                $multipart[] = [
                    'name'     => 'audio',
                    'contents' => fopen($audioFile->getRealPath(), 'r'),
                    'filename' => $safeName,
                    'headers'  => ['Content-Type' => $audioFile->getMimeType()],
                ];
            }

            $resp = Http::timeout(60)
                ->asMultipart()
                ->withToken($this->token)
                ->post($this->base . '/api_group_message_post', $multipart);

            if ($resp->successful()) {
                $data = $resp->json();
                if (!empty($data['success'])) {
                    return response()->json([
                        'success' => true,
                        'message' => '✅ Message sent successfully',
                        'data'    => $data
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Remote API returned error ' . $resp->status(),
                'raw_body' => $resp->body(),
                'decoded'  => $resp->json(),
            ], $resp->status());
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Request failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }





    public function chatAdmin()
    {
        $title = 'Group Chat';
        $chatApiBase = env('CHAT_API_BASE', '');
        return view('backend.chat', compact(['title', 'chatApiBase']));
    }

    public function pending(Request $req)
    {
        $params = [
            'group_id' => $req->integer('group_id') ?: null,
            'limit'    => $req->integer('limit') ?: 50,
            'offset'   => $req->integer('offset') ?: 0,
            'since_id' => $req->integer('since_id') ?: 0,
            'token'    => $this->token,
        ];

        $resp = Http::timeout(15)->get(
            $this->base . '/api_group_messages_pending',
            array_filter($params, fn($v) => $v !== null)
        );

        $data = $resp->json();
        if (!isset($data['data']) || !is_array($data['data'])) {
            return response()->json($data, $resp->status());
        }

        // চ্যাট ইউজার আইডিগুলো সংগ্রহ করা
        $chatUserIds = collect($data['data'])->pluck('user_id')->filter()->unique()->all();

        // চ্যাট ডাটাবেস থেকে সরাসরি ছবি এবং নাম টেনে আনা
        $chatUsers = [];
        try {
            config(['database.connections.chat_db_sync' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'probasip_group',
                'username' => 'probasip_group',
                'password' => 'oM}dA[3f$)AU',
                'charset' => 'utf8mb4',
                'prefix' => 'gr_',
            ]]);

            $chatUsers = \DB::connection('chat_db_sync')
                ->table('site_users')
                ->whereIn('user_id', $chatUserIds)
                ->select('user_id', 'profile_picture')
                ->get()
                ->keyBy('user_id')
                ->toArray();
        } catch (\Exception $e) {
            // Error log: \Log::error($e->getMessage());
        }

        // ডাটা এনরিচ করা
        $data['data'] = array_map(function ($item) use ($chatUsers) {
            $uid = $item['user_id'] ?? null;

            // চ্যাট ডাটাবেস থেকে ছবি নেওয়া (সব ইউজারই এখন চ্যাট ডাটাবেসে আছে)
            if ($uid && isset($chatUsers[$uid])) {
                $item['user_image_path'] = $chatUsers[$uid]->profile_picture;
            } else {
                $item['user_image_path'] = null;
            }

            return $item;
        }, $data['data']);

        return response()->json($data, $resp->status());
    }


    /** Proxy: approve one or many message_ids */
    public function approve(Request $req)
    {
        $payload = [
            'message_ids' => $req->input('message_ids', []),
            'approver_id' => auth()->id(),
        ];

        $resp = Http::timeout(15)
            ->withToken($this->token)
            ->post($this->base . '/api_group_messages_approve', $payload);

        return response()->json($resp->json(), $resp->status());
    }

    /** Proxy: reject one or many message_ids (your API should update admin_status to 2 or delete) */
    public function reject(Request $req)
    {
        $payload = [
            'message_ids' => $req->input('message_ids', []),
            'approver_id' => auth()->id(),
        ];

        $resp = Http::timeout(15)
            ->withToken($this->token)
            ->post($this->base . '/api_group_messages_reject', $payload);

        return response()->json($resp->json(), $resp->status());
    }

    public function blockUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with(['response' => false, 'msg' => 'User not found!']);
        }

        if ($user->is_blocked == 0) {
            $phone = isset($user->phone) ? $user->phone : null;
            $email = isset($user->email) ? $user->email : null;

            BlockedUser::create([
                'phone' => $phone,
                'email' => $email,
            ]);
        } else {
            BlockedUser::where('phone', $user->phone)
                ->orWhere('email', $user->email)
                ->delete();
        }

        $user->is_blocked = $user->is_blocked == 0 ? 1 : 0;

        if ($user->save()) {
            $message = $user->is_blocked == 1 ? 'User Blocked Successfully' : 'User Unblocked Successfully';
            return redirect()->back()->with(['response' => true, 'msg' => $message]);
        } else {
            return redirect()->back()->with(['response' => false, 'msg' => 'Failed to update user status']);
        }
    }





    public function userstatus($id)
    {
        $user = User::find($id);
        if ($user->status == 1) {
            $user->status = 0;
        } else {
            $user->status = 1;
        }
        $user->save();
        return redirect()->back()->with(['response' => true, 'msg' => 'User Status update Successful!']);
    }

    public function userdelete($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return redirect()->route('user.list')->with(['response' => true, 'msg' => 'User delete Successful!']);
        } else {
            return redirect()->back()->with(['response' => false, 'msg' => 'User delete Fail!']);
        }
    }

    public function resolveChatAvatar($phone)
    {
        try {
            // চ্যাট ডাটাবেসে সরাসরি কানেকশন
            $pdo = new \PDO("mysql:host=localhost;dbname=probasip_group;charset=utf8mb4", "probasip_group", "oM}dA[3f$)AU");

            $stmt = $pdo->prepare("SELECT profile_picture FROM gr_site_users WHERE phone_number = ? LIMIT 1");
            $stmt->execute([$phone]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            $chatBase = "https://chat.probasipay.com/";

            if ($user && !empty($user['profile_picture'])) {
                // যদি ছবি থাকে তবে সেখানে রিডাইরেক্ট করবে
                return redirect($chatBase . $user['profile_picture']);
            }
        } catch (\Exception $e) {
            // এরর হলে ডিফল্ট ছবিতে যাবে
        }

        return redirect($chatBase . "assets/files/site_users/profile_pics/default.png");
    }
}
