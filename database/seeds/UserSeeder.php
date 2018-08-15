<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        User::create([
            'name'             => '莊家',
            'email'            => 'admin@lottery.com',
            'password'         => Hash::make('123456'),
            'is_owner'         => '1',
            'ethereum_address' => env('ETH_OWNER_ADDRESS'),
        ]);
    }
}
