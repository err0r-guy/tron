@extends('layouts.app')

@section('banner')
    <!-- Banner/Slider -->
    <div class="page-head section row-vm light">
        <div class="imagebg">
            <img src="{{ asset('assets/images/user-inside.jpg') }}" alt="page-head">
        </div>
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2>{{ $page_title }}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- #end Banner/Slider -->
@endsection

@section('content')
    <div class="section section-pad">
        <div class="container">
            <div class="row">
                <h2>Update Account Details</h2>
                <div class="row text-center">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="{{ route('user.profile') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Your Email" value="{{ Auth::user()->email }}" required />
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Leave blank to do not change" />
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" placeholder="Leave blank to do not change" />
                            </div>
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control"
                                    placeholder="Your current password" required />
                            </div>
                            <button type="submit" class="btn btn-primary ud-btn"><i class="fa fa-save"></i> Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
