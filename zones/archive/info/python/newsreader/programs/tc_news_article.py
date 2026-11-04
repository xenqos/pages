#!python

import cgi
import gzip
import lxml.html
import re
import os
import urllib.parse
import urllib.request
import yaml

import config
import tc_news_config

query_string = cgi.FieldStorage()
media_id = query_string.getvalue('id')
media_url = query_string.getvalue('url')

with open(os.path.join(tc_news_config.app_dir, f'{media_id}.yaml'), 'r') as file_object:
    config_list = yaml.safe_load(file_object)

media_name = config_list['media_name']
article_body = config_list['article_body']
article_title = config_list['article_title']
article_date = config_list['article_date']
article_author = config_list['article_author']
clean_article_pre = config_list['clean_article_pre']
clean_article_post = config_list['clean_article_post']

media_url = urllib.parse.unquote(media_url)

url_list = urllib.parse.urlparse(media_url)
media_prefix = f'{url_list.scheme}://{url_list.netloc}'

url_request = urllib.request.Request(media_url, None, config.http_headers)
url_object = urllib.request.urlopen(url_request)
url_content = url_object.read()

if url_object.info().get('Content-Encoding') == 'gzip':
    url_content = gzip.decompress(url_content)

url_encoding = url_object.headers.get_content_charset()
url_content = url_content.decode(url_encoding)

for regex in clean_article_pre:
    if not regex[0]:
        continue
    url_content = re.sub(regex[0], regex[1], url_content, flags=(re.S | re.I))

html_object = lxml.html.fromstring(url_content)
html_elements = html_object.cssselect(article_body)
article_string = lxml.html.tostring(html_elements[0], method='html', encoding='unicode')

article_object = lxml.html.fromstring(article_string)

contents_article_body = article_string

try:
    contents_article_title = article_object.cssselect(article_title)[0].text_content().strip()
except lxml.cssselect.SelectorSyntaxError:
    contents_article_title = ''

try:
    contents_article_date = article_object.cssselect(article_date)[0].text_content().strip()
except lxml.cssselect.SelectorSyntaxError:
    contents_article_date = ''

try:
    contents_article_author = article_object.cssselect(article_author)[0].text_content().strip()
except lxml.cssselect.SelectorSyntaxError:
    contents_article_author = ''

for regex in clean_article_post:
    if not regex[0]:
        continue
    contents_article_body = re.sub(regex[0], regex[1], str(contents_article_body), flags=(re.S | re.I))

page_title = media_name
page_content = f"<h1 class='clArticleTitle'>{contents_article_title}</h1>\n\n"
page_content += f"<p>{contents_article_date}&emsp;{contents_article_author}</p>\n"
page_content += contents_article_body

with open(f'{config.templates_dir}/tc_news_article.html', 'r') as file_object:
    page_html = file_object.read()

print('Content-type: text/html\n')
print(page_html.format(**locals()))
