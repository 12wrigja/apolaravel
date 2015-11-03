<?php

use APOSite\Models\CarouselItem as CarouselItem;
use Illuminate\Database\Seeder;

class CarouselItemTableSeeder extends Seeder
{
    public function run()
    {
        $img = new \APOSite\Models\ImageEntry();
        $img->path = '5a13de2b5d95b730224e8438c95985b8.jpg';
        $img->uploader = 'jow5';
        $img->free_use = true;
        $img->save();

        $report = new \APOSite\Models\Contracts\Report();
        $report->id = 0;
        $report->save();

        $first = new CarouselItem();
        $first->title = 'Welcome to APO!';
        $first->background_image = $img->id;
        $first->event_id = 0;
        $first->save();
    }
}
