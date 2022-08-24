<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Users management';
        $datas = User::all();
        return view('admin.users.index', compact('page_title', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect(route('admin.users.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = 'User details';
        $data = User::find($id);
        return view('admin.users.show', compact('page_title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Edit User details';
        $data = User::find($id);
        return view('admin.users.edit', compact('page_title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'required',
            'email' => 'email',
            'balance' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->save();

        return redirect(route('admin.users.index'))->with('success', 'Edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect(route('admin.users.index'))->with('success', 'Deleted successfully');
    }

    public function approve($id)
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();

        return redirect(route('admin.users.index'))->with('success', 'Approved successfully');
    }

    public function unapprove($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();

        return redirect(route('admin.users.index'))->with('success', 'Unapproved successfully');
    }
}
