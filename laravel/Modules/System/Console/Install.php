<?php

namespace Modules\System\Console;

use Caffeinated\Modules\Facades\Module;
use Caffeinated\Modules\Modules;
use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs trendamp';

    /**
     * @var Modules
     */
    private $modules;

    /**
     * Create a new command instance.
     * @param Modules $modules
     */
    public function __construct(Modules $modules)
    {
        parent::__construct();
        $this->modules = $modules;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->alert('installing...');

        \Artisan::call('module:optimize');

        $modules = $this->modules->all();

        $bar = $this->output->createProgressBar(count($modules));

        \Artisan::call('migrate:fresh');

        foreach ($modules as $module){
            \DB::statement("SET foreign_key_checks=0");

            \Artisan::call('module:migrate', ['slug' => $module['slug']]);
            \Artisan::call('module:seed', ['slug' => $module['slug']]);

            $bar->advance();

        }

        \Artisan::call('migrate');
        \Artisan::call('passport:install');

        $bar->finish();

        \DB::statement("SET foreign_key_checks=1");

    }
}