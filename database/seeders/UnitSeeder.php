<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = fn (string $code) => (int) DB::table('unit_types')->where('code', $code)->value('id');
        $view = fn (string $code) => DB::table('unit_views')->where('code', $code)->value('id');
        $interior = fn (string $code) => (int) DB::table('interior_types')->where('code', $code)->value('id');
        $owner = fn (string $code) => (int) DB::table('owners')->where('code', $code)->value('id');

        $now = now();
        $units = [
            ['unit_number' => 'B-05-36', 'building_tower' => 'B', 'floor_level' => 5, 'room_number' => '36', 'unit_type_id' => $type('3br'), 'unit_view_id' => $view('sea'), 'interior_type_id' => $interior('kosongan_ac'), 'owner_id' => $owner('bed_debt'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'A-26-21', 'building_tower' => 'A', 'floor_level' => 26, 'room_number' => '21', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('pool'), 'interior_type_id' => $interior('kosongan'), 'owner_id' => $owner('unsold_ppa'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'A-26-35', 'building_tower' => 'A', 'floor_level' => 26, 'room_number' => '35', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('pool'), 'interior_type_id' => $interior('furnished'), 'owner_id' => $owner('unsold_tga'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => 'Wallpaper damaged, broken bed, no wifi, AC drain pipe issue', 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-06-09', 'building_tower' => 'B', 'floor_level' => 6, 'room_number' => '09', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('mountain'), 'interior_type_id' => $interior('semi_furnished'), 'owner_id' => $owner('bed_debt'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => 'AC broken, no wifi, no TV, small bed', 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-15-29', 'building_tower' => 'B', 'floor_level' => 15, 'room_number' => '29', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('mountain'), 'interior_type_id' => $interior('kosongan_ac'), 'owner_id' => $owner('unsold_ppa'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-17-29', 'building_tower' => 'B', 'floor_level' => 17, 'room_number' => '29', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('mountain'), 'interior_type_id' => $interior('kosongan_ac'), 'owner_id' => $owner('unsold_ppa'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-19-30', 'building_tower' => 'B', 'floor_level' => 19, 'room_number' => '30', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('mountain'), 'interior_type_id' => $interior('kosongan_ac'), 'owner_id' => $owner('unsold_ppa'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-25-30', 'building_tower' => 'B', 'floor_level' => 25, 'room_number' => '30', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('mountain'), 'interior_type_id' => $interior('kosongan_ac'), 'owner_id' => $owner('unsold_ppa'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-26-21', 'building_tower' => 'B', 'floor_level' => 26, 'room_number' => '21', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('pool'), 'interior_type_id' => $interior('kosongan_ac'), 'owner_id' => $owner('unsold_ppa'), 'rental_status' => 'vacant', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Not yet rented', 'is_active' => true, 'is_available' => true, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'A-11-62', 'building_tower' => 'A', 'floor_level' => 11, 'room_number' => '62', 'unit_type_id' => $type('2br'), 'unit_view_id' => $view('sky_garden'), 'interior_type_id' => $interior('furnished'), 'owner_id' => $owner('bed_debt'), 'rental_status' => 'monthly', 'occupancy_count' => 2, 'issues' => null, 'notes' => 'Monthly rental', 'is_active' => true, 'is_available' => false, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-27-32', 'building_tower' => 'B', 'floor_level' => 27, 'room_number' => '32', 'unit_type_id' => $type('2br'), 'unit_view_id' => $view('sea'), 'interior_type_id' => $interior('furnished'), 'owner_id' => $owner('unsold_tga'), 'rental_status' => 'monthly', 'occupancy_count' => 1, 'issues' => null, 'notes' => 'Monthly rental', 'is_active' => true, 'is_available' => false, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'A-03-37', 'building_tower' => 'A', 'floor_level' => 3, 'room_number' => '37', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('mountain'), 'interior_type_id' => $interior('kosongan_ac'), 'owner_id' => $owner('bed_debt'), 'rental_status' => 'monthly', 'occupancy_count' => 2, 'issues' => null, 'notes' => 'Monthly rental', 'is_active' => true, 'is_available' => false, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-12-29', 'building_tower' => 'B', 'floor_level' => 12, 'room_number' => '29', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('mountain'), 'interior_type_id' => $interior('kosongan'), 'owner_id' => $owner('unsold_ppa'), 'rental_status' => 'monthly', 'occupancy_count' => 1, 'issues' => null, 'notes' => 'Monthly rental', 'is_active' => true, 'is_available' => false, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'B-20-20', 'building_tower' => 'B', 'floor_level' => 20, 'room_number' => '20', 'unit_type_id' => $type('studio'), 'unit_view_id' => $view('pool'), 'interior_type_id' => $interior('kosongan'), 'owner_id' => $owner('bed_debt'), 'rental_status' => 'monthly', 'occupancy_count' => 0, 'issues' => null, 'notes' => 'Monthly rental', 'is_active' => true, 'is_available' => false, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['unit_number' => 'A-26-61', 'building_tower' => 'A', 'floor_level' => 26, 'room_number' => '61', 'unit_type_id' => $type('2br'), 'unit_view_id' => $view('city'), 'interior_type_id' => $interior('furnished'), 'owner_id' => $owner('bed_debt'), 'rental_status' => 'daily', 'occupancy_count' => 7, 'issues' => null, 'notes' => 'Daily booking', 'is_active' => true, 'is_available' => false, 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
        ];

        DB::table('units')->insert($units);
    }
}
