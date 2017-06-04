# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: http://doc.scrapy.org/en/latest/topics/item-pipeline.html

import json
import codecs

class JsonWriterPipeline(object):

    def open_spider(self, spider):
        self.file = codecs.open('items_' + spider.name + '.json', 'wb', encoding='utf-8')

    def process_item(self, item, spider):
        line = json.dumps(dict(item)) + "\n"
        self.file.write(line.decode('unicode_escape'))
        return item

    def close_spider(self, spider):
        self.file.close()

class Get1688Pipeline(object):
    def process_item(self, item, spider):
        return item
