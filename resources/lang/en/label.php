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

    /*USER*/
    'users.name'=>'Nombre',
    'users.email'=>'Email',
    'users.edit'=>'Editar',
    'users.profile'=>'Detalles',
    'users.password'=>'Password',
    'users.password2'=>'Reintroduce la password',
    'users.type'=>'Tipo de usuario',


    'userprofiles.avatar' => 'Foto',
    'userprofiles.gender' => 'Sexo',
    'userprofiles.points' => 'Puntos',
    'userprofiles.rank' => 'Ranking',
    'userprofiles.bio' => 'Biografia',
    'userprofiles.phone' => 'Teléfono',



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
    'activities.type' => 'Tipo de actividad',
    'activities.category' => 'Categoría',
    'activities.head2head' => 'Enfrentamiento entre 2',
    'activities.selection' => 'Cuantas opciones puedo elegir?',
    'activities.reward_participation' => 'Puntos que obtengo por participar',
    'activities.reward' => 'Activar si el juego da puntos. Ojo, las actividades de tipo votación no otorgan nunca puntos',
    'activities.reward_first' => 'Puntos por ganar el juego',
    'activities.reward_second' => 'Puntos por quedar segundo',
    'activities.reward_third' => 'Puntos por quedar tercero',
    'activities.edit' => 'Editar',
    'activities.options' => 'Opciones',


    'activity_options' => 'Opctiones de la actividad',
    'activity_options.order' => 'Orden de aparición',
    'activity_options.description'=>'Descripción de la opción',
    'activity_options.image'=>'Imagen asociada',
    'activity_options.result'=>'Resultado de la actividad',

    /* GAMEBOARDS */
    'gameboards' => 'Juegos',
    'gameboards.activity_id' => 'Tipo de actividad que deseas crear',
    'gameboards.location_id' => 'Lugar',

    'gameboards.name' =>'Nombre del Juego',
    'gameboards.description' =>'Descripción',
    'gameboards.auto' =>'Gestión diferida?. Si es una actividad propia debes desmarcarlo(porque tú decides cuando termina)',
    'gameboards.startgame' =>'Inicio del Juego',
    'gameboards.endgame' =>'Fin del Juego',
    'gameboards.status' =>'Estado',
    'gameboards.options' =>'Opciones',
    'gameboards.deadline' =>'Fecha tope de participación(si está vacio significa que no hay tope): ',
    'gameboards.selection' =>'Cuantas opciones hay que elegir? . En caso de partidos poner 0',
    'gameboards.progression_type' =>'Tipo de progresión',
    'gameboards.multiscreen' =>'Multipantalla? Dejalo desmarcado.',
    'gameboards.endgame' =>'Fin del juego(si lo dejamos vacio significa que estará ejecutándose para siempre): ',

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
    'advertisements.textbig' => 'Texto anuncio gran formato',
    'advertisements.textsmall' => 'Texto anuncio pequeño formato',
    'advertisements.textsmall1' => 'Cabecera de anuncio',
    'advertisements.textsmall2' => 'Texto de anuncio',
    'advertisements.textbig1' => 'Cabecera de anuncio',
    'advertisements.textbig2' => 'Texto del anuncio',
    'advertisements.edit' => 'Editar',
    'advertisements.packs' => 'Impactos',

];
