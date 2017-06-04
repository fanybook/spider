#coding:utf-8
import re
from scrapy.http import Request, FormRequest, HtmlResponse
import subprocess

"""
为了渲染js：使用webkit。
使用注意：需在settings.py中进行相应的设置。
"""
class WebkitDownloaderMiddleware(object):

    def process_request(self, request, spider):
        if type(request) is not FormRequest and hasattr(spider, 'use_webkit'):
            for regex in spider.use_webkit:
                if re.match(regex, request.url) is not None:
                    stdout_as_string = subprocess.check_output(['casperjs', 'casper_1688_detail.js', request.url], shell=True)
                    renderedBody = stdout_as_string.decode('gbk', 'ignore').encode('utf8')
                    #返回rendereBody就是执行了js后的页面
                    return HtmlResponse(request.url, body=renderedBody)


import random
from scrapy.downloadermiddlewares.useragent import UserAgentMiddleware
from assets.useragents import user_agent_list

"""
避免被ban策略之一：使用useragent池。
使用注意：需在settings.py中进行相应的设置。
"""
class RandomUserAgentDownloaderMiddleware(UserAgentMiddleware):

    def __init__(self, user_agent=''):
        self.user_agent = user_agent

    def process_request(self, request, spider):
        ua = random.choice(user_agent_list)
        if ua:
            print "********Current UserAgent:%s************" %ua
#            log.msg('Current UserAgent: '+ua, level=log.INFO)
            request.headers.setdefault('User-Agent', ua)
