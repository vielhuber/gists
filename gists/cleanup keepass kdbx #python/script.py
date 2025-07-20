import argparse
import getpass
import os
import re
import sys
from pykeepass import PyKeePass

parser = argparse.ArgumentParser()
parser.add_argument('kdbx_path', help='Path to .kdbx-file')
args = parser.parse_args()
if not os.path.isfile(args.kdbx_path):
    print(f"⛔ File not found: {args.kdbx_path}")
    sys.exit(1)

kp = PyKeePass(args.kdbx_path, password=getpass.getpass('ℹ️ Enter password: '))

for entry in kp.entries:

    # remove training slash in title
    if entry.title and entry.title.endswith('/'):
        entry.title = entry.title.rstrip('/')

    # move emails from username
    if entry.username and re.compile(r'^[\w\.-]+@[\w\.-]+\.\w+$').match(entry.username):
        current_email = entry.get_custom_property('E-Mail')
        if not current_email or current_email == entry.username:
            entry.set_custom_property('E-Mail', entry.username)
            entry.username = ''

    # cleanup urls
    if entry.url:
        new_url = entry.url.replace('http://', 'https://', 1)
        new_url = new_url.rstrip('/')
        if new_url != entry.url:
            entry.url = new_url

    # delete some meta fields
    if entry.get_custom_property('KPRPC JSON') is not None:
        entry.delete_custom_property('KPRPC JSON')

    # delete icons
    icon_elem = entry._element.find('IconID')
    if icon_elem is not None and icon_elem.text != '0':
        icon_elem.text = '0'
    custom_icon_elem = entry._element.find('CustomIconUUID')
    if custom_icon_elem is not None:
        entry._element.remove(custom_icon_elem)

kp.save()
print('✅ Successfully cleaned up KeePass entries.')