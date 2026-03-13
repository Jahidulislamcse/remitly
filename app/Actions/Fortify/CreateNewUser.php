<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {


        $image = $input['photo'];




        if (filter_var($input['email'], FILTER_VALIDATE_EMAIL) !== false) {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'unique:users,email'],
                'password' => ['required'],
            ],['email'=>'This Phone Number already registared'])->validate();

            return User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'location' => @$input['location'],
                'password' => Hash::make($input['password']),
                'role' => $input['role'],
                'image' => $image,
                'status' => 0,
                'type' => $input['type'],
                'pin' => $input['pin'],
            ]);
        } else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'unique:users,phone'],
                'password' => ['required'],
            ],['email'=>'This Phone Number already registared'])->validate();
            $otp = rand(10000, 99999);


            $user = User::create([
                'name' => $input['name'],
                'phone' => @$input['email'],
                'location' => @$input['location'],
                'otp' => @$otp,
                'password' => Hash::make($input['password']),
                'role' => $input['role'],
                'image' => $image,
                'status' => 0,
                'type' => $input['type'],
                'pin' => $input['pin'],
            ]);

            // if ($user->phone) {
            //     $username = $user->name;
            //     $phone = $user->phone;

            //     $request_data = [
            //         "msg" => "Dear $username, your OTP  is $otp. Al-modina",
            //         "to" => $input['location'] . $phone,
            //         "api_key" => "08Zm8HiG9H9cldxBsoVx62Ej4SbvdYy2JPfX25m2",
            //     ];
            //     $response = Http::get("https://api.sms.net.bd/sendsms", $request_data);
            //     $response = json_decode($response);


            // }

            return $user;
        }
    }
}
