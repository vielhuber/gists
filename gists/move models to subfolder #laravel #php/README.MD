### < laravel 8

- create a new folder "App/Models" and move all your models inside there
- add this to ```composer.json```: ```"autoload": { "classmap": ["app/Models"] }```
- ```composer dump-autoload```

### >= laravel 8

- this is now the default behaviour
- if you need to migrate an old version, create the `Models` directory and search replace with vscode
  -  replacement (regex)
    -  `App\\(?!.*Console)(?!.*Events)(?!.*Exceptions)(?!.*Exports)(?!.*Forms)(?!.*Helpers)(?!.*Http)(?!.*Jobs)(?!.*Listeners)(?!.*Models)(?!.*Policies)(?!.*Providers)(?!.*Traits)([A-Z])`
    -  `App\Models\\$1`
  - search also for `App\\` and replace manually with `App\\Models\\`
