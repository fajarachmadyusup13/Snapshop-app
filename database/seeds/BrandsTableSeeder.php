<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('brands')->delete();
      DB::table('brands')->insert([
        'name'=>'Los Pollos Hermanos',
        'description'=>'Boo Company',
      ]);
    }
}
