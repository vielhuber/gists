#!/bin/bash
if [ $# -ne 1 ] ; then
  echo "file missing"
fi
csplit -s -ftable $1 "/-- Table structure for table/" {*}
mv table00 head
for FILE in `ls -1 table*`; do
      NAME=`head -n1 $FILE | cut -d$'\x60' -f2`
      cat head $FILE > "$NAME.sql"
done
rm head table*