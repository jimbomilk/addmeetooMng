<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 3/10/2017
 * Time: 7:46 AM
 */

namespace App;

use Illuminate\Support\Facades\DB;
use GeneaLabs\Phpgmaps\Facades\PhpgmapsFacade as Gmaps;


class General {

    public static function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $i=>$value )
        {
            $v = trim( $value, "'" );
            $enum = array_add($enum, $value, trans('label.'.$v));
        }
        return $enum;
    }

/*
 *
 * Para que funcione hay que crear 3 campos en el formulario que se tienen q llamar : address , latitude y longitude
*/
    public static function createMap($element,$withcircle=null)
    {
        //MAPA
        $config = array();
        if (isset($element))
            $config['center'] = $element->latitude.','.$element->longitude;
        else
            $config['center'] = '40.3043316,-4.0669747';
        if (isset($element))
            $config['zoom'] = '10';
        else
            $config['zoom'] = '5';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'address';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] =

            'var place = placesAutocomplete.getPlace();
             if (place.geometry.viewport) {
                 map.fitBounds(place.geometry.viewport);
             } else {
                 map.setCenter(place.geometry.location);
                 map.setZoom(17);
             }

            $("#latitude").val(place.geometry.location.lat());
            $("#longitude").val(place.geometry.location.lng());
             ';


        if (isset($withcircle)) {
            $circle = array();
            $circle['center'] = $config['center'];
            if (isset($element) && isset($element->radio))
                $circle['radius'] = $element->radio * 1000;
            else
                $circle['radius'] = 25000;
            Gmaps::add_circle($circle);
        }

        Gmaps::initialize($config);

        return Gmaps::create_map();
    }

    public static function getRawWhere($searchable,$search)
    {
        $where = " (1 = 2 ";
        foreach($searchable as $searchfield)
        {
            $where .= " or ";
            $where .= $searchfield;
            $where .= " like '%";
            $where .= $search;
            $where .= "%'";
        }
        $where .= ")";
        return $where;
    }


}

