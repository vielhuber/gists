<?php
// based on tag
exec('git describe --tags', $version);
echo 'v'.trim($version[0]);

// based on head
exec('git rev-parse --abbrev-ref HEAD', $version);
echo trim($version[0]);

// based on unique hash of last commit
exec('git rev-parse --short HEAD', $version);
echo trim($version[0]);