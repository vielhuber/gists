import os
from webwhatsapi import WhatsAPIDriver
profiledir = os.path.join('.', 'firefox_cache')
if not os.path.exists(profiledir):
    os.makedirs(profiledir)
driver = WhatsAPIDriver(
    profile=profiledir,
    headless=True
)
print('login')
driver.wait_for_login()
driver.save_firefox_profile(remove_old=False)
print('start')
chat = driver.get_chat_from_phone_number('491xxxxxxxxxx')
driver.send_message_to_id(chat.id, 'This works')