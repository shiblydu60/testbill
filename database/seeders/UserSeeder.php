<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Super',
            'last_name' => 'Admin',
			'email' => 'superadmin@admin.com',
			'password' => bcrypt('superadmin@admin.com'),
			// 'division_id' => 0,
			'created_at'=> Carbon::now(),
			'updated_at'=> Carbon::now(),
        ]);
        
        $user = User::first();
        $user->assignRole('superadmin');
    }
}
