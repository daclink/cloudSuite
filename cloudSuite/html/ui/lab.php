<?php ?>
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
                                        foreach ($modules as $module ) {
                                            $key = $module['id'];
                                            $value = $module->desc;
                                            echo "<div id=\"".$module['id']."\" ><h4>$module->desc</h4></div>";
                                            
                                            echo "<div id=\"".$key."_link\" class=\"chiClick csshadow module\">".$module['name']." </div>";
                                            //<a href=\"#\" id=\"".$key."_link\" class=\"ui_state-default ui-corner-all\"></a>
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
<?php ?>
