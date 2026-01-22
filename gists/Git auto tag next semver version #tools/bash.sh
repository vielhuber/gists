#!/bin/bash
v=`git describe --abbrev=0 --tags 2>/dev/null`
n=(${v//./ })
n1=${n[0]}
n2=${n[1]}
n3=${n[2]}
if [ -z "$n1" ] && [ -z "$n2" ] && [ -z "$n3" ]; then n1=1; n2=0; n3=0
else n3=$((n3+1)); fi
if [ "$n3" == "10" ]; then n3=0; n2=$((n2+1)); fi
if [ "$n2" == "10" ]; then n2=0; n1=$((n1+1)); fi
t="$n1.$n2.$n3"
c=`git rev-parse HEAD`
nt=`git describe --contains $c 2>/dev/null`
if [ -z "$nt" ]; then git tag $t; git push --tags; else echo "already a tag on this commit"; fi