# windows
## user path
```
powershell "$folder = 'C:\path\to\folder'; $old = (Get-ItemProperty -Path 'Registry::HKEY_CURRENT_USER\Environment' -Name PATH).path; $new = $old+';'+$folder; Set-ItemProperty -Path 'Registry::HKEY_CURRENT_USER\Environment' -Name PATH -Value $new"
```
## system path (run as administrator)
```
powershell "$folder = 'C:\path\to\folder'; $old = (Get-ItemProperty -Path 'Registry::HKEY_LOCAL_MACHINE\System\CurrentControlSet\Control\Session Manager\Environment' -Name PATH).path; $new = $old+';'+$folder; Set-ItemProperty -Path 'Registry::HKEY_LOCAL_MACHINE\System\CurrentControlSet\Control\Session Manager\Environment' -Name PATH -Value $new"
```

# mac
```
sudo nano /etc/paths
./vendor/bin
/path/to/dir
./node_modules/.bin
```

# mac/linux
## user
```
nano ~/.bash_profile
export PATH="$PATH:/path/to/dir"
```
## system
```
nano /etc/profile
export PATH="$PATH:/path/to/dir"
```

## notes
you can also add relative paths. it's for example very useful when using composer to add ./vendor/bin to your PATH