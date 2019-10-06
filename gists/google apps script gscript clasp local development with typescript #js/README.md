## installation
- ```npm i @google/clasp -g```
- https://script.google.com/home/usersettings => enable
- ```npm i -S @types/google-apps-script```
- ```clasp login```

## setup
- ```clasp clone 1rQUd0avboM0vYHIpWCY8aRKhSPhZaCybK7P0yv_LE6HUWtYxHprhRI0J``` (you can get the script id from Datei > Projekteigenschaften)
- ```nano jsconfig.json```: ```{ "compilerOptions": { "lib": ["esnext"] } }```

## usage
- ```clasp pull```
- convert all js files to ts files to use the newest js features
- ```clasp push --watch```

## define unknown vendor lib variables in first line
```ts
declare let SpreadsheetApp: any, UrlFetchApp: any, Utilities: any, console: any;
```