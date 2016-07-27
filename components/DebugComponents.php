<?php

namespace app\components;

/**
 * Developer Specific
 */
class DebugComponents {

    public static function echoArr($arr) {
        print("<pre>");
        print_r($arr);
        print("</pre>");
        exit;
    }

}

?>