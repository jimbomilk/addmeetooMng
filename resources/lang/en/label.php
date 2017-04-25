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
    'loc_desc_name' => 'Please enter the name of the Place',
    'locations.logo' => 'Logo del establecimiento',
    'locations.category' => 'Tipo de establecimiento',
    'locations.owner_id' => 'Nombre del responsable',
    'locations.name' => 'Nombre del establecimiento',
    'locations.phone' => 'Número de teléfono',
    'locations.countries_id' => 'Pais',
    'locations.timezone' => 'Zona horaria',
    'locations.website' => 'Página web',
    'locations.address' => 'Dirección del establecimiento',

    /*ACTIVITIES*/
    'activities.name' => 'Nombre de la actividad',
    'activities.description' => 'Descripción',
    'activities.starttime' => 'Hora de inicio (UTC)',
    'activities.duration' => 'Duración',
    'activities.deadline' => 'Tiempo de suscripción(Si 0, cuando empieza nadie puede más puede participar)',
    'activities.type' => 'Tipo de actividad',
    'activities.category' => 'Categoría',
    'activities.head2head' => 'Enfrentamiento entre 2',
    'activities.selection' => 'Cuantas opciones puedo elegir?',
    'activities.reward_participation' => 'Puntos que obtengo por participar',
    'activities.reward' => 'Activar si el juego da puntos. Ojo, las actividades de tipo votación no otorgan nunca puntos',
    'activities.reward_first' => 'Puntos por ganar el juego',
    'activities.reward_second' => 'Puntos por quedar segundo',
    'activities.reward_third' => 'Puntos por quedar tercero',


    'activity_options' => 'Opctiones de la actividad',
    'activity_options.order' => 'Orden de aparición',
    'activity_options.description'=>'Descripción de la opción',
    'activity_options.image'=>'Imagen asociada',
    'activity_options.result'=>'Resultado de la actividad',

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
    'gameboard_options' => 'opcion de juego',
    'gameboard_options.order' =>'Orden',
    'gameboard_options.description' =>'Descripción',
    'gameboard_options.image' =>'Imagen',
    'gameboard_options.result' =>'Resultado (no rellenar al inicio)',


    /*ADVERTISEMENTS*/
    'advertisements.imagebig' => 'Imagen gran formato(1800x600)',
    'advertisements.imagesmall' => 'Imagen pequeño formato',
    'advertisements.adscategory_id' => 'Categoria',
    'advertisements.name' => 'Nombre del anuncio',
    'advertisements.textsmall1' => 'Cabecera de anuncio',
    'advertisements.textsmall2' => 'Texto de anuncio',
    'advertisements.textbig1' => 'Cabecera de anuncio',
    'advertisements.textbig2' => 'Texto del anuncio',

];
