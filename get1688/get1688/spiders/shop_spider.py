#coding:utf-8
import scrapy
from get1688.items import GoodsListItem

class ShopSpider(scrapy.spiders.Spider):
    name = 'shop'
    allowed_domains = ['1688.com']
    start_urls = [
#        'https://mizi512.1688.com/page/offerlist.htm',
        'https://detail.1688.com/offer/536452856256.html',
    ]

#    rules = (
#        Rule(LinkExtractor(allow=r'Items/'), callback='parse_detail', follow=True),
#    )

    use_webkit = {
#        'https:\/\/mizi512\.1688\.com\/page\/offerlist\.htm',
#        'https:\/\\/detail\.1688\.com\/offer\/[0-9]{12}\.html',
    }

    def parse(self, response):
        file = open('1688_ori.text', 'wb')
        file.write(response.body.decode('gbk', 'ignore').encode('utf8'))
        file.close()

#        print response.body
#        items = []
#        for sel in response.xpath('//ul[@class="offer-list-row"]/li'):
#            item = GoodsListItem()
#            item['name']    = sel.xpath('div[@class="title"]/a/@title').extract()
#            item['url']     = sel.xpath('div[@class="title"]/a/@href').extract()
#            item['image']   = sel.xpath('div[@class="image"]/a/img/@data-lazy-load-src').extract()
#            items.append(item)
#
#        return items
