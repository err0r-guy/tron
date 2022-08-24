<?php

namespace Database\Seeders;

use App\Models\Admin as ModelsAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new ModelsAdmin;
        $admin->name = 'Brainiac Hades';
        $admin->email = 'brainiachades@gmail.com';
        $admin->email_verified_at = now();
        $admin->password = Hash::make('password');
        $admin->save();
    }
}
