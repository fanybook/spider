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

        // 获取job列表
        $job_list = [];

        $filenames = scandir(app_path('Spider/Jobs'));
        foreach ($filenames as $idx => $filename) {
            if ($filename == '.' || $filename == '..') {
                continue;
            }

            $job_name = strtolower(strstr($filename, 'Job', true));
            $job_list[$job_name] = strstr($filename, '.', true);
        }

        // 爬行作业存在，则启动引擎
        if ($this->argument('job') && isset($job_list[$this->argument('job')])) {
            $job_class = '\App\Spider\Jobs\\' . $job_list[$this->argument('job')];
            $job = new $job_class;

            $engine = new Engine();
            $engine->start($job);

        // 否则提示错误
        } else {
            // 否则命令结束
            echo sprintf("爬行作业：错误 %s 不存在，请检查后再试！\n", $this->argument('job'));
        }

        echo sprintf("爬行作业：结束 %s\n", date('Y-m-d H:i:s'));
    }
}
