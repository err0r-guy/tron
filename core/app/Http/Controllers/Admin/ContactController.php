<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $page_title = 'Contact Messages management';
        $datas = Contact::all();
        return view('admin.contact.index', compact('page_title', 'datas'));
    }

    public function destroy($id)
    {
        $data = Contact::findOrFail($id);
        $data->delete();

        return redirect(route('admin.contacts'))->with('success', 'Deleted successfully');
    }

}
