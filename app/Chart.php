<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 3/10/2017
 * Time: 7:46 AM
 */

namespace App;


class Chart {

    public $type; //string
    public $dataSeries = [];

    public function __construct($type)
    {
        $this->type=$type;
    }

}

