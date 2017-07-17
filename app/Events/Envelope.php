<?php

namespace App\Events;

class Envelope
{
    public $stext;
    public $ltext;
    public $image;
    public $type;
    public $reward;
    public $logo1;

    public function setText($short, $options)
    {
        $this->stext = $short;
        foreach($options as $key=>$option){
            if ($key>0)
                $this->ltext.=",";
            $this->ltext .= implode(' - ',$option);


        }
    }
}
