**************************************
目标是从1688指定店铺里取得全部的商品

流程：
1.通过入口url爬到所有的商品详细页url
2.通过商品详细页url，取得商品的url,title，detail,price

反爬：
1.首先要解决302重定向问题   # 暂时解决（果然 HTTPCACHE_ENABLED 无法彻底解决，有出现但换了wifi【ip地址】就好了）
2.要使用代理不断切换ip      # 要在写一个爬代理的爬虫
3.随机使用User-Agent(ua)    # 已经做完
4.执行js                   ❤ 优先
5.暂时未发现验证码问题

任务：
1.先用54mz.com做实验                # 进度：可以采在售列表了
2.把采集到的数据保存成json文件      # 进度：实现（parse里return一个Items的数组，或是循环里yield一个item）
**************************************

操作：
++++++++++++++++++++++++++++++++++++++
1.忽视robots.txt
    1) in:settings.py中修改
    # Obey robots.txt rules
    ROBOTSTXT_OBEY = True   ->   False
2.加入Ghost.py（执行open，python.exe就停止，不过js的确执行了）
    1) in:settings.py中写入
    WEBKIT_ALLOWED_SPIDERS = ['54mz']   # 这句不要了，参考5
    DOWNLOADER_MIDDLEWARES = {
        'get1688.middlewares.WebkitDownloaderMiddleware': 543,
    }
3.302重定向竟然被忽略了，参考http://stackoverflow.com/questions/22795416/how-to-handle-302-redirect-in-scrapy
    1) in:settings.py中写入
    HTTPCACHE_ENABLED = True
    HTTPCACHE_IGNORE_HTTP_CODES = [301,302]
4.输出结果从unicode转utf-8，参考https://segmentfault.com/q/1010000000519595（http://git.oschina.net/ldshuang/imax-spider/commit/1d05d7bafdf7758f7b422cc1133abf493bf55086）
    import codecs
    self.file = codecs.open('items.json', 'wb', encoding='utf-8')

    已知有两个方法：
    1) self.file.write(line.decode('unicode_escape'))
    2) from collections import OrderedDict
       line = json.dumps(OrderedDict(item), ensure_ascii=False, sort_keys=False) + "\n"
5.写了允许使用webkit的规则
    注释掉了原来的 if spider.name in get1688.settings.WEBKIT_ALLOWED_SPIDERS
6.加入了随机ua


学习：
http://www.tuicool.com/articles/77BZfuf         使用Scrapy定制可动态配置的爬虫
http://wuchong.me/blog/2015/05/22/running-scrapy-dynamic-and-configurable/?utm_source=tuicool&utm_medium=referral
https://github.com/wuchong/scrapy-dynamic-configurable      ↑↑
++++++++++++++++++++++++++++++++++++++
1.蜘蛛名只和class里的name变量有关
    与文件名和类名无关
2.文件头加入#coding:utf-8
    可以支持中文，或者 # -*- coding: utf-8 -*-
3.setting里MIDDLEWARES和PIPELINES后面的数组
    是一种顺序（order），越小，越先执行，但有些内置已有顺序，自定义的可以相对他们写order
    http://scrapy-chs.readthedocs.io/zh_CN/latest/topics/settings.html#downloader-middlewares-base      （有14个）
    http://scrapy-chs.readthedocs.io/zh_CN/latest/topics/settings.html#spider-middlewares-base          （有5个）
    http://scrapy-chs.readthedocs.io/zh_CN/latest/topics/settings.html#item-pipelines-base              （有0个）


