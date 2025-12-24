# be aware: you cannot uninstall this (make uninstall is not available in this package)
cd /opt/
wget https://github.com/ArtifexSoftware/ghostpdl-downloads/releases/download/gs923/ghostscript-9.23.tar.gz
tar xvf ghostscript-9.23.tar.gz
cd ghostscript-9.23
./configure
make
make install
gs -v