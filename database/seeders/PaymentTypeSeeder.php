<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [
            [
                'code' => 'full',
                'name' => 'Full Payment',
                'description' => 'Pay full amount upfront',
                'is_deposit' => false,
                'deposit_percentage' => null,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'dp_50',
                'name' => 'DP 50%',
                'description' => 'Down payment 50%, balance on check-in or before',
                'is_deposit' => true,
                'deposit_percentage' => 50,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'dp_30',
                'name' => 'DP 30%',
                'description' => 'Down payment 30%, balance on check-in or before',
                'is_deposit' => true,
                'deposit_percentage' => 30,
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'pay_at_venue',
                'name' => 'Bayar di Tempat',
                'description' => 'Pay on arrival at the property',
                'is_deposit' => false,
                'deposit_percentage' => null,
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        DB::table('payment_types')->insert($rows);
    }
}
