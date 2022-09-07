# install https://github.com/box-project/box2
wget https://box-project.github.io/box2/installer.php
php installer.php

# create box.json
{
    "chmod": "0755",
    "directories": [
        "src"
    ],
    "finder": [
        {
            "name": "*.php",
            "exclude": ["tests"],
            "in": "vendor"
        }
    ],
    "main": "src/kiwi.php",
    "output": "kiwi.phar",
    "stub": true
}

# usage
php -d phar.readonly=0 box.phar build
mv kiwi.phar kiwi