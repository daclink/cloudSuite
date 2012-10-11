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

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'aws' . DIRECTORY_SEPARATOR . 'sdk-1.5.15'  . DIRECTORY_SEPARATOR . 'sdk.class.php';
$_ENV['cs']['debug'] = TRUE;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Test Fire</title>
          <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
        <link type="text/css" href="theme/css/blitzer/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        <link type="text/css" href="./styles/main.css" rel="stylesheet" />
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="./theme/js/jquery-ui-1.8.18.custom.min.js"></script>
    </head>
    <body>
        
        <div id="labRunner">
            <button id="runlab">RUN THE LAB YO</button>
        </div>
        <div id="results"></div>
        <?php
          /*  $group = new Group();
            
           print_r($group->getUserData("1", "groups"));
        */    
        ?>
        <?php 
            $ec2 = new AmazonEC2( array (
                'key'       =>  'AKIAI4HYP3G5GQ2CG7MQ',
                'secret'    =>  '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' 
            ));
           
            
            $s3 = new AmazonS3 ( array (
                'key'       =>  'AKIAI4HYP3G5GQ2CG7MQ',
                'secret'    =>  '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' 
            ));
            
            $bucket     = 'cloudsuite.labs';
            $filename   = '1987.ajs.xml';
            
            $lab = file_get_contents($_ENV['cs']['labs_dir'].$filename);
            
            $response = $s3->create_object($bucket, $filename, array( 'body' => $lab));
            
            //$response = $s3->delete_all_objects($bucket);
            
            Utils::showStuff($response, "response object");
           
            
            /*
            $instance_id ='i-6f8d0812';
            
            $response = $ec2->start_instances($instance_id);
            
            var_dump($response->isOK());
            
            if ($response->isOK()) {
                $ec2->stop_instances($instance_id);
            }
            
            var_dump($response->isOK());
            */
        ?>
        <script>
            $('#labRunner').on('click', '#runlab', function(){ 
                
                $.ajax({ 
                    type: 'post',
                    url: "/cloudCommand/ec2",
                    success: function(data) {
                        console.log(data);
                        $("#results").append("boop");
                        //actionHandler(data);                      
                    } 
                });
            });
        </script>
    </body>
    
    
</html>
