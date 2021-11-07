<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\GiftCode::factory(130)->create();

        DB::table('gifts')->insert([
            'name'   => 'Iphone',
            'number' => '10'
        ]);

        DB::table('gifts')->insert([
            'name'   => 'Một triệu tiền mặt',
            'number' => '30'
        ]);

        DB::table('gifts')->insert([
            'name'   => 'Vé xem phim',
            'number' => '60'
        ]);
    }
}
