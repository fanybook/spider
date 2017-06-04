#coding:utf-8
import scrapy
from get1688.items import CatListItem

class Com54mzSpider(scrapy.spiders.Spider):         # 类名不需与文件同名，随便起不影响
    name = '54mz'                                   # 蜘蛛的名字，scrapy crawl 54mz
    allowed_domains = ['54mz.com']                  # 接受的域名
    start_urls = [                                  # 入口url
        'http://54mz.com/for-sale'
    ]

    def parse(self, response):
        items = []
        for sel in response.xpath('//div[@class="video-target"]/a'):
            item = CatListItem()
            item['url'] = sel.xpath('@href').extract()
            item['image'] = sel.xpath('img/@src').extract()
#            yield item     # 用yield就用return数组了
            items.append(item)

        return items
