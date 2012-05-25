<?php

	function dispr($listing, $title=NULL){
		echo "\n$title\n";
		print_r($listing);
		echo "\n";
	
	}

	function csSer( $obj ) {
		return base64_encode(gzcompress(serialize($obj)));
	}

	function csUnSer( $txt ) {
		return unserialize(gzuncompress(base64_decode($txt)));
	}

	$at = array("method"=>"rsaCrack","decription"=>"Eats babies and kittens");

	$foo = csSer($at);
	dispr($foo, "result of compress thing");

	$foo = csUnSer( $foo );

	dispr($foo, "result of un comp");
	

?>
