#!/bin/bash

# file rotation
# -- this is not possible with logrotate, since we do it remotely
# -- it's also not possible to push 1000x delete commands, so do one combined command

SSH_HOST="xxx"
SSH_PORT=22
SSH_USERNAME="xxx"
SSH_PATH="/xxx/yyy/zzz"
SSH_BACKUPFILE="/db/backup-%D.zip"

FOLDERS=`ssh -o StrictHostKeyChecking=no -p $SSH_PORT -l $SSH_USERNAME $SSH_HOST ls -A1 $SSH_PATH/`
for FOLDERS__VALUE in $FOLDERS; do

    FILELIST=""
    D_CUR="2020-01-01"
    D_END=$(date +'%Y-%m-%d')
    #D_END="2023-10-13" # debug
    OLDEST=true
    while [ "$D_CUR" != "$D_END" ]; do
      #echo $D_CUR
      ## do this in reverse order
      # oldest
        if [[ $OLDEST == true ]]; then
            OLDEST=false && echo "4: $D_CUR";
      # all yearlies                                                 
      elif [[ $(date +'%d' -d $D_CUR) == 01 && $(date +'%m' -d $D_CUR) == 01 ]]; then
            echo "3: $D_CUR";  
      # last 12 monthlies                                                               
      elif [[ $D_CUR > $(date +%F -d '12 months ago') && $(date +'%d' -d $D_CUR) == 01 ]]; then
            echo "2: $D_CUR";           
      # last 14 dailies
      elif [[ $D_CUR > $(date +%F -d '14 days ago') ]]; then
            echo "1: $D_CUR";
      else
            FILELIST+=" $SSH_PATH/$FOLDERS__VALUE${SSH_BACKUPFILE//\%D/X}"
            echo "D: $D_CUR"
      fi
      D_CUR=$(date -I -d "$D_CUR + 1 day")
    done

    # run single command (for performance reasons)
    ssh -o StrictHostKeyChecking=no -p $SSH_PORT -l $SSH_USERNAME $SSH_HOST rm$FILELIST

done
