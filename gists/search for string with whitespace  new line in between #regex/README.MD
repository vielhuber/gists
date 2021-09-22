#### regex selector for newline / whitespace
```[\n\r\s]*```

#### example
```if\([\n\r\s]*1[\n\r\s]*==[\n\r\s]*1[\n\r\s]*\)[\n\r\s]*{[\n\r\s]+go\(\);```

finds:
```
if(1==1) { go(); }

if( 1==1 )
{
   go();
}

...
```