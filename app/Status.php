<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 3/10/2017
 * Time: 7:46 AM
 */

namespace App;



class Status {

    const DISABLED  = 0;
    const SCHEDULED = 10;
    const STARTLIST = 20;
    const RUNNING   = 30;
    const FINISHED  = 50;
    const OFFICIAL  = 100;

    public static $desc = array(0   =>'disabled' ,
                                10  =>'scheduled',
                                20  =>'startlist',
                                30  =>'running',
                                50  =>'finished',
                                100 =>'official');

    public static $colors = array(  0   =>'default' ,
                                    10  =>'primary',
                                    20  =>'success',
                                    30  =>'info',
                                    50  =>'warning',
                                    100 =>'danger');
}

