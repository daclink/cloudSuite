<?php
/*%******************************************************************************************%*/
// CORE DEPENDENCIES

// Look for include file in the same directory (e.g. `./config.inc.php`).
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php'))
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
}
// Fallback to `~/.aws/sdk/config.inc.php`
//TODO: Chnage this to a set of configuration defaults.
/*
elseif (getenv('HOME') && file_exists(getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php'))
{
	include_once getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php';
}
*/

/*%******************************************************************************************%*/

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Jquery!</title>
        <link type="text/css" href="theme/css/blitzer/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="./theme/js/jquery-ui-1.8.18.custom.min.js"></script>
        
        <script type="text/javascript">
          $(function(){
        	// Tabs
		$('#tabs').tabs();
                $("#collections").accordion({ header: "h3" });
            });
        </script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
            #collections {width: 25%;}
        </style>
    </head>
    <body>
        
        
        
            
        
        <h3>Collections</h3>
        <div id="collections">
            <?php
            
            $xmlScheme = $_ENV['cs']['schema_dir'].'collection.xsd';
            $xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
            
            
                if ($handle = opendir($_ENV['cs']['collection_dir'])) {
                   // echo "\nDir handle : $handle";
                    $id = 1;
                   // $divList = "";
                   // echo "<ul>";
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != '.' && $entry != '..' ) {
                           
                            $parts = explode(".", $entry);
                            
                            $xmlFile = $_ENV['cs']['collection_dir'].$entry;
                            $desc = Collection::getDesc($xmlScheme, $xmlFile);
                            
                            echo "<div>";
                                echo "<h3><a href=\"#\">$parts[0]</a></h3>";
                                echo "<div>$desc[0]</div>";
                            echo "</div>";
                        }
                     }
                    
                    closedir($handle);
                    //echo "</ul>";
                    //echo $divList;
                }
            ?>
       
       
        </div>
        
        
        <div id="module"></div>
        <div id="time"></div>
        <div id="all"></div>
        <button>Get module!</button>
        
        <div id="data"></div>
        <script type="text/javascript">
         <?php
             $xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
             
             
         ?>
            
            $(document).ready(function(){
                $("button").click(function(){
                $("#module").load('./rest.php?listModule=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>');
                });
            });
            
             $("div.modList").live('click', function() {
                var id = this.id;
                $("#data").load('./rest.php?colGetModID=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>&modid='+id);
             });
             
             $("div.colList").live('click', function() {
                 $("#colDesc").load('./rest.php?colGetDesc=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>');
             });
             
        </script>
       
        <?php
        $mod = new Module(Null,Null);

        $parms = array('flag' => '-t', 
               'value' =>'text',
               'description' =>'returns a text file',
               'required' =>'false',
               'dataType' =>'text',
               'default' => 'false',
               'exclusive' => array('-T','-F','-r'),
               'output' =>'text file',
               'input' => '');
        
        $mod->addParam($parms);
        
        $parms = array('flag' => '-V', 
               'value' =>'',
               'description' =>'Verbose output',
               'required' =>'false',
               'dataType' =>'n/a',
               'default' => 'false',
               'exclusive' => array(),
               'output' =>'N/A',
               'input' => '');
        $mod->addParam($parms);
        
        
       	//Utils::showStuff($mod->listParamters());
        
        /*
        echo "<div id=\"domThing\">";
        
        $foo = new Lab('gabbo');
        
        $xmlFile = $_ENV['cs']['labs_dir'].$foo->__get('labName');
        $xmlSchema = $_ENV['cs']['schema_dir']."lab.xsd";
        
        $foo->addModule($xmlFile, $xmlSchema, array('seqNumber'=>'5',
                                                       'id'=>'1234',
                                                       'method'=>'ga.exe',
                                                       'settings'=>'-fbar.xml',
                                                       'attrString'=>'attribute'
                                                      ));
        
        echo $foo->writeLab();
       
       $bar = $foo->listModules();
       Utils::showStuff($bar); 
       
        
        echo "</div>";
         
         */
        
        ?>
        
        
        
    </body>
</html>
