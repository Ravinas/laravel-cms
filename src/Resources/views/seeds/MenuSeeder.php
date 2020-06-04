<?php

use Illuminate\Database\Seeder;
use App\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'lang_id' => 2,
            'name' => 'menu',
            'status' => 1,
            'slug' => 'menu'
        ]);
    }
}
