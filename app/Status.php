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
    //const STARTLIST = 20;
    const RUNNING   = 30;
    const FINISHED  = 50;
    const OFFICIAL  = 100;
    const HIDDEN  = 110;

    public static $desc = array(0   =>'no iniciado' ,
                                10  =>'configurado',
                                30  =>'en marcha',
                                50  =>'finalizado',
                                100 =>'oficial',
                                110 => 'oculto');


    public static $descOwner = array(0   =>'no iniciado' ,
                                    10  =>'configurado',
                                    30  =>'en marcha');

    public static $colors = array(  0   =>'default' ,
                                    10  =>'primary',
                                    30  =>'info',
                                    50  =>'warning',
                                    100 =>'danger',
                                    110 =>'danger');
}

