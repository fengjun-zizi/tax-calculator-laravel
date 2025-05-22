<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxRatesTableSeeder extends Seeder
{
    public function run()
    {
        $rates = [
            [0, 5400000, 0.00],
            [5400000, 5650000, 0.25],
            [5650000, 5950000, 0.50],
            [5950000, 6300000, 0.75],
            [6300000, 6750000, 1.00],
            [6750000, 7500000, 1.25],
            [7500000, 8500000, 1.50],
            [8500000, 9650000, 1.75],
            [9650000, 10500000, 2.00],
            [10500000, 10350000, 2.25],
            [10350000, 10700000, 2.50],
            [10700000, 11050000, 3.00],
            [11050000, 11600000, 3.50],
            [11600000, 12500000, 4.00],
            [12500000, 13750000, 6.00],
            [13750000, 15100000, 6.50],
            [15100000, 16950000, 7.00],
            [16950000, 19750000, 8.00],
            [19750000, 24150000, 9.00],
            [24150000, 99999999999, 30.00],
        ];

        foreach ($rates as $rate) {
            DB::table('tax_rates')->insert([
                'income_from' => $rate[0],
                'income_to' => $rate[1],
                'percentage' => $rate[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
