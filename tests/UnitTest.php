<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UnitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        // Actividades
        $activities = \App\Activity::all();

        // Hemos guardado 3
        $this->assertCount(3,$activities);

        // Locations
        $locations = \App\Location::all();

        // Hemos guardado 3 locations
        $this->assertCount(3,$locations);
        $user = $locations[0]->owner->name;
        $this->assertNotEmpty($user);

        //Y 4 pantallas
        $screens = $locations[0]->screens();
        $this->assertCount(4,$screens->getResults());

    }
}
