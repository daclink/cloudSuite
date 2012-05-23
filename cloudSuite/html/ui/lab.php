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
                                echo "<h3><a href=\"#\">$parts[1]</a></h3>";
                                echo "<div>";
                                    echo $desc[0];
                                    echo "<div id=\"showMods\">";//<h2><a href=\"#\">Show Modules</a></h2>";
                                        foreach ($modules as $module ) {
                                            
                                            $key = $module['id'];
                                            $value = $module->desc;
                                            //echo "<div id=\"".$module['id']."\" ><h4>$module->desc</h4>";
                                               // foreach($module->fieldset as $fieldset){
                                            $xmlFile = $_ENV['cs']['module_dir'] . Utils::fileName($module['id'],$module['name']);
                                           // echo  Module::getModuleForm($xmlFile);
                                                //}
                                            //echo "</div>";
                                            echo "<div id=\"".$key."_link\" class=\"chiClick csshadow module\" onclick=\"getModToAdd('$xmlFile')\">".$module['name']." </div>";
                                            //<a href=\"#\" id=\"".$key."_link\" class=\"ui_state-default ui-corner-all\"></a>
                                            
                                        }
                                    echo "</div>";
                                echo "</div>";
                           echo "</div>";
                        }
                     }
                    echo "<div id=\"new_collection\" ><h3><a href=\"#\">New Collection</a></h3></div>";
                    closedir($handle);
                    //echo "</ul>";
                    //echo $divList;
                }
            ?>
       
       
        </div>
<div id="lab">
<span style="text-align:center;"><h2>Lab Name</h2></span>
            
            <?php
            
            $lab = new Lab("No_Lab_loaded");
            
            ?>
            <div class="lab-content csshadow">
                 <ul>
                    <li>Please create a lab</li>
                    <li>Or load a previous lab</li>
                    <li>Both buttons below.</li>
                    
                </ul>
            </div>
            
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
            
</div>
<?php 

?>
