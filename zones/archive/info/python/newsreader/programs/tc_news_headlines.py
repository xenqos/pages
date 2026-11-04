#!python

import cgi
import gzip
import lxml.html
import os
import re
import urllib.parse
import urllib.request
import yaml

import config
import tc_news_config

query_string = cgi.FieldStorage()
media_id = query_string.getvalue('id')

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

module_object = lxml.html.fromstring(url_content)
module_elements = module_object.cssselect(module_body)
module_string = lxml.html.tostring(module_elements[0], method='html', encoding='unicode')

article_object = lxml.html.fromstring(module_string)

for article_element in article_object.cssselect(module_article):
    article_string = lxml.html.tostring(article_element, method='html', encoding='unicode')
    headline_object = lxml.html.fromstring(article_string)
    headline_elements = headline_object.cssselect(module_headline)
    headline_name = headline_elements[0].text_content().strip()
    headline_elements = headline_object.cssselect('a')
    headline_url = headline_elements[0].get('href')

    if not headline_url.startswith('http'):
        headline_url = headline_url.lstrip('/')
        headline_url = f'{media_prefix}/{headline_url}'
        headline_url = urllib.parse.quote(headline_url)

    page_content += "<p class='clHeadline'>"
    page_content += f"<a href='./tc_news_article.py?id={media_id}&url={headline_url}'>{headline_name}</a>"
    page_content += "</p>\n"

with open(f'{config.templates_dir}/tc_news_headlines.html', 'r') as file_object:
    page_html = file_object.read()

print('Content-type: text/html\n')
print(page_html.format(**locals()))
