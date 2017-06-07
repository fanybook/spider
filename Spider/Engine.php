<?php

namespace App\Spider;

class Engine
{
    public $job_middlewares = [
        'job_middleware_01' => 1,
        'job_middleware_02' => 2,
        'job_middleware_03' => 3,
        'job_middleware_04' => 4,
        'job_middleware_05' => 5,
    ];

    public $downloader_middlewares = [
        'downloader_middleware_01' => 1,
        'downloader_middleware_02' => 2,
        'downloader_middleware_03' => 3,
        'downloader_middleware_04' => 4,
        'downloader_middleware_05' => 5,
    ];
    
    public $scheduler_middlewares = [
        'scheduler_middleware_01' => 1,
        'scheduler_middleware_02' => 2,
        'scheduler_middleware_03' => 3,
        'scheduler_middleware_04' => 4,
        'scheduler_middleware_05' => 5,
    ];

    public function start($job = null)
    {
        if (!$job) {
            die('爬行作业为空，请检查后再试！');
        }

        var_dump($job);

        // 取得Job列表
        // 判断job是否在列表中
        // 在的话，把job交给scheduler(scheduler把job里的url变成一个个的request，放入队列，交给下载器)
        // 不在就报错
    }
}