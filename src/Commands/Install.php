<?php

namespace CMS\Commands;

use Illuminate\Console\Command;
use CMS\Seeds\DatabaseSeeder;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'installing cms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $packageDir = dirname(__DIR__);

        //clear routes/web.php
        $webRouteContent = "<?php
        use Illuminate\Support\Facades\Route;
";
        copy(base_path()."/routes/web.php",base_path()."/routes/old_web.php");
        file_put_contents(base_path()."/routes/web.php" ,$webRouteContent);
        $this->info('routes/web.php düzenlendi');

        if (file_exists(base_path("database/migrations/2014_10_12_000000_create_users_table.php")))
        {
            unlink(base_path("database/migrations/2014_10_12_000000_create_users_table.php"));
        }

        //copy website app,header,footer blades
        $bladez = "";
        if(!file_exists(resource_path('views/vendor/prime/app.blade.php'))){
            copy($packageDir.'/Resources/views/website/app.blade.php',resource_path('views/vendor/prime/app.blade.php'));
            $bladez .= "app ";
        }
        if(!file_exists(resource_path('views/vendor/prime/header.blade.php'))) {
            copy($packageDir . '/Resources/views/website/header.blade.php', resource_path('views/vendor/prime/header.blade.php'));
            $bladez .= "header ";
        }
        if(!file_exists(resource_path('views/vendor/prime/footer.blade.php'))) {
            copy($packageDir . '/Resources/views/website/footer.blade.php', resource_path('views/vendor/prime/footer.blade.php'));
            $bladez = "footer ";
        }
        if($bladez == ""){
            $this->info('eksik blade yok, kopyalama yapılmadı');
        } else {
            $this->info('projede olmayan '.$bladez.'blade projeye kopyalandı');
        }



    }
}

