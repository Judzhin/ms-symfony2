#!/bin/sh
#
## store the arguments given to the script
#read oldrev newrev refname

## Where to store the log information about the updates
LOGFILE=./post-receive.log

# The deployed directory (the running site)
DEPLOYDIR=./

##  Record the fact that the push has been received
echo -e "Received Push Request at $( date +%F )" >> $LOGFILE
#echo " - Old SHA: $oldrev New SHA: $newrev Branch Name: $refname" >> $LOGFILE
#
### Update the deployed copy
echo "Starting Deploy" >> $LOGFILE

echo " - Starting code update"
### GIT_WORK_TREE="$DEPLOYDIR" git checkout -f
git pull
echo " - Finished code update"
#
#echo " - Starting composer update"
#cd "$DEPLOYDIR"; composer update; cd -
#echo " - Finished composer update"
#
#echo "Finished Deploy" >> $LOGFILE