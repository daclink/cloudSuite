<?php

if ($handle = opendir('/Users/dclinkenbeard/')) {
	echo "Dirs handle: $handle\n";
	echo "Entries:\n";

	while (false !== ($entry = readdir($handle))){
			echo "$entry\n";
			preg_match('/^.*\..*$/',$entry,$matches);
	}

	echo "list?\n\n";

	print_r($matches);

	closedir($handle);
}



?>
