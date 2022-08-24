<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Plans management';
        $datas = Plan::all();
        return view('admin.plans.index', compact('page_title', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Create Plan';
        return view('admin.plans.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'period' => 'required|integer',
            'earning_rate' => 'required',
            'speed' => 'required|integer',
            'image' => 'required|image',
        ]);

        $plan = new Plan;
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->is_default = $request->is_default ? 1 : 0;
        $plan->period = $request->period;
        $plan->earning_rate = $request->earning_rate;
        $plan->speed = $request->speed;
        if ($request->hasFile('image')) {
            $plan->image = uploadFile($request->file('image'), 'assets/uploads');
        } else {
            $plan->image = 'assets/images/photo-sm-a.jpg';
        }
        $plan->status = 1;
        $plan->save();

        return redirect(route('admin.plans.index'))->with('success', 'succPlan added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route('admin.plans.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Edit Plan';
        $data = Plan::find($id);
        return view('admin.plans.edit', compact('page_title', 'data'));
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
            'name' => 'required',
            'price' => 'required',
            'period' => 'required|integer',
            'earning_rate' => 'required',
            'speed' => 'required',
            'image' => 'image',
        ]);

        $plan = Plan::find($id);
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->is_default = $request->is_default ? 1 : 0;
        $plan->period = $request->period;
        $plan->earning_rate = $request->earning_rate;
        $plan->speed = $request->speed;
        if ($request->hasFile('image')) {
            $plan->image = uploadFile($request->file('image'), 'assets/uploads', $plan->image);
        }
        $plan->save();

        return redirect(route('admin.plans.index'))->with('success', 'Plan edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Plan::find($id);
        removeFile($data->image);
        $data->delete();

        return redirect(route('admin.plans.index'))->with('success', 'Plan deleted successfully');
    }

    public function approve($id)
    {
        $data = Plan::find($id);
        $data->status = 1;
        $data->save();

        return redirect(route('admin.plans.index'))->with('success', 'Approved successfully');
    }

    public function unapprove($id)
    {
        $data = Plan::find($id);
        $data->status = 0;
        $data->save();

        return redirect(route('admin.plans.index'))->with('success', 'Unapproved successfully');
    }
}
