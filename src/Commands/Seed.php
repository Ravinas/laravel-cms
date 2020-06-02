<?php

namespace CMS\Commands;

use Illuminate\Console\Command;
use CMS\Seeds\DatabaseSeeder;
use Illuminate\Support\Facades\Artisan;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding Cms Tables';

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
        Artisan::call('db:seed', ['--class' => DatabaseSeeder::class]);
        $this->info('Tablolara kayıtlar girildi.');
    }
}

