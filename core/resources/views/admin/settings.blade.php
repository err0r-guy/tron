@extends('admin.layouts.app')

@section('content')
    @include('admin.partials.heading')

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5>General Settings</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="sitename" class="col-sm-1-12 col-form-label">Site Name</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="sitename"
                                value="{{ old('sitename') ?? $settings->sitename }}" id="sitename"
                                placeholder="Site Name">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description" class="col-sm-1-12 col-form-label">Site Description</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="description"
                                value="{{ old('description') ?? $settings->description }}" id="description"
                                placeholder="Site description">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="keywords" class="col-sm-1-12 col-form-label">Site Keywords (Seperated by ,)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="keywords"
                                value="{{ old('keywords') ?? $settings->keywords }}" id="keywords"
                                placeholder="Site Keywords">
                        </div>
                    </div>
                    <div class="form-group col-md-6">

                    </div>
                    <div class="form-group col-md-6">
                        <label for="logo" class="col-sm-1-12 col-form-label">Site Logo</label>
                        <div class="col-sm-1-12">
                            <input type="file" class="form-control" name="logo" id="logo"
                                placeholder="Site Logo">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="favicon" class="col-sm-1-12 col-form-label">Site Favicon</label>
                        <div class="col-sm-1-12">
                            <input type="file" class="form-control" name="favicon" id="favicon"
                                placeholder="Site Favicon">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address" class="col-sm-1-12 col-form-label">Address (would be shown in site footer)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="address"
                                value="{{ old('address') ?? $settings->address }}" id="address"
                                placeholder="Address">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telephone" class="col-sm-1-12 col-form-label">Telephone (would be shown in site footer)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="telephone"
                                value="{{ old('telephone') ?? $settings->telephone }}" id="telephone"
                                placeholder="Telephone">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Social Settings</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="telegram" class="col-sm-1-12 col-form-label">Telegram</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="telegram"
                                value="{{ old('telegram') ?? $settings->telegram }}" id="telegram"
                                placeholder="Telegram Url">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Limit & Currency Settings</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="min_withdraw" class="col-sm-1-12 col-form-label">Min. Withdrawal</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="min_withdraw"
                                value="{{ old('min_withdraw') ?? $settings->min_withdraw }}" id="min_withdraw"
                                placeholder="0.00000000">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="max_withdraw" class="col-sm-1-12 col-form-label">Max. Withdrawal</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="max_withdraw"
                                value="{{ old('max_withdraw') ?? $settings->max_withdraw }}" id="max_withdraw"
                                placeholder="0.00000000">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ref_commission" class="col-sm-1-12 col-form-label">Refferal Commission (%)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="ref_commission"
                                value="{{ old('ref_commission') ?? $settings->ref_commission }}" id="ref_commission"
                                placeholder="Refferal Commission (%)">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="charge" class="col-sm-1-12 col-form-label">Withdrawal Charge (in %)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="charge"
                                value="{{ old('charge') ?? $settings->charge }}" id="charge"
                                placeholder="Withdrawal Charge">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="currency" class="col-sm-1-12 col-form-label">Currency Name</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="currency"
                                value="{{ old('currency') ?? $settings->currency }}" id="currency"
                                placeholder="Currency Name">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cur_sym" class="col-sm-1-12 col-form-label">Currency Code</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="cur_sym"
                                value="{{ old('cur_sym') ?? $settings->cur_sym }}" id="cur_sym"
                                placeholder="Currency Code">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="wallet_min" class="col-sm-1-12 col-form-label">Wallet Address Min. Characters</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="wallet_min"
                                value="{{ old('wallet_min') ?? $settings->wallet_min }}" id="wallet_min"
                                placeholder="Wallet Address Min. Characters">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="wallet_max" class="col-sm-1-12 col-form-label">Wallet Address Max. Characters</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="wallet_max"
                                value="{{ old('wallet_max') ?? $settings->wallet_max }}" id="wallet_max"
                                placeholder="Wallet Address Max. Characters">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>TronGrid Settings</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="pub_key" class="col-sm-1-12 col-form-label">Public Key</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="pub_key"
                                value="{{ old('pub_key') ?? $settings->pub_key }}" id="pub_key"
                                placeholder="Public Key">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pri_key" class="col-sm-1-12 col-form-label">Private Key</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="pri_key"
                                value="{{ old('pri_key') ?? $settings->pri_key }}" id="pri_key"
                                placeholder="Private Key">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="trongrid_api" class="col-sm-1-12 col-form-label">TronGrid api Key</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="trongrid_api"
                                value="{{ old('trongrid_api') ?? $settings->trongrid_api }}" id="trongrid_api"
                                placeholder="TronGrid api Key">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>NowPayments Settings</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nw_key" class="col-sm-1-12 col-form-label">NP API Key</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="nw_key"
                                value="{{ old('nw_key') ?? $settings->nw_key }}" id="nw_key"
                                placeholder="NP Public Key">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="coin_hash" class="col-sm-1-12 col-form-label">Coin Hash</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="coin_hash"
                                value="{{ old('coin_hash') ?? $settings->coin_hash }}" id="coin_hash"
                                placeholder="Coin Hash">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gateway_charge" class="col-sm-1-12 col-form-label">NP Charge (in %)</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="gateway_charge"
                                value="{{ old('gateway_charge') ?? $settings->gateway_charge }}" id="gateway_charge"
                                placeholder="NP Charge">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
@endsection
