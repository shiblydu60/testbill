<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'name' => 'Others',
            'description' => 'Others',
            'isdeleted' => 0,
			'created_at'=> Carbon::now(),
			'updated_at'=> Carbon::now(),
        ]);
    }
}
