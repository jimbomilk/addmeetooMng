<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    /* LOCATIONS */
    'locations' => 'Lugares',
    'loc_name' => 'Nombre',
    'loc_desc_name'=> 'Please enter the name of the Place',


    /* GAMEBOARDS */
    'gameboards' => 'Juegos',
    'gameboards.activity_id' => 'Tipo de actividad que deseas crear',
    'gameboards.location_id' => 'Lugar',
    'gameboards.name' =>'Nombre de la actividad',
    'gameboards.description' =>'Descripción',
    'gameboards.auto' =>'Gestión diferida?. Si es una actividad propia debes desmarcarlo(porque tú decides cuando termina)',
    'gameboards.starttime' =>'Hora de Inicio',
    'gameboards.duration' =>'Duración',
    'gameboards.deadline' =>'Tiempo para participar (en minutos), si es 0 significa que en cuanto empiece se cierra la participación.',
    'gameboards.participation_status' =>'Estado de participación',
    'gameboards.selection' =>'Cuantas opciones hay que elegir? . En caso de partidos poner 0',
    'gameboards.progression_type' =>'Tipo de progresión',
    'gameboards.multiscreen' =>'Multipantalla? Dejalo desmarcado.',

    /*GAMEBOARD OPTIONS*/
    'gameboard_options.order' =>'Orden',
    'gameboard_options.description' =>'Descripción',
    'gameboard_options.image' =>'Imagen',
    'gameboard_options.result' =>'Resultado (no rellenar al inicio)',


];
