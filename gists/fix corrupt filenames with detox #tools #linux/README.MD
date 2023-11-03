## installation

- `sudo apt-get install detox`

- `mkdir /etc/detox`

- `cp /usr/share/detox/unicode.tbl /etc/detox/unicode.tbl`
- `cp /usr/share/detox/safe.tbl /etc/detox/safe.tbl`

- `nano /etc/detoxrc`

*add this on bottom:*
```
sequence "custom" {
    #utf_8 {filename "/etc/detox/unicode.tbl";};
    safe {filename "/etc/detox/safe.tbl";};
};
```

## configuration

- `nano /etc/detox/custom.tbl`

*replace the following existing rules. in this example, we keep spaces and brackets:*

```
0x20	' '	# space
0x28	(	# (
0x29	)	# )
```

## usage

- `detox -s custom -r -v --dry-run ./`
- `detox -s custom -r -v ./`