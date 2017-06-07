<?php

namespace App\Spider\Commands;

use Illuminate\Console\Command;
use App\Spider\Engine;

class Crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:crawl {job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Let spider crawl a job';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        echo sprintf("爬行作业：开始 %s\n", date('Y-m-d H:i:s'));

        // 检查job名
        $job = null;

        $filenames = scandir(app_path('Spider/Jobs'));
        foreach ($filenames as $idx => $filename) {
            if ($filename == '.' || $filename == '..') {
                continue;
            }

            try {
                $job_class = '\App\Spider\Jobs\\' . strstr($filename, '.', true);
                $job = new $job_class;

                if ($job->name == $this->argument('job')) {
                    break;
                }
            } catch(\Exception $e) {
                echo sprintf("爬行作业：错误 %s\n", $e->getMessage());
            }

            $job = null;
        }

        // 爬行作业存在，则启动引擎
        if ($job) {
            $engine = new Engine();
            $engine->start($job);

        // 否则提示错误
        } else {
            echo sprintf("爬行作业：错误 %s 不存在，请检查后再试！\n", $this->argument('job'));
        }

        echo sprintf("爬行作业：结束 %s\n", date('Y-m-d H:i:s'));
    }
}
