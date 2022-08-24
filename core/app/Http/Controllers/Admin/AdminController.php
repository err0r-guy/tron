<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Plan;
use App\Models\Settings;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Admin Dashboard';
        $data['countWithdraw'] = Withdraw::count();
        $data['countMessage'] = Contact::count();
        $data['countUser'] = User::count();
        $data['countAdmin'] = Admin::count();
        $data['countPlan'] = Plan::count();
        $data['countWithdrawal'] = Withdraw::count();
        $data['countDeposit'] = Deposit::count();
        return view('admin.dashboard', $data);
    }

    public function settings()
    {
        $data['page_title'] = 'Admin Settings';
        return view('admin.settings', $data);
    }

    public function frontends()
    {
        $data['page_title'] = 'Site Pages Frontend Settings';
        $data['homeSection'] = Frontend::where('key', 'home.section')->first();
        $data['affiliate'] = Frontend::where('key', 'affiliate')->first();
        return view('admin.frontends', $data);
    }

    public function frontendsUpdate(Request $request, $key){
        $validated = $request->validate([
            'title'=>'required|string',
            'body'=>'required|string'
        ]);

        $data = Frontend::where('key', $key)->first();
        $data->value = [
            'title'=>$request->title,
            'body'=>$request->body
        ];
        $data->save();

        return back()->with('success', 'Edited Successfully');
    }

    public function settingsPost(Request $request)
    {
        $validated = $request->validate([
            'sitename' => 'required|string',
            'description' => 'required',
            'keywords' => 'required',
            'logo' => 'image',
            'favicon' => 'image',
            'min_withdraw' => 'required',
            'max_withdraw' => 'required',
            'ref_commission' => 'required|numeric',
            'charge' => 'required',
            'currency' => 'required',
            'cur_sym' => 'required',
            'wallet_min' => 'required|integer',
            'wallet_max' => 'required|integer',
        ]);

        $data = Settings::find(settings('id'));
        $data->sitename = $request->sitename;
        $data->description = $request->description;
        $data->keywords = $request->keywords;
        if ($request->hasFile('logo')) {
            $data->logo = uploadFile($request->file('logo'), 'assets/uploads');
        }
        if ($request->hasFile('favicon')) {
            $data->favicon = uploadFile($request->file('favicon'), 'assets/uploads');
        }
        $data->address = $request->address;
        $data->telephone = $request->telephone;
        $data->telegram = $request->telegram;
        $data->min_withdraw = $request->min_withdraw;
        $data->max_withdraw = $request->max_withdraw;
        $data->ref_commission = $request->ref_commission;
        $data->charge = $request->charge;
        $data->currency = $request->currency;
        $data->cur_sym = $request->cur_sym;
        $data->wallet_min = $request->wallet_min;
        $data->wallet_max = $request->wallet_max;
        $data->pub_key = $request->pub_key;
        $data->pri_key = $request->pri_key;
        $data->trongrid_api = $request->trongrid_api;
        $data->cp_pub_key = $request->cp_pub_key;
        $data->cp_pri_key = $request->cp_pri_key;
        $data->cp_merchant = $request->cp_merchant;
        $data->coin_hash = $request->coin_hash;
        $data->nw_key = $request->nw_key;
        $data->gateway_charge = $request->gateway_charge;
        $data->save();

        return redirect(route('admin.settings'))->with('success', 'Updated successfully');
    }


    public function profile()
    {
        $data['page_title'] = 'Profile Settings';
        return view('admin.profile', $data);
    }

    public function profilePost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Admin::find(Auth::guard('admin')->user()->id);
        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function profilePasswordPost(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|min:8',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'current_password.required' => 'Old password is required',
            'current_password.min' => 'Old password needs to have at least 8 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password needs to have at least 8 characters',
            'password_confirmation.required' => 'Passwords do not match'
        ]);

        $currUser = Auth::guard('admin')->user();

        $current_password = $currUser->password;
        if (!(Hash::check($request->input('current_password'), $current_password))) {
            return back()->withErrors('Please enter correct current password.');
        }

        $user_id = $currUser->id;
        $obj_user = Admin::find($user_id);
        $obj_user->password = Hash::make($request->input('password'));
        $obj_user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
