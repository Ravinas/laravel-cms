<?php
use CMS\Models\DetailExtra;
use CMS\Models\Extra;
use CMS\Models\Page;
use CMS\Models\PageDetail;
use CMS\Models\Role;
use CMS\Models\User;
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
