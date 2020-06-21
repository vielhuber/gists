### notes
- devDependencies should contain packages which are used during development or which are used to build your bundle
- all others should/must go into dependencies
- this is important, when you publish your library: devDependencies of installed modules are NOT installed and cannot be used

### installation
```sh
- npm install --save foo
- npm install --save-dev foo
```

### package.json
```json
"dependencies": {
	"foo": "*"
},
"devDependencies": {
	"foo": "*"
}
```