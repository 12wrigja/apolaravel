<?php

use APOSite\Models\CarouselItem as CarouselItem;
use Illuminate\Database\Seeder;

class CarouselItemTableSeeder extends Seeder
{
    public function run()
    {
        $uploader = \APOSite\Models\Users\User::inRandomOrder()->first();
        if ($uploader == null) {
            $this->command->warn("Unable to pick a random person to attribute upload to. Exiting Seeder.");
            return;
        }
        $img = new \APOSite\Models\ImageEntry();
        $img->path = '5a13de2b5d95b730224e8438c95985b8.jpg';
        $img->free_use = true;
        $img->uploader = $uploader->id;
        $img->save();

        $first = new CarouselItem();
        $first->title = 'Welcome to APO!';
        $first->background_image = $img->id;
        $first->save();
    }
}
