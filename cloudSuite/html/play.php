<?php

/* %******************************************************************************************% */
// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php')) {
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

/* %******************************************************************************************% */
/*session_start();
//$_SESSION['cs']['lab'] = 'foo';
if (isset($_SESSION['cs']['username'])) {
    $_ENV['cs']['username'] = $_SESSION['cs']['username'];
    $uname = $_SESSION['cs']['username'];
}
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'aws' . DIRECTORY_SEPARATOR . 'sdk-1.5.15' . DIRECTORY_SEPARATOR . 'sdk.class.php';

$s3 = Utils::getS3Instance();
$bucket = "cs.user.drew.labs";
$filename = "10429.CloudSuite_lab_001.xml";

if ($s3->if_bucket_exists($bucket) ) {
    
    $response = $s3->get_object($bucket, $filename);
  
    //$lab = simplexml_load_file('labs/16775.Baller.xml');
    $lab = simplexml_load_string($response->body);
    echo $lab->owner;
    $lab->owner = "Drew";
    $response = $s3->create_object($bucket, $filename, array('body' => $lab->asXML()));
    
    echo "<pre>";
    print_r($response);
echo "</pre>";  
}
*/
echo "<div>Hi</div>";
print_r($_REQUEST);

?>
