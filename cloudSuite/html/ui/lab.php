<?php
/* %******************************************************************************************% */
// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php')) {
    include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';
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
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '/cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';
?>
<div id="collections">
    
    <?php include('lab_1.php'); ?>
</div>
<div id="lab">
    <span style="text-align:center;"><h2>Lab Name</h2></span>

    <?php
    $lab = new Lab("No_Lab_loaded");
    ?>
    <div class="lab-content csshadow">
        <ul>
            <li>Load an extant lab</li>
            <li>or you may create a lab</li>
            <li>Please login to start.</li>

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
<?php ?>
