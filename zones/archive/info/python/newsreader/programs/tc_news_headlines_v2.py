#!python

import cgi
import gzip
import os
import re
import urllib.parse
import urllib.request
import yaml
import cssselect

# from bs4 import BeautifulSoup

import lxml.html as lh

import config
import tc_news_config

query_string = cgi.FieldStorage()
media_id = query_string.getvalue('id')
media_id = '02'

with open(os.path.join(tc_news_config.app_dir, f'{media_id}.yaml'), 'r') as file_object:
    config_list = yaml.safe_load(file_object)

media_name = config_list['media_name']
media_url = config_list['media_url']
module_body = config_list['module_body']
module_article = config_list['module_article']
module_headline = config_list['module_headline']
clean_module = config_list['clean_module']

url_list = urllib.parse.urlparse(media_url)
media_prefix = f'{url_list.scheme}://{url_list.netloc}'

page_title = media_name
page_content = f'<h1>{page_title}</h1>\n\n'

url_request = urllib.request.Request(media_url, None, config.http_headers)
url_object = urllib.request.urlopen(url_request)
url_content = url_object.read()

if url_object.info().get('Content-Encoding') == 'gzip':
    url_content = gzip.decompress(url_content)

url_encoding = url_object.headers.get_content_charset()
url_content = url_content.decode(url_encoding)

for regex in clean_module:
    if not regex[0]:
        continue
    url_content = re.sub(regex[0], regex[1], url_content, flags=(re.S | re.I))

#url_content_x = re.sub('<body(.*?)>(.*)</body>', '<html><body>2</body></html>', url_content, flags=(re.S | re.I))
#url_content = re.sub('<\!doctype html>(.*?)</html>', '<html><body>\1</body></html>', url_content, flags=re.S)
#url_content = re.sub('<script(.*?)>(.*?)</script>', '', url_content, flags=re.S)
#url_content = re.sub('<body class="BETAUS ">(.*?)</html>', '', url_content, flags=re.S)


root = lh.fromstring(url_content)

p_elements = root.cssselect('div[class*="column1 col col-10"]')
print(p_elements[0].text_content())

# for div in root.cssselect('div[class*="column1 col col-10"]'):
#     print(div.text_content())



# print(url_content)
# print(root)

# parser_object = BeautifulSoup(url_content, config.html_parser)
#
# contents_module_body = parser_object.select(module_body)
# tag_module_body = f"<html><body>{contents_module_body[0]}</body></html>"
#
# parser_object = None
# parser_object = BeautifulSoup(tag_module_body, config.html_parser)
#
# for contents_module_article in parser_object.select(module_article):
#     item_selected = contents_module_article.select(module_headline)
#
#     if not item_selected:
#         continue
#
#     headline_name = item_selected[0].get_text().strip()
#     headline_url = contents_module_article.find('a')['href']
#
#     if not headline_url.startswith('http'):
#         headline_url = headline_url.lstrip('/')
#         headline_url = f'{media_prefix}/{headline_url}'
#         headline_url = urllib.parse.quote(headline_url)
#
#     page_content += "<p class='clHeadline'>"
#     page_content += f"<a href='./tc_news_article.py?id={media_id}&url={headline_url}'>{headline_name}</a>"
#     page_content += "</p>\n"
#
# with open(f'{config.templates_dir}/tc_news_headlines.html', 'r') as file_object:
#     page_html = file_object.read()
#
# print('Content-type: text/html\n')
# print(page_html.format(**locals()))
