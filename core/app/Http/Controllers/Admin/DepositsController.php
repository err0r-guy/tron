<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;

class DepositsController extends Controller
{
    public function index()
    {
        $page_title = 'Deposits management';
        $datas = Deposit::all();
        return view('admin.withdraw.index', compact('page_title', 'datas'));
    }

    public function destroy($id)
    {
        $data = deposit::findOrFail($id);
        $data->delete();

        return redirect(route('admin.deposits'))->with('Deleted successfully');
    }
}
