<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $first = array( "root" => "element");
            $second = array( "systemReq" => array ("product" => "php", "version" => "5"));
            $third = array( "systemReq" => array ("product" => "java", "version" => "6"));
            echo "<pre>";
                print_r($first);
                print_r($second);
            echo "</pre>";
            echo "<div>contatinating...</div>";
            echo "<pre>";
                array_push($first,$second);
                array_push($first,$third);
                
                print_r($first);
            echo "</pre>";
                
        ?>
    </body>
</html>
