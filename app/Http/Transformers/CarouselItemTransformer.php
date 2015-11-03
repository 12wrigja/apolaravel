<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:38 PM
 */

namespace APOSite\Http\Transformers;

use APOSite\Models\CarouselItem;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\Config;

class CarouselItemTransformer extends TransformerAbstract
{
    protected $attributes;

    public function transform(CarouselItem $item)
    {
        $base =  [
            'id' => $item->id,
            'href' => route('carousel_list', ['id' => $item->id]),
            'background_image' => [
                'id'=>$item->background_image,
                'href'=>asset(Config::get('assets.images').$item->image->path)
            ],
            'action_url' => $item->action_url,
            'action_text' => $item->action_text,
            'enabled' => (boolean)$item->enabled,
            'caption' => $item->caption,
            'title' => $item->title,
            'event_id' => $item->event_id
        ];
        return $base;
    }

}