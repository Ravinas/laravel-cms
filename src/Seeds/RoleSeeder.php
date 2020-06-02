<?php
namespace CMS\Seeds;
use CMS\Models\Role;
use Illuminate\Database\Seeder;


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
