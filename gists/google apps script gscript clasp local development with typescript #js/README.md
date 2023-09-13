## installation
- ```nvm use 14.18.0```
- ```npm install @google/clasp -g```
- https://script.google.com/home/usersettings => enable
- ```npm install @types/google-apps-script -g```
- ```clasp login```

## update

- `npm update @google/clasp -g`

## setup
- ```clasp clone 1rQUd0avboM0vYHIpWCY8aRKhSPhZaCybK7P0yv_LE6HUWtYxHprhRI0J``` (you can get the script id from Datei > Projekteigenschaften)
- ```nano jsconfig.json```: ```{ "compilerOptions": { "lib": ["esnext"] } }```

## usage
- ```clasp pull```
- convert all js files to ts files to use the newest js features
- ```clasp push --watch```

## define unknown vendor lib variables in first line
```ts
declare let SpreadsheetApp: any, UrlFetchApp: any, Utilities: any, console: any, Logger: any, Session: any, Analytics: any, SCRIPTS: any;
```