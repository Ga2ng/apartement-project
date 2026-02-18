<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitBaseRateSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $unitIds = DB::table('units')->pluck('id');
        $rows = [];
        foreach ($unitIds as $unitId) {
            $rows[] = [
                'unit_id' => $unitId,
                'effective_from' => now()->startOfYear()->toDateString(),
                'effective_until' => null,
                'daily_rate' => 500000,
                'currency' => 'IDR',
                'min_nights' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if ($rows !== []) {
            DB::table('unit_base_rates')->insert($rows);
        }
    }
}
