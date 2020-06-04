<?php

use App\DetailExtra;
use App\Extra;
use App\Page;
use App\PageDetail;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'SuperAdmin',
            'status' => 1,
        ]);

        Role::create([
            'name' => 'WebsiteAdmin',
            'status' => 1,
        ]);
    }
}
