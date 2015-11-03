<?php

namespace APOSite\Http\Controllers;

use APOSite\Http\Transformers\CarouselItemTransformer;
use APOSite\Models\CarouselItem;
use APOSite\Models\ImageEntry;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class CarouselItemController extends Controller
{
    public function listForEvent($id)
    {
        $items = CarouselItem::whereEventId($id)->get();
        $fractal = new Manager();
        $collection = new Collection($items, new CarouselItemTransformer());
        return $fractal->createData($collection)->toJson();
    }

    public function editCarouselItem(Request $request, $slideID)
    {
        $this->validate($request, [
            'image' => 'sometimes|required|exists:image_entries,id',
            'title' => 'sometimes|required|max:15',
            'caption' => 'sometimes',
            'action_text' => 'sometimes|required_with:action_url|max:20',
            'action_url' => 'required_with:action_text',
            'display_order' => 'sometimes|min:0'
        ]);
        $slide = CarouselItem::find($slideID);
        $slide->fill($request->all());
        if ($request->has('image')) {
            $p = ImageEntry::find($request->get('image'));
            if ((bool)$p->free_use) {
                $slide->background_image = $p->id;
            }
        }
        $slide->save();
        $transformer = new CarouselItemTransformer();
        $item = new Item($slide, $transformer);
        $fractal = new Manager();
        return $fractal->createData($item)->toJson();
    }

    public function createCarouselItem(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|exists:image_entries,id',
            'title' => 'required|max:15',
            'caption' => 'sometimes',
            'action_text' => 'sometimes|required_with:action_url|max:20',
            'action_url' => 'required_with:action_text'
        ]);


    }

    private function setDisplayOrder($slide, $index)
    {
        $items = CarouselItem::whereEventId($slide->eventId)->orderBy('display_order', 'DESC')->get();
        $count = $items->count();
        if ($index > $count) {
            $slide->display_order = $count;
            $slide->save();
            return;
        }
        if ($index <= 0) {
            $slide->display_order = 0;
        }
        foreach ($items as $i => $item) {
            if($index>=$i){
                $item->display_order = $item->display_order + 1;
                $item->save();
            }
        }
        $slide->save();
    }

}
