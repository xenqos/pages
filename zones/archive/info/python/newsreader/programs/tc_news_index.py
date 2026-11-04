#!python

import os

from config import templates_dir
from tc_news_config import app_title, app_dir


page_title = app_title
page_content = f'<h1>{app_title}</h1>\n\n'

item_count = 1

for app_file in sorted(os.listdir(app_dir)):
    media_id = os.path.splitext(app_file)[0]

    with open(os.path.join(app_dir, app_file), 'r') as file_object:
        media_list = file_object.readline().strip(' \n').replace('\'', '').split(':')
        media_type = media_list[1].strip()
        media_list = file_object.readline().strip(' \n').replace('\'', '').split(':')
        media_name = media_list[1].strip()

        if media_type == 'block':
            if item_count > 1:
                page_content += '</div>\n'
            page_content += f'<p class=\'clMediaName\'><a href=\'javascript:fncShowHide("idDiv{item_count:02d}")\'>{media_name}</a></p>\n'
            page_content += f'<div id=\'idDiv{item_count:02d}\'>\n'
            item_count += 1
        elif media_type == 'link':
            page_content += f'<p class=\'clMediaName\'><a href=\'./tc_news_headlines.py?id={media_id}\'>{media_name}</a></p>\n'

page_content += '</div>\n'

with open(f'{templates_dir}/tc_news_index.html', 'r') as file_object:
    page_html = file_object.read()

print('Content-type: text/html\n')
print(page_html.format(**locals()))
