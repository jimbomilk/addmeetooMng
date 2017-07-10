<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 22/02/2015
 * Time: 20:13
 */

class AdsTableSeeder extends Seeder
{

    /**
     *
     */

    public function createCategories()
    {
        // ADSCATEGORIES
        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'motor',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'empleo',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'servicios',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'telefonia',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'casa',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'bebes',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'cultura',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'inmobiliaria',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'imageysonido',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'juegos',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'moda',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'hosteleria',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'alimentacionybebidas',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));

        $iditem = \DB::table('adscategories')->insertGetId( array(
            'description'         => 'mascotas',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ));
    }

    public function createAds()
    {
        $faker = Faker::create();
        //Ahora creamos los ads: recorremos los ficheros y vamos creando los anuncios
        $path = storage_path().'/app/private/ads';

        $dir = opendir($path);
        $files = array();
        while ($current = readdir($dir)){
            if( $current != "." && $current != "..") {
                $files[] = $current;
            }
        }

        for($i=0; $i<count( $files ); $i++) {
            $path = storage_path().'/app/private/ads';
            $id=0;
            $extension="";
            $category="";
            $filename = str_replace('_',' ',$files[$i]);
            $filename = str_replace('.',' ',$filename);
            sscanf($filename, "%s %d %s",$category,$id,$extension);

            //buscamos el category_id:
            //$category = \App\Adscategory::where('description', '=', strtolower($category))->get();
            $category_id = \DB::table('adscategories')->where('description', strtolower($category))->value('id');

            if (isset($category_id)) {
                //Creamos el anuncio
                $users = \DB::table('users')->where('type', '=', 'user');

                $user = $faker->randomElement($users->lists('id'));
                $ads = \DB::table('advertisements')->insertGetId(array(
                    'adscategory_id' => $category_id,
                    'user_id' => $user,
                    'name'      => 'ad'.$i,
                    'textsmall1' => $faker->text(15),
                    'textsmall2' => $faker->text(10),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString()
                ));

                for($p=0;$p<5;$p++)
                {
                    $adsPack = \DB::table('adspacks')->insertGetId(array(
                        'bigpack' => $faker->numberBetween(1,30),
                        'smallpack' => $faker->numberBetween(1,30),
                        'advertisement_id' => $ads,
                        'latitude' => $faker->randomFloat(7,36,43),
                        'longitude' => $faker->randomFloat(7,-8,2),
                        'address' => $faker->text(40),
                        'radio' => '100',
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString()
                    ));

                }

                $sourcefile= $path.'/'.$files[$i];
                $adv = \App\Advertisement::find($ads);
                if (isset($adv)) {
                    //$t = Storage::disk('s3')->put($adv->path, file_get_contents($sourcefile), 'public');
                    $target_name = str_replace('http','https',$faker->imageUrl(1200, 600));//Storage::disk('s3')->url($adv->path);
                    \DB::table('advertisements')
                        ->where('id', '=', $ads)
                        ->update(['imagebig' => $target_name, 'imagesmall' => $target_name]);
                    //Log::info('ADS' . $ads . ", T:" . print_r($t));
                }
            }
        }

    }



    public function run()
    {
        $this->createCategories();
        $this->createAds();

    }
};