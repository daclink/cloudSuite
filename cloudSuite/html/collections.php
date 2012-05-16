<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//kill below
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php'))
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
}
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';

$_ENV['cs']['debug'] = TRUE;

//kill above

//$collection = new Collection("a glorius test collection", "22", "benny");

//echo  $collection->getFileName();

//$collection->writeCollection();
/*

$xmlScheme = $_ENV['cs']['schema_dir'].'collection.xsd';
$xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
            
if ($handle = opendir($_ENV['cs']['collection_dir'])) {
                   // echo "\nDir handle : $handle";
                    
                   // $divList = "";
                   // echo "<ul>";
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != '.' && $entry != '..' ) {
                           
                            $parts = explode(".", $entry);
                            
                            $xmlFile = $_ENV['cs']['collection_dir'].$entry;
                            $desc = Collection::getDesc($xmlScheme, $xmlFile);
                            $modules = Collection::listModules($xmlScheme, $xmlFile);
                            
                            echo "<div>";
                                echo "<h3><a href=\"#\">$parts[1]</a></h3>";
                                echo "<div>";
                                    echo $entry;
                                    echo $desc[0];
                                    echo "<div id=\"showMods\">";//<h2><a href=\"#\">Show Modules</a></h2>";
                                        
                                    echo "</div>";
                                    
                                echo "</div>";
                            
                           echo "</div>";
                        }
                     }
                    
                    closedir($handle);
                    //echo "</ul>";
                    //echo $divList;
                }
*/


?>
<script>
    function foo(barbar) {
        alert(barbar);
    }
</script>
<div id="collection" onclick="foo('hiThere')">
    HOWDY!
<?php 
//Lab::removeModuleById("6015", "574");
?>    
</div>