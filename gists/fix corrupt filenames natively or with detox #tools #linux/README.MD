## native search/replace of corrupt �

### installation
  - `sudo apt-get install rename perl libunicode-map8-perl`

### corrupt question marks
  - ```find . -exec rename 's/�/x/g' "{}" \;```

### corrupt umlauts
  - ```find ./ -type f -print0 | rename -v -0 'BEGIN { use Unicode::Map8; our $l1_map = Unicode::Map8->new("latin1") }; our $l1_map; $_ = $l1_map->tou($_)->utf8'```
  - use ```-n``` instead of ```-v``` to do a dry run
  - use ```-type d``` instead of ```-type f``` to rename directories instead of files

## alternative with detox

### installation

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

### configuration

- `nano /etc/detox/safe.tbl`

*replace the following existing rules. in this example, we keep spaces and brackets:*

```
0x20	' '	# space
0x28	(	# (
0x29	)	# )
```

### usage

- `detox -s custom -r -v --dry-run ./`
- `detox -s custom -r -v ./`