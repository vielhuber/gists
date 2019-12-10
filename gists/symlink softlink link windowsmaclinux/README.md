## windows
- run cmd as administrator
- ```mklink /D c:\path\to\symlinkfolder c:\path\to\origfolder```
- ```mklink /D c:\path\to\symlinkfile c:\path\to\origfolder```
- ```rmdir c:\path\to\symlinkfolder```
- ```del c:\path\to\symlinkfile```

## linux/mac

- ```ln -s /path/to/origfolder /path/to/symlinkfolder```
- ```ln -s /path/to/origfile /path/to/symlinkfile```
- ```unlink /path/to/symlinkfolder```
- ```unlink /path/to/symlinkfile```