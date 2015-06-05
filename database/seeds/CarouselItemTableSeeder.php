<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

use APOSite\Models\CarouselItem as CarouselItem;

class CarouselItemTableSeeder extends Seeder
{
    public function run()
    {
        $first = new CarouselItem();
        $first->title = 'Welcome to APO!';
        $first->background_image = 'css/images/bluebackground.jpg';
        $first->save();

        $second = new CarouselItem();
        $second->title = 'Cats!';
        $second->background_image = 'css/images/catbackground.jpg';
        $second->action_text = 'Pet the Cat!';
        $second->action_url = '#';
        $second->save();
        // TestDummy::times(20)->create('App\Post');
    }
}
