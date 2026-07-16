### powershell (admin)

```ps
wsl --debug-shell
```

### inside debug shell

```sh
ps aux --sort=-%cpu | head -4
kill 22412
```
