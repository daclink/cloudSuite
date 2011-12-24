<?php

	class utils{
	
		public static function getID(){
			$filename = "id.txt";
			$handle = fopen($filename, "r");
			$contents = stream_get_contents($handle);
			fclose($handle);
			return $contents;
		}
		
		public static function getNewID(){
			$contents = utils::getID()+1;	
			utils::setID($contents);
			return $contents;
		}
		
		public static function setID($value){
			$filename = "id.txt";
			$handle = fopen($filename, 'w');
			fwrite($handle, $value);
			fclose($handle);			
		}
		
	}

?>
