<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\slider;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function general(Request $request)
    {
        if ($request->isMethod('post')) {
            try {

                $request->validate([
                ]);

                $data = GeneralSetting::first() ?? new GeneralSetting();

                $data->company_name = $request->company_name ?: $data->company_name;
                $data->hq_address = $request->hq_address;
                $data->factory_address = $request->factory_address;
                $data->phone = $request->phone;
                $data->email = $request->email;
                $data->website = $request->website;
                $data->usd_rate = $request->usd_rate;
                $data->status = $request->status;

                if ($request->hasFile('logo')) {
                    $data->logo = imageUpload($request->file('logo'));
                }

                if ($request->hasFile('icon')) {
                    $data->icon = imageUpload($request->file('icon'));
                }

                $data->block_bd_vpn = $request->has('block_bd_vpn') ? 1 : 0;

                if ($data->save()) {
                    return redirect(route('setting.general'))->with([
                        'response' => true,
                        'msg' => 'General Settings updated successfully'
                    ]);
                } else {
                    return redirect(route('setting.general'))->with([
                        'response' => false,
                        'msg' => 'Failed to update General Settings!'
                    ]);
                }

            } catch (\Throwable $th) {
                return redirect(route('setting.general'))->with([
                    'response' => false,
                    'msg' => $th->getMessage()
                ]);
            }
        }

        $data = GeneralSetting::first();
        $title = 'General Setting';
        return view('backend.setting.general', compact(['title', 'data']));
    }

    public function mobilebanking(Request $request, $id = null)
    {
        // Handle mobile banking logic here
        if ($request->isMethod('post')) {
            $data = $id ? Account::find($id) : new Account();
            $data->name = $request->name;
            $data->details = $request->details;
            $data->type = 'Mobile Banking';
            if ($data->save()) {
                return redirect(route('mobilebanking'))->with(['response' => true, 'msg' => 'Mobile Banking Create/update Success']);
            } else {
                return redirect(route('mobilebanking'))->with(['response' => false, 'msg' => 'Mobile Banking Create/update Fail!']);
            }
        }

        $data = $id ? Account::find($id) : null;
   
        $title = $id ? 'Edit Mobile Banking' : 'Mobile Banking';
        $list = Account::where('type', 'Mobile Banking')->get();
        return view('backend.setting.mobilebanking', compact('title', 'data', 'list'));
    }

    public function mobilebankingdelete($id)
    {
        $mobileBanking = Account::find($id);
        if ($mobileBanking && $mobileBanking->delete()) {
            return redirect(route('mobilebanking'))->with(['response' => true, 'msg' => 'Mobile Banking deleted successfully']);
        }
        return redirect(route('mobilebanking'))->with(['response' => false, 'msg' => 'Failed to delete Mobile Banking']);
    }

    public function bank(Request $request, $id = null)
    {
        // Handle bank logic here
        if ($request->isMethod('post')) {
            $data = $id ? Account::find($id) : new Account();
            $data->name = $request->name;
            $data->details = $request->details;
            $data->type = 'Bank';
            if ($data->save()) {
                return redirect(route('bank'))->with(['response' => true, 'msg' => 'Bank Create/update Success']);
            } else {
                return redirect(route('bank'))->with(['response' => false, 'msg' => 'Bank Create/update Fail!']);
            }
        }

        $data = $id ? Account::find($id) : null;
        $title = $id ? 'Edit Bank' : 'Bank';
        $list = Account::where('type', 'Bank')->get();
        return view('backend.setting.bank', compact('title', 'data', 'list'));
    }

    public function bankedelete($id)
    {
        $bank = Account::find($id);
        if ($bank && $bank->delete()) {
            return redirect(route('bank'))->with(['response' => true, 'msg' => 'Bank deleted successfully']);
        }
        return redirect(route('bank'))->with(['response' => false, 'msg' => 'Failed to delete bank']);
    }

    public function country(Request $request, $id = null)
    {
        // Handle country logic here
        if ($request->isMethod('post')) {
            $data = $id ? Country::find($id) : new Country();
            $data->name = $request->name;
            $data->code = $request->code;
            $data->rate = $request->rate;
            $data->currency = $request->currency;
            if ($request->hasFile('image')) {
                $data->image = imageUpload($request->file('image'));
            }
            
            if ($data->save()) {
                return redirect(route('country'))->with(['response' => true, 'msg' => 'Country Create/update Success']);
            } else {
                return redirect(route('country'))->with(['response' => false, 'msg' => 'Country Create/update Fail!']);
            }
        }
        $data = $id ? Country::find($id) : null;
        $title = $id ? 'Edit Country' : 'Country';
        $list = Country::orderByRaw('CASE WHEN rate IS NOT NULL AND rate != "" THEN 0 ELSE 1 END')
               ->get();
        return view('backend.setting.country', compact('title', 'data', 'list'));
    }

    public function countrydelete($id)
    {
        $country = Country::find($id);
        if ($country && $country->delete()) {
            return redirect(route('country'))->with(['response' => true, 'msg' => 'Country deleted successfully']);
        }
        return redirect(route('country'))->with(['response' => false, 'msg' => 'Failed to delete country']);
    }

    public function slider(Request $request, $id = null)
    {
        // Handle slider logic here
        if ($request->isMethod('post')) {
            $request->validate([
                'image' => 'required|image|max:2048',
            ]);
            $data = $id ? slider::find($id) : new Slider();

            if ($request->hasFile('image')) {
                $data->image = imageUpload($request->file('image'));
            }
            if ($data->save()) {
                return redirect(route('slider'))->with(['response' => true, 'msg' => 'Slider Create/update Success']);
            } else {
                return redirect(route('slider'))->with(['response' => false, 'msg' => 'Slider Create/update Fail!']);
            }
        }

        $data = $id ? Slider::find($id) : null;
        $title = $id ? 'Edit Slider' : 'Slider';
        $list = Slider::all();
        return view('backend.setting.slider', compact('title', 'data','list'));
    }

    public function sliderdelete($id)
    {
        $slider = Slider::find($id);
        if ($slider && $slider->delete()) {
            return redirect(route('slider'))->with(['response' => true, 'msg' => 'Slider deleted successfully']);
        }
        return redirect(route('slider'))->with(['response' => false, 'msg' => 'Failed to delete slider']);
    }
}