<?php
/**
*@author Drew A. Clinkenbeard
*CloudSuite Exceptions
*/

class Exceptions {

    private $data = array(
        'M_NO_ELEMENT' => 'No Such Element in data definition',
        'C_NO_ELEMENT' => 0
            )

    ;

    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            return '404';
        }
    }

    public static function code($name) {

        if ($name == "error1") {
            return "NO Such element found";
        }
    }

}

?>
