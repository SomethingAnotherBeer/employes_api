<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            ['rate_slug' => 'per_hour', 'rate_name' => 'Почасовая ставка'],
            ['rate_slug' => 'per_week', 'rate_name' => 'Недельная ставка'],
        ];

        DB::table('rates')->insert($params);

    }



}
