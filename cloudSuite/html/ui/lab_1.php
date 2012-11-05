<?php

/* %******************************************************************************************% */
// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php')) {
    include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';
}
// Fallback to `~/.aws/sdk/config.inc.php`
//TODO: Chnage this to a set of configuration defaults.
/*
  elseif (getenv('HOME') && file_exists(getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php'))
  {
  include_once getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php';
  }
 */

/* %******************************************************************************************% */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '/cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';
?>
<span style="text-align:center;"><h2>Collections</h2></span>
<?php

$xmlScheme = $_ENV['cs']['schema_dir'] . 'collection.xsd';

if ($handle = opendir($_ENV['cs']['collection_dir'])) {
    // echo "\nDir handle : $handle";
    // $divList = "";
    // echo "<ul>";
    while (false !== ($entry = readdir($handle))) {
        if ($entry != '.' && $entry != '..') {

            $parts = explode(".", $entry);

            $xmlFile = $_ENV['cs']['collection_dir'] . $entry;
            $desc = Collection::getDesc($xmlScheme, $xmlFile);
            $modules = Collection::listModules($xmlScheme, $xmlFile);

            echo "<div class='collection-list'>";
            echo "<h2>$parts[1]</h2>";
            //echo "<div class='module-list'>";//div 2
            echo "<div>";//div 2
            echo $desc[0];
            echo "<div class='coll-mods'>"; //div3
            foreach ($modules as $module) {

                $key = $module['id'];
                $value = $module->desc;
                //echo "<div id=\"".$module['id']."\" ><h4>$module->desc</h4>";
                // foreach($module->fieldset as $fieldset){
                $xmlFile = $_ENV['cs']['module_dir'] . Utils::fileName($module['id'], $module['name']);
                // echo  Module::getModuleForm($xmlFile);
                //}
                //echo "</div>";
                echo "<div id=\"" . $key . "_link\" class=\"chiClick csshadow module\" onclick=\"getModToAdd('$xmlFile')\">" . $module['name'] . " </div>";
                //<a href=\"#\" id=\"".$key."_link\" class=\"ui_state-default ui-corner-all\"></a>
            }
            echo "</div>";//div3 coll-mods
            echo "</div>";//div2 module-list
            echo "</div>";//div 1 collection-list
        }
    }

    closedir($handle);
    //echo "</ul>";
    //echo $divList;
}
if (isset($_SESSION['cs']['username']) || isset($_GET['uname'])){
    
    $uname = isset($_SESSION['cs']['username']) ? $_SESSION['cs']['username'] : $_GET['uname'];
    
echo "<div class='collection-list'>";
            echo "<h2> $uname's Modules</h2>";
            echo "<div class='module-list'>";//div 2
            //echo $desc[0];
            echo "description";
            echo "<div class='coll-mods'>"; //div3
            echo "<div id=\"blarg_link\" class=\"chiClick csshadow module\" onclick=\"getModToAdd(foo)\">Mod Name </div>";
            /*
            foreach ($modules as $module) {

                $key = $module['id'];
                $value = $module->desc;
                //echo "<div id=\"".$module['id']."\" ><h4>$module->desc</h4>";
                // foreach($module->fieldset as $fieldset){
                $xmlFile = $_ENV['cs']['module_dir'] . Utils::fileName($module['id'], $module['name']);
                // echo  Module::getModuleForm($xmlFile);
                //}
                //echo "</div>";
                echo "<div id=\"" . $key . "_link\" class=\"chiClick csshadow module\" onclick=\"getModToAdd('$xmlFile')\">" . $module['name'] . " </div>";
                //<a href=\"#\" id=\"".$key."_link\" class=\"ui_state-default ui-corner-all\"></a>
            }
            */
            echo "</div>";//div3 coll-mods
            echo "</div>";//div2 module-list
            echo "</div>";//div 1 collection-list
}


?>