#!/bin/bash
FOO=`which python`
BAR=`which asdasd`

echo $FOO
echo $BAR

if [$FOO !=""]
	then
		echo "FOO!"
	else
		echo "blah"
fi

if [$BAR != ""]
	then
		echo "NO!!!"
	else
		echo "yeah!"
fi

