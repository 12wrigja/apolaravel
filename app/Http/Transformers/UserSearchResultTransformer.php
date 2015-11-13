<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:38 PM
 */

namespace APOSite\Http\Transformers;

use APOSite\Models\Users\User;
use League\Fractal\TransformerAbstract;

class UserSearchResultTransformer extends TransformerAbstract
{
    protected $attributes;

    /**
     * UserSearchResultTransformer constructor.
     * @param $attributes
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    public function transform(User $user)
    {
        $base = [
            'id' => $user->id,
            'href' => route('user_show', ['id' => $user->id]),
            'display_name' => $user->getFullDisplayName(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'image' => $user->pictureURL(150),
        ];
        if (count($this->attributes) == 0 || count($this->attributes) == 1 && $this->attributes[0] == "") {
            return $base;
        }
        foreach ($this->attributes as $attr) {
            $value = $user->getAttribute($attr);
            if ($value != null) {
                $base[$attr] = $value;
            }
        }
        return $base;
    }

}