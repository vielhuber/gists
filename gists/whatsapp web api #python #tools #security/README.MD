### installation
- `wget https://github.com/mozilla/geckodriver/releases/download/v0.27.0/geckodriver-v0.27.0-linux64.tar.gz`
- `tar -xvzf geckodriver-v0.27.0-linux64.tar.gz`
- `chmod +x geckodriver`
- `sudo mv geckodriver /usr/local/bin/`

- `git clone https://github.com/mukulhase/WebWhatsapp-Wrapper.git .`
- `python3.6 -m pip install -r requirements.txt`
- `python3.6 test.py`

### example
```py
# test.py
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
driver.send_message_to_id(chat.id, 'Lorem ipsum dolor sit amet')
driver.send_message_to_id(chat.id, 'consectetuer adipiscing elit. Aenean commodo ligula eget dolor.')
driver.send_message_to_id(chat.id, 'Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.')
driver.send_message_to_id(chat.id, 'Nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu')
driver.send_message_to_id(chat.id, 'pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo')
driver.send_message_to_id(chat.id, 'fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut')
driver.send_message_to_id(chat.id, 'imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.')
driver.send_message_to_id(chat.id, 'Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.')
```