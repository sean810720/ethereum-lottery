<?php

use App\Models\Contract;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract')->truncate();

        Contract::create([
            'owner_user_id'    => 1,
            'ethereum_address' => env('ETH_CONTRACT_ADDRESS'),
        ]);
    }
}
