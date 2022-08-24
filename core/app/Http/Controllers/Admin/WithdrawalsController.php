<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawalsController extends Controller
{
    public function index()
    {
        $page_title = 'Withdrawal management';
        $datas = Withdraw::all();
        return view('admin.withdraw.index', compact('page_title', 'datas'));
    }

    public function destroy($id)
    {
        $data = Withdraw::findOrFail($id);
        $data->delete();

        return redirect(route('admin.withdrawals'))->with('success', 'Deleted successfully');
    }
}
