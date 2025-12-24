## depcheck

```sh
npm install depcheck -g
depcheck --skip-missing=true
```

## npm-check

```sh
npm install -g npm-check
npm-check
```

## manual

```unushed.sh
#!/bin/bash
DIRNAME=${1:-.}
cd $DIRNAME
FILES=$(mktemp)
PACKAGES=$(mktemp)

function check {
    cat package.json \
        | jq "{} + .$1 | keys" \
        | sed -n 's/.*"\(.*\)".*/\1/p' > $PACKAGES
    echo "--------------------------"
    echo "Checking $1..."
    fdfind '(js|ts|json)$' -t f > $FILES
    while read PACKAGE
    do
        if [ -d "node_modules/${PACKAGE}" ]; then
            fdfind  -t f '(js|ts|json)$' node_modules/${PACKAGE} >> $FILES
        fi
        RES=$(cat $FILES | xargs -I {} egrep -i "(import|require|loader|plugins|${PACKAGE}).*['\"](${PACKAGE}|.?\d+)[\"']" '{}' | wc -l)
        if [ $RES = 0 ]
        then
            echo -e "UNUSED\t\t $PACKAGE"
        else
            echo -e "USED ($RES)\t $PACKAGE"
        fi
    done < $PACKAGES
}

check "dependencies"
check "devDependencies"
check "peerDependencies"
```