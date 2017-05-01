<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('orders')->delete();
      DB::table('orders')->insert([
        'cart_id'=>2,
        'product_id'=>1,
        'quantity'=>3,
        'sub_total'=>150000,
      ]);
      DB::table('orders')->insert([
        'cart_id'=>2,
        'product_id'=>2,
        'quantity'=>3,
        'sub_total'=>150000,
      ]);
      DB::table('orders')->insert([
        'cart_id'=>2,
        'product_id'=>1,
        'quantity'=>3,
        'sub_total'=>150000,
      ]);
    }
}
