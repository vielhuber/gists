- `npm audit` reads your `package.json` and checks the version of its dependencies against a security vulnerability database.
- `npm audit fix` upgrades unsafe dependencies and only modifies those that shouldn't cause problems based on semver rules.\
other developers also get this change, because `package-lock.json` is modified (the file must be checked in git).
- `npm audit fix --force` can be dangerous because it upgrades the dependencies regardless of any rules. this can cause e.g. a dependency to go from version 1.2.0 to version 2.3.0.

#### main commands
```sh
npm audit
npm audit fix
npm audit fix --force
```

#### show all subpackages that are unsafe 
```sh
npm audit | grep Package
```

#### show top level dependency that rely on potentially unsafe subpackages
```sh
npm list some-subpackage
```

#### if a dependency cannot be upgraded through npm run fix

##### option 1
- fork the repository on github (only master)
- create a new branch called `BRANCH-WITH-FIX`
- run `npm audit` / `npm audit fix` / `npm audit fix --force`
- push changed `package.json` / `package-lock.json`
- change `"broken-package": "^2.0.0"` to `"broken-package": "github-username/broken-package#BRANCH-WITH-FIX",` in your `package.json`

##### option 2 (only available on npm >= 8.3)
- add to your `package.json`: `"overrides": { "nth-check": ">=2.0.1" }`