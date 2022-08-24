@extends('admin.layouts.app')

@section('addCss')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/assets/pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/assets/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('addJs')
    <!-- data-table js -->
    <script src="{{ asset('admin/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/data-table/js/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/data-table/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('admin/assets/pages/data-table/extensions/buttons/js/extension-btns-custom.js') }}"></script>
@endsection

@section('content')
    @include('admin.partials.heading')

    <div class="card">
        <div class="card-header">
            <h5>{{ $page_title }}</h5>
            <div class="float-right">
                <a class="btn btn-success round-btn" href="{{ route('admin.admins.create') }}"><i class="fa fa-plus"
                        aria-hidden="true"></i> Add</a>
            </div>
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="basic-btn" class="table table-striped table-hover table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            {{--  <th>Status</th>  --}}
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                {{--  <td>
                                    <a class="btn"
                                        href="{{ $data->status ? route('admin.admins.unapprove', $data->id) : route('admin.admins.approve', $data->id) }}">
                                        <span
                                            class="label label-{{ $data->status ? 'success' : 'inverse' }}">{{ $data->status ? 'Active' : 'Inactive' }}</span>
                                    </a>
                                </td>  --}}
                                <td class="btn-sm">
                                    {{--  <a class="btn btn-primary" href="{{ route('admin.admins.edit', $data->id) }}"><i
                                            class="fa fa-edit" aria-hidden="true"></i></a>  --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            {{--  <th>Status</th>  --}}
                            <th>Options</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
