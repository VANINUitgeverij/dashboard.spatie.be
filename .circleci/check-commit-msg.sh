#!/bin/bash

function checkExitCode {
   RC=$?
   if [ "$RC" != 0 ]; then
     echo "Invalid commit message"
     exit $RC;
   fi
}

for message in "$@"
do
	echo 'Checking commit: "'$message'"'
	echo $message > commit-msg
	php vendor\/bin\/grumphp git:commit-msg -q commit-msg
	checkExitCode
done
