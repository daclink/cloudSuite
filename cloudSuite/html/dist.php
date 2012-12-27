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
session_start();
//$_SESSION['cs']['lab'] = 'foo';
if (isset($_SESSION['cs']['username'])) {
    $_ENV['cs']['username'] = $_SESSION['cs']['username'];
    $uname = $_SESSION['cs']['username'];
}
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'aws' . DIRECTORY_SEPARATOR . 'sdk-1.5.15' . DIRECTORY_SEPARATOR . 'sdk.class.php';
if (isset($_GET['debug'])) {

    $_ENV['cs']['debug'] = $_GET['debug'];
}

$s3 = Utils::getS3Instance();

$source = array ('bucket' => '',
                 'filename' => '');
$dest = $source;

$source['bucket'] = 'cs.user.'.strtolower($_POST['uname']).'.labs';

echo "<pre>";
print_r($_POST);

foreach ($_POST['labDist'] as $lab) {
    echo "<div> $lab : ";
$source['filename'] = $lab;
$dest['filename'] = $lab;
    foreach ($_POST['userDistBox'] as $user) {
     $dest['bucket'] =  'cs.user.'.strtolower($user).'.labs';
     $response = $s3->copy_object($source, $dest);
     //print_r($response);
     echo "<div>";
        echo Lab::cloudCHOWN($user, $lab);
     echo "</div>";
    }
}

echo "</div>";
echo "</pre>";
?>
