<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php 
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php'))
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
}
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';

$_ENV['cs']['debug'] = TRUE;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $group = new Group();
            
            print_r($group->getUserData("1", "collection"));
            
        ?>
    </body>
</html>
