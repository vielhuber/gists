- `npm audit` reads your package.json and checks the version of its dependencies against a security vulnerability database.
- `npm audit fix` does is upgrade the unsafe dependencies of your project and only modifies the dependencies that shouldn't cause problems based on semver rules. other developers also get this change, if package-lock.json is checked in git.
- `npm audit fix --force` can be dangerious option because it upgrades the dependencies regardless of any rules. This can cause a dependency to go from version 1.2.0 to version 2.3.0, for example.

#### main command
```sh
npm audit
```

#### show all subpackages that are unsafe 
```sh
npm audit | grep Package
```

#### show top level dependency that rely on potentially unsafe subpackages
```sh
npm list some-subpackage
```