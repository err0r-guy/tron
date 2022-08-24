@extends('admin.layouts.app')

@section('content')
    @include('admin.partials.heading')
    @include('admin.partials.alert')

    <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5>Profile Settings</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="offset-sm-1 col-md-10">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input name="name" type="text" class="form-control" required placeholder="Full Name"
                                value="{{ Auth::guard('admin')->user()->name ?? old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" readonly placeholder="Email Address"
                                value="{{ Auth::guard('admin')->user()->email ?? old('email') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="text-center col-sm-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.profile.password') }}">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5>Change Password</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="offset-sm-1 col-md-10">
                        <div>
                            <small class="mt-2 text-facebook">
                                Please leave empty if you dont want to change pasword.
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input name="current_password" type="password" class="form-control" required placeholder="Current Password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input name="password" type="password" class="form-control" required placeholder="New Password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control" required placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="text-center col-sm-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
