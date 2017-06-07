<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Spider crawl a job';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // new Engine(); 引擎start()
    }
}
