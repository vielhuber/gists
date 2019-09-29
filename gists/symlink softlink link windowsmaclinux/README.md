## windows
- run cmd as administrator
- ```mklink /D c:\path\to\symlinkfolder c:\path\to\folder```
- ```mklink /D c:\path\to\symlinkfile c:\path\to\folder```
- ```rmdir c:\path\to\symlinkfolder```
- ```del c:\path\to\symlinkfile```

## linux/mac

- ```ln -s /path/to/folder /path/to/symlinkfolder```
- ```ln -s /path/to/file /path/to/symlinkfile```
- ```unlink /path/to/symlinkfolder```
- ```unlink /path/to/symlinkfile```