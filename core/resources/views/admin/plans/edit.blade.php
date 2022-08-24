@extends('admin.layouts.app')

@section('content')
    @include('admin.partials.heading')

    <div class="card">
        <div class="card-header">
            <h5>{{ $page_title }}</h5>
        </div>
        <div class="card-block">
            <form method="POST" action="{{ route('admin.plans.update', $data->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name" class="col-sm-1-12 col-form-label">Plan Name</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name') ?? $data->name }}" id="name" placeholder="Plan Name">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price" class="col-sm-1-12 col-form-label">Price</label>
                        <div class="col-sm-1-12">
                            <input type="number" class="form-control" name="price"
                                value="{{ old('price') ?? $data->price }}" id="price"
                                placeholder="Plan Price (0 = Free)">
                        </div>
                    </div>
                    <div class="form-group form-check col-md-6">
                        <label for="is_default" class="col-sm-1-12 col-form-label m-l-15 form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_default" id="is_default"
                                {{ old('is_default') ?? $data->is_default ? 'checked' : '' }}>
                            Default Plan (Free Plan and give 0 as
                            Price)
                        </label>
                    </div>
                    <div class="form-group col-md-6">

                    </div>
                    <div class="form-group col-md-4">
                        <label for="period" class="col-sm-1-12 col-form-label">Duration (months)</label>
                        <div class="col-sm-1-12">
                            <input type="number" class="form-control" name="period"
                                value="{{ old('period') ?? $data->period }}" id="period"
                                placeholder="Duration (months)">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="earning_rate" class="col-sm-1-12 col-form-label">Earning Rate (0.00001000
                            {{ $settings->cur_sym }}/hour)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="earning_rate"
                                value="{{ old('earning_rate') ?? $data->earning_rate }}" id="earning_rate"
                                placeholder="Earning Rate (0.00001000)">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="speed" class="col-sm-1-12 col-form-label">Mining Speed (hours)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="speed"
                                value="{{ old('speed') ?? $data->speed }}" id="speed"
                                placeholder="Mining Speed (hours)">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="image" class="col-sm-1-12 col-form-label">Image</label>
                        <div class="col-sm-1-12">
                            <input type="file" class="form-control" name="image" id="image"
                                placeholder="Plan Image">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
            @include('admin.partials.datecal')
        </div>
    </div>
@endsection
