<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bucket.php
 *
 * @author Drew A. Clinkenbeard
 */
?>
<?php

if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php')) {
    include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
}
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'aws' . DIRECTORY_SEPARATOR . 'sdk-1.5.15' . DIRECTORY_SEPARATOR . 'sdk.class.php';
$_ENV['cs']['debug'] = TRUE;

require 'Slim/Slim.php';

$app = new Slim();

$app->get('/cloudCommand/:func', function ($func) {
            switch ($func) {
                case "ec2" :
                    ec2();
                    break;
                case "s3" :
                    s3();
                    break;
                default :
                    defaulto();
                    break;
            }
        });

$app->get('/hi', function() {
            defaulto();
        });

function ec2() {
    $ec2 = new AmazonEC2(array(
                'key' => 'AKIAI4HYP3G5GQ2CG7MQ',
                'secret' => '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'
            ));


    $instance_id = 'i-6f8d0812';

    $response = $ec2->start_instances($instance_id);

    var_dump($response->isOK());

    if ($response->isOK()) {
        $ec2->stop_instances($instance_id);
    }
}

function s3() {

    $s3 = new AmazonS3(array(
                'key' => 'AKIAI4HYP3G5GQ2CG7MQ',
                'secret' => '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'
            ));


    echo "<div>in the thing</div>";
    $bucket = 'cs.user.Drew.modules';

    if ($s3->if_bucket_exists($bucket)) {
        echo "bucket $bucket exists";
    }
    
    $response = $s3->list_objects($bucket);
    
    
    
    
/*
    $lab = file_get_contents($_ENV['cs']['labs_dir'] . $filename);

    $response = $s3->create_object($bucket, $filename, array('body' => $lab));

    $response = $s3->delete_all_objects($bucket);

    var_dump($response->isOK());
 */
 
}

function defaulto() {
    $foo = "<html>
            <head> <title>gah</title></head>
            <body>Well sir</body>
        </html>";
    echo $foo;
}
?> 
