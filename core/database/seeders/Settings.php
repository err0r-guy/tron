<?php

namespace Database\Seeders;

use App\Models\Settings as ModelsSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = new ModelsSettings;
        $settings->sitename = 'Trxminer';
        $settings->logo = 'assets/images/logo.png';
        $settings->favicon = 'assets/images/logo.png';
        $settings->favicon = 'assets/images/favicon.png';
        $settings->keywords = 'key1,key2';
        $settings->description = 'Best cloud miner';
        $settings->telegram = 'https://t.me';
        $settings->currency = 'TRON';
        $settings->cur_sym = 'TRX';
        $settings->wallet_min = 20;
        $settings->wallet_max = 50;
        $settings->charge = 0;
        $settings->min_withdraw = 0;
        $settings->max_withdraw = 10000;
        $settings->ref_commission = 10;
        $settings->pub_key = null;
        $settings->pri_key = null;
        $settings->trongrid_api = null;
        $settings->cp_pub_key = null;
        $settings->cp_pri_key = null;
        $settings->cp_merchant = null;
        $settings->coin_hash = null;
        $settings->gateway_charge = 0;
        $settings->save();
    }
}
