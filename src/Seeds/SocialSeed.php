<?php
namespace CMS\Seeds;
use Illuminate\Database\Seeder;
use App\Social;

class SocialSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Social::create([
           "name" => "Facebook",
           "class" => "facebook",
           "url" => "/",
           "order" => "1",
           "icon" => "/"
        ]);
    }
}
