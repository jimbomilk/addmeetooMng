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
    'create_new' => 'Nuevo',


    /* LOGIN */
    'login' => 'Inicio',
    'login.email' => 'Email',
    'login.register' => 'Inscribirse',
    'login.name' => 'Nombre',
    'login.password' => 'Contraseña',
    'login.forgot' => '¿Olvidaste tu contraseña?',
    'login.recuerda' => 'Recuérdame',
    'login.social_login' => 'O con tu cuenta de google...',
    'login.login' => 'Adelante',
    'login.reset' => 'Reiniciar contraseña',
    'login.whops' => 'Ups!',
    'login.problems' => 'Parece que hubo algún problema',
    'login.confirm_password' => 'Confirmar contraseña',
    'login.reset_link' => 'Enviar enlace para reiniciar contraseña',

    /*USER*/
    'users' => ' Usuario',
    'users.name'=>'Nombre',
    'users.email'=>'Email',
    'users.edit'=>'Editar',
    'users.profile'=>'Detalles',
    'users.password'=>'Password',
    'users.password2'=>'Reintroduce la password',
    'users.type'=>'Tipo de usuario',


    'userprofiles' => ' Perfil',
    'userprofiles.avatar' => 'Foto',
    'userprofiles.gender' => 'Sexo',
    'userprofiles.points' => 'Puntos',
    'userprofiles.rank' => 'Ranking',
    'userprofiles.bio' => 'Biografia',
    'userprofiles.phone' => 'Teléfono',
    'userprofiles.location_id' => 'Lugar de inscripción',



    /* LOCATIONS */
    'locations' => 'Lugar',
    'loc_name' => 'Nombre',
    'loc_desc_name' => 'Please enter the name of the Place',
    'locations.logo' => 'Logo del establecimiento',
    'locations.category' => 'Tipo de establecimiento',
    'locations.owner_id' => 'Nombre del responsable',
    'locations.name' => 'Nombre lugar',
    'locations.phone' => 'Número de teléfono',
    'locations.countries_id' => 'Pais',
    'locations.parent' => 'Localidad Padre',
    'locations.timezone' => 'Zona horaria',
    'locations.website' => 'Página web',
    'locations.address' => 'Dirección del establecimiento',
    'locations.parent_id' => 'Zona donde está el establecimiento',

    /*ACTIVITIES*/
    'activities' => 'Actividad',
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
    'gameboards' => 'Juego',
    'gameboards.activity_id' => 'Tipo de actividad que deseas crear',
    'gameboards.location_id' => 'Lugar',
    'gameboards.dates' =>'Fechas de juego',
    'gameboards.name' =>'Nombre',
    'gameboards.description' =>'Descripción',
    'gameboards.auto' =>'Gestión diferida?. Si es una actividad propia debes desmarcarlo(porque tú decides cuando termina)',
    'gameboards.startgame' =>'Inicio Juego',
    'gameboards.endgame' =>'Fin Juego',
    'gameboards.status' =>'Estado',
    'gameboards.options' =>'Opciones',
    'gameboards.category' => 'Categoria',
    'gameboards.deadline' =>'Participación hasta',
    'gameboards.selection' =>'Cuantas opciones hay que elegir? . En caso de partidos poner 0',
    'gameboards.progression_type' =>'Tipo de progresión',
    'gameboards.multiscreen' =>'Multipantalla? Dejalo desmarcado.',
    'gameboards.edit' =>'Editar',

    /*GAMEBOARD OPTIONS*/
    'gameboard_options' => 'opcion de juego',
    'gameboard_options.order' =>'Orden',
    'gameboard_options.description' =>'Descripción',
    'gameboard_options.image' =>'Imagen',
    'gameboard_options.result' =>'Resultado (no rellenar al inicio)',
    'gameboard_options.results' => 'Resultados',

    /*ADVERTISEMENTS*/
    'advertisements' => 'Anuncio',
    'advertisements.imagebig' => 'Imagen gran formato(1800x600)',
    'advertisements.imagesmall' => 'Imagen pequeño formato',
    'advertisements.adscategory_id' => 'Categoria',
    'advertisements.name' => 'Nombre',
    'advertisements.textbig' => 'Texto gran formato',
    'advertisements.textsmall' => 'Texto pequeño formato',
    'advertisements.textsmall1' => 'Cabecera de anuncio',
    'advertisements.textsmall2' => 'Texto',
    'advertisements.textbig1' => 'Cabecera',
    'advertisements.textbig2' => 'Texto',
    'advertisements.edit' => 'Editar',
    'advertisements.packs' => 'Impactos',

    'adspacks' => 'pack de anuncios',
    'adspacks.bigpack' => 'Repeticiones de anuncio gran formato',
    'adspacks.smallpack'=>'Repeticiones de anuncio pequeño formato',
    'adspacks.address'=> 'Dirección de la zona',
    'adspacks.radio'=> 'Kilómetros a la redonda',

    /* MESSAGES */
    'messages'=> 'Mensaje',
    'messages.date' => 'Fechas',
    'messages.start' => 'Inicio del Aviso',
    'messages.end' => 'Fin del Aviso',
    'messages.type'=> 'Tipo de Aviso',
    'messages.stext' => 'Titulo',
    'messages.ltext' => 'Descripción',
    'messages.image' => 'Imagen',
    'messages.location_id' => 'Lugar de publicación',

    /* ITEMS */
    'items' => 'Item',

    /* GENERAL */
    'male' => 'masculino',
    'female' => 'femenino',

    'admin' => 'administrador',
    'owner'=> 'gerente',
    'user' => 'usuario',

    'restaurant' => 'hosteleria',
    'bar' => 'bar',
    'cinema' => 'cine y teatro',
    'shopping' => 'compras',
    'sports' => 'centro deportivo',
    'karaoke' => 'karaoke',
    'museum' => 'museo',
    'party' => 'zona de ocio',

    'trabajo' => 'anuncio de trabajo',
    'ocio' => 'agenda de ocio y cultura',
    'util' => 'información de utilidad',

    'vote' => 'votación',
    'bet' => 'apuesta',
    'game' => 'juego'


];
