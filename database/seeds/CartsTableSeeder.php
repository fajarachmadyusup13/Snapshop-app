<?php

use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('carts')->delete();
      DB::table('carts')->insert([
        'user_id'=>1,
        'total_amount'=>150000,
        'status'=>'done'
      ]);
    }
}
