<?php

namespace App\Http\Controllers;

use App\Models\BankPay;
use App\Models\MobileBanking;
use App\Models\MobileRecharge;
use App\Models\Remittance;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //

    public function index()
    {

        return view('frontend.home');
    }

    public function test()
    {

        return view('frontend.home');
    }

    public function sendotp()
    {

        $username = auth()->user()->name;
        $phone = auth()->user()->phone;
        $otp = rand(10000, 99999);
        if ($phone) {
            $request_data = [
                "msg" => "Dear $username, your OTP  is $otp. Moono Express",
                "to" => '88' . $phone,
                "api_key" => "08Zm8HiG9H9cldxBsoVx62Ej4SbvdYy2JPfX25m2",
            ];
            $response = Http::get("https://api.sms.net.bd/sendsms", $request_data);
            $response = json_decode($response);
            if ($response->error == 0) {
                auth()->user()->update(['otp' => $otp]);
                return back()->with(['response' => true, 'msg' => 'OTP sent successfully']);
            } else {
                return back()->with(['response' => false, 'msg' => 'OTP sent failed']);
            }
        }
    }

    public function forget_password(Request $request)
    {

        $request->validate([
            'phone' => 'required|exists:users,phone'
        ]);

        $user = User::where('phone', $request->phone)->first();

        $username = $user->name;
        $phone = $user->phone;
        $otp = rand(10000, 99999);
        if ($phone) {
            $request_data = [
                "msg" => "Dear $username, your OTP  is $otp. Moono Express",
                "to" => '88' . $phone,
                "api_key" => "08Zm8HiG9H9cldxBsoVx62Ej4SbvdYy2JPfX25m2",
            ];
            $response = Http::get("https://api.sms.net.bd/sendsms", $request_data);
            $response = json_decode($response);
            if ($response->error == 0) {
                $user->update(['otp' => $otp]);
                return redirect(route('forget.otp', $phone))->with(['response' => true, 'msg' => 'OTP sent successfully']);
            } else {
                return back()->with(['response' => false, 'msg' => 'OTP sent failed']);
            }
        }
    }


    public function reset_password(Request $request, $opt = null, $phone = null)
    {

        if ($request->post()) {
            $request->validate([
                'phone' => 'required|exists:users,phone',
                'password' => 'required|confirmed',
            ]);

            $user = User::where('phone', $request->phone)->first();
            $user->password = bcrypt($request->password);
            if ($user->save()) {
                return redirect(route('user.login'))->with(['response' => true, 'msg' => 'Password reset Successfull']);
            } else {
                return back()->with(['response' => false, 'msg' => 'Password reset Fail']);
            }
        }

        if ($phone) {
            $user = User::where('phone', $phone)->first();
            if ($user->otp == $opt) {
                return view('auth.reset-password', compact('phone'));
            } else {
                return back()->with(['response' => false, 'msg' => 'Invalid OTP']);
            }
        }
    }
    public function otp($phone = null)
    {

        return view('auth.otp', compact('phone'));
    }

    public function blocked($phone = null)
    {

        return view('blocked');
    }

    public function otpvarify(Request $request)
    {

        $request->validate([
            'otp' => 'required'
        ]);
        if ($request->phone) {
            $user = User::where('phone', $request->phone)->first();
            if ($user->otp == $request->otp) {

                return redirect()->route('reset.password', [$request->otp, $request->phone]);
            } else {
                return back()->with(['response' => false, 'msg' => 'Invalid OTP']);
            }
        } else {
            if (auth()->user()->otp == $request->otp) {
                auth()->user()->update(['otp' => null, 'email_verified_at' => now(), 'otp_varify' => 1]);
                return redirect()->route('index');
            } else {
                return back()->with(['response' => false, 'msg' => 'Invalid OTP']);
            }
        }
    }


    public function getData(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users,phone'],
            'password' => ['required'],
            'location' => ['required'],
        ], [
            'name.required' => 'আপনার নাম দিন',
            'email.required' => 'আপনার নাম্বার লিখুন',
            'email.unique' => 'এই নাম্বার একাউন্ট খোলা আছে',
            'location' => 'আপনার দেশ সিলেক্ট করুন'
        ]);
        Session::put('register-info', $request->post());
        Cache::put('register-password-' . $request->email, $request->password, now()->addMinutes(30));
        return redirect()->route('register.image');
    }


    public function getImage(Request $request)
    {
        if ($request->post()) {
           $data = $request->post();

            if (!empty($data['photo'])) {
                $data['photo'] = $this->saveBase64Image($data['photo']); // saves file like profile update
            }

            Session::put('register-info', $data);
            return redirect()->route('register.final');
        }

        return view('auth.photo');
    }

    private function saveBase64Image($base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $data = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('Invalid image type');
            }

            $data = base64_decode($data);
            if ($data === false) throw new \Exception('base64_decode failed');
        } else {
            throw new \Exception('Invalid Base64 string');
        }

        $fileName = time() . rand(1, 100) . '.' . $type;
        $destinationPath = public_path('fileManager'); // same folder

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        file_put_contents($destinationPath . '/' . $fileName, $data);

        return 'fileManager/' . $fileName;
    }

    public function getFinal(Request $request)
    {

        if ($request->post()) {

            $request->validate([
                'pin' => 'required|digits:4',
                'confirm_pin' => 'required|same:pin'
            ], [
                'pin.required' => 'পিন দিন',
                'pin.digits' => '৪ ডিজিট পিন দিতে হবে',
                'confirm_pin.same' => 'পিন মিলছে না'
            ]);

            $data = Session::get('register-info');

            // store pin in cache same way as password
            Cache::put('register-pin-' . $data['email'], $request->pin, now()->addMinutes(30));

            Session::put('register-info', array_merge($data, $request->post()));

            return redirect()->route('register.agree');
        }

        return view('auth.final');
    }

    public function agree(Request $request)
    {
        if ($request->post()) {
            $data = Session::get('register-info');

            if (!$data) {
                return redirect()->route('register.data')->with([
                    'msg' => 'Registration session expired, start again',
                    'response' => false
                ]);
            }

            $cachedPassword = Cache::get('register-password-' . $data['email']);
            $cachedPin = Cache::get('register-pin-' . $data['email']);

            $user = new User();
            $user->name = $data['name'];
            $user->phone = $data['email'];
            $user->location = $data['location'];
            $user->image = $data['photo'];
            $user->role = $data['role'];
            $user->type = $data['type'];

            $user->password = $cachedPassword ? bcrypt($cachedPassword) : null;
            $user->pin = $cachedPin ? bcrypt($cachedPin) : null;

            $user->status = 1;
            $user->agree = 1;

            $user->save();

            Auth::login($user);

            Cache::forget('register-password-' . $data['email']);
            Cache::forget('register-pin-' . $data['email']);
            Session::forget('register-info');

            return redirect()->route('user.index')->with([
                'msg' => 'Registration Successful',
                'response' => true
            ]);
        }

        return view('auth.agreement');
    }




    public function contact()
    {

        return view('frontend.contact');
    }

    public function history()
    {
        $user = auth()->user();

        $bankPays = BankPay::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'title' => 'Bank Withdraw',
                'operator' => $item->operator,
                'amount' => $item->amount,
                'mobile' => $item->mobile,
                'transaction_id' => $item->transaction_id,
                'type' => 'debit',
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $mobileBanking = MobileBanking::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'title' => 'Mobile Banking Transfer',
                'operator' => $item->operator,
                'amount' => $item->amount,
                'mobile' => $item->mobile,
                'transaction_id' => $item->transaction_id,
                'type' => 'debit',
                't_type' => $item->type,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $recharges = MobileRecharge::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'title' => 'Mobile Recharge',
                'operator' => $item->operator,
                'amount' => $item->amount,
                'mobile' => $item->mobile,
                'r_type' => $item->type,
                'type' => 'debit',
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $remittances = Remittance::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'title' => 'Remittance',
                'operator' => $item->operator,
                'amount' => $item->amount,
                'transaction_id' => $item->transaction_id,
                'type' => 'debit',
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $topups = Topup::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'title' => 'Deposit',
                'amount' => $item->amount,
                'type' => 'credit',
                'transaction_id' => $item->transaction_id,
                'operator' => $item->gateway->name ?? null,
                'details' => $item->gateway->details ?? null,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $transactions = collect()
            ->merge($bankPays)
            ->merge($mobileBanking)
            ->merge($recharges)
            ->merge($remittances)
            ->merge($topups)
            ->sortByDesc('date')
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item['date'])->format('Y-m-d');
            });

        return view('frontend.history', compact('transactions'));
    }
}