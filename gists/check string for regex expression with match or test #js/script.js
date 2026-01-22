// variant 1 (fast)
(new RegExp('[0-9]')).test('foobar')

// variant 2 (slower because returns some information about the matches)
'foobar'.match(new RegExp('[0-9]'))