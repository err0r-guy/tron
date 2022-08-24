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
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="basic-btn" class="table table-striped table-hover table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User Wallet</th>
                            <th>Amount</th>
                            <th>TxID</th>
                            <th>Status</th>
                            <th>Date</th>
                            {{--  <th>Options</th>  --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->user->username }}</td>
                                <td>{{ $data->amount . ' ' . $settings->cur_sym }}</td>
                                <td>{{ $data->trx }}</td>
                                <td>{{ $data->status === 0 ? 'Pending' : ($data->status === 1 ? 'Paid' : 'Canceled') }}</td>
                                <td>{{ $data->created_at }}</td>
                                {{--  <td>
                                    <button type="button" class="btn btn-danger delBtn" data-toggle="modal"
                                        data-target="#delModal" data-delTitle="{{ $data->trx }}"
                                        data-delAction="{{ route('admin.withdrawals.destroy', $data->id) }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>  --}}
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>User Wallet</th>
                            <th>Amount</th>
                            <th>TxID</th>
                            <th>Status</th>
                            <th>Date</th>
                            {{--  <th>Options</th>  --}}
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{--  @include('admin.partials.modal')  --}}
@endsection
