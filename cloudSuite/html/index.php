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
<!DOCTYPE html>
<html>
    <head>
        <title>CloudSuite v0.2</title>
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
        <link type="text/css" href="theme/css/blitzer/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="./theme/js/jquery-ui-1.8.18.custom.min.js"></script>
        
        <script type="text/javascript">
          $(function(){
        	// Tabs
		$('#tabs').tabs();
                $("#collections").accordion({ header: "h3" });
                
                	// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});


            });
        </script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
            html {
                /*display:inline;*/
                height: 100%;
                width: 100%;
                margin:0; 
                padding:0;
                font-family: Arial,sans-serif;
            }
            body {
                /*display:inline;*/
                height: 100%;
                width: 100%;
                margin:0; 
                padding:0; 
            }
            div {
               
            }
            #collections {
                   display: block;
                   width: 35%;
                   height: 85%;
                   float: left;                   
                   background-color:#D2E0E6;
                   color: #c00;
                   margin: 3px;
                   border:2% solid white;
                   border-radius:15px;
                   -moz-border-radius:15px;
            }
            #lab {
                display: block;
                width: 64%;
                height: 85%;
                float: left;
                background-color:#D2E0E6;
                color: #c00;
                border-color: white;
                margin: 2px;
                margin-left: 0px;
                border-radius:15px;
                -moz-border-radius:15px; /* Firefox 3.6 and earlier */
                
            }
            div.lab-content {
                width: 85%;
                /*height: 15%;*/
                float: left;
                background-color:white;
                color: #c00;
                padding: 5px;
                margin: 5px;
                border-radius: 15px;

            }
            
            #status-bar {
                display: block;
                width: 100%;
                height: 10%;
                float: right;
                background-color: #D2E0E6;
                margin: 0px auto;
                margin-top: 0px;
                border:2% solid white;
                border-radius:15px;
                -moz-border-radius:15px; /* Firefox 3.6 and earlier */
            }
            div.status-bar-item{
                min-width: 10%;
                float: left;
                background-color:white;
                color: #c00;
                padding:3px;
                margin: 5px;
                border-radius: 15px;
                text-align: center;
            }
            
            #task-bar {
                display: block;
                width: 98%;
                height: 5%;
                /*float: right;*/
                background-color: #D2E0E6;
                padding: 5px;
                margin: 2px auto;
                margin-top: 0px;
                border:2% solid white;
                border-radius:15px;
                -moz-border-radius:15px; /* Firefox 3.6 and earlier */
            }
            div.task-bar-item {
                width: 15%;
                float: left;
                background-color:white;
                color: #c00;
                margin: 5px;
                border-radius: 15px;
                text-align: center;
            }
            
            button {
                padding: 10px;
            }
            
            div.clicked {
                background-color: gray;
            }
            div.csshadow {
                -moz-box-shadow: 4px 4px 10px #888;  
                -webkit-box-shadow: 4px 4px 10px #888;  
                box-shadow:4px 4px 6px #888;
            }
                
        </style>
    </head>
    <body>
            
        <div id="task-bar">
            <div class="task-bar-item chiClick csshadow">Lab</div> 
            <div class="task-bar-item chiClick csshadow">Admin</div>
            <div class="task-bar-item chiClick csshadow">Settings</div>
        </div>
        
        
        <div id="collections">
            <span style="text-align:center;"><h2>Collections</h2></span>
            <?php
            
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
                                echo "<h3><a href=\"#\">$parts[0]</a></h3>";
                                echo "<div>";
                                    echo $desc[0];
                                    echo "<div id=\"showMods\">";//<h2><a href=\"#\">Show Modules</a></h2>";
                                        foreach ($modules as $key => $value) {
                                            
                                            echo "<div id=\"$key\"><h4>$value Description</h4></div>";
                                            
                                            echo "<div><a href=\"#\" id=\"".$key."_link\" class=\"ui_state-default ui-corner-all\">
                                                  $value </a></div>";
                                            ?>
                                        <script> $('#<?php echo $key;?>').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Add to Lab": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#<?php echo $key;?>_link').click(function(){
					$('#<?php echo $key;?>').dialog('open');
					return false;
				});
                                </script>
                                            <?php
                                           
                                            
                                        }
                                    echo "</div>";
                                    
                                echo "</div>";
                            
                           echo "</div>";
                        }
                     }
                    
                    closedir($handle);
                    //echo "</ul>";
                    //echo $divList;
                }
            ?>
       
       
        </div>
        <div id="lab"> 
            <span style="text-align:center;"><h2>Lab Name</h2></span>
            
            <?php
            
            $lab = new Lab("gabbo"); 
            
            ?>
            
            <div class="lab-content csshadow">
                <ul>
                    <li>Module: Genetic Algorithm </li>
                    <li>Crossover : Two-Point</li>
                    <li>Mutation : random </li>
                    <li>Selection : roulette </li>
                    <li>Output Type : module</li>
                    <li>Output Name : Drew_ga_data_001</li>
                </ul>
            </div>
            <div class="lab-content csshadow">
                 <ul>
                    <li>Module: Curve Fitting </li>
                    <li>Input Type: module</li>
                    <li>Input Name: Drew_ga_data</li>
                    <li>Output Type : image</li>
                    <li>Output Name : drew_data_graph_001.jpg</li>
                </ul>
            </div>
            <div class="lab-content csshadow">
                <ul>
                    <li>Module: Genetic Algorithm </li>
                    <li>Crossover : Two-Point</li>
                    <li>Mutation : random </li>
                    <li>Selection : roulette </li>
                    <li>Output Type : module</li>
                    <li>Output Name : Drew_ga_data_002</li>
                </ul>
            </div>
        </div>
        
        <div id="status-bar">
               <div class="status-bar-item chiClick csshadow">Save Lab</div>
               <div class="status-bar-item chiClick csshadow">load Lab</div>
               <span style="float:right;"><div class="status-bar-item">User Name</div></span>
        </div>
        
     
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
             
             $("div.chiClick").mouseup(function(){
                 $(this).addClass("csshadow").removeClass("clicked");
             }).mousedown(function(){
                 $(this).addClass("clicked").removeClass("csshadow");
             }).mouseout(function(){
                 $(this).addClass("csshadow").removeClass("clicked");
             });
             
        </script>
       
        
        
    </body>
</html>

