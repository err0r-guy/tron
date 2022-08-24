<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Deposit;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (request()->has('ref')) {
            session()->put('reference', request()->ref);
        }

        $page_title = 'Best Cloud minig website';
        return view('index', compact('page_title'));
    }

    public function affiliate()
    {
        $page_title = 'Affiliate Program';
        return view('affiliate', compact('page_title'));
    }

    public function payouts()
    {
        $data['page_title'] = 'Payouts';
        $data['deposits'] = Deposit::where('status', 1)->orderBy('created_at', 'DESC')->limit(10)->get();
        $data['withdrawals'] = Withdraw::where('status', 1)->orderBy('created_at', 'DESC')->limit(10)->get();
        return view('payouts', $data);
    }

    public function faq()
    {
        $page_title = 'FAQ';
        return view('faq', compact('page_title'));
    }

    public function contact()
    {
        $page_title = 'Contact';
        return view('contact', compact('page_title'));
    }

    public function contactInsert(Request $request)
    {
        $validated = $request->validate([
            'contact_name' => 'required|max:191',
            'contact_email' => 'required|email|max:191',
            'contact_subject' => 'required|max:100',
            'contact_message' => 'required',
        ]);

        $data = new Contact;
        $data->name = $request->contact_name;
        $data->email = $request->contact_email;
        $data->subject = $request->contact_name;
        $data->message = $request->contact_message;
        $data->save();

        return back()->with('success', 'Message sent successfully.');
    }
}
