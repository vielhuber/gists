a double dash (--) marks the end of `options` and the start of `parameters` in a command.

- `grep -v foo bar`: inverted search for the string "foo" in the file "bar"
- `grep -v -- foo bar`: same as first example
- `grep -- -v foo bar`: search for the string "-v" in the files "foo" and "bar"

