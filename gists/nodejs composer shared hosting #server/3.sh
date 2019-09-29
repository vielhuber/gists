mkdir $USERDIR/bin
mkdir $USERDIR/bin/symlinks
ln -s /usr/bin/php72 $USERDIR/bin/symlinks/php
echo 'export PATH="'"$USERDIR"'/bin/symlinks:$PATH"' >> ~/.bashrc
source ~/.bashrc
php --version