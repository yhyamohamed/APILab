<?php

namespace App;

class Counter
{

    static public function addVisit()
    {

        $visits = self::getVisits();
        $fp = fopen(counterFile, 'w');
        if (empty($visits)) {
            $visits = 0;
            // echo $visits. "or 2";
        }
        (int)$visits += 1;
        $f = fwrite($fp, "$visits" . PHP_EOL . "");
        fclose($fp);
    }
    static public function getVisits()
    {
        $fp = fopen(counterFile, 'r');
        $line = fgets($fp);
        $data = explode(",", $line);
        return  $data[0];
    }
}
