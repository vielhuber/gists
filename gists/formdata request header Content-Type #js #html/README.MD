### multipart/form-data
- this is used when you send forms via js with XMLHttpRequest or fetch and set no Content-Type
- this is recommended when sending forms via js with data of type FormData
- be aware: don't set this manually, because the browser (not nodejs!) adds needed boundary=---- suffixes to the Content-Type
- this is used when you send default forms with uploads in the browser where the multipart attribute is set

### application/json
- always use this when you send forms with classical object typed data

### application/x-www-form-urlencoded
- this is used when you send default forms in the browser
