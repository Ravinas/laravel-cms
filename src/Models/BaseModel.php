<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class BaseModel extends Model
{
    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        if (isset($this->extras) && $this->extras instanceof Collection) {
            $extras = $this->extras->where('key', $key)->get();
        } else if (method_exists($this, 'extras')) {
            $extras = $this->extras()->where('key', $key)->get();
        }

        if(isset($extras)){
            if(count($extras) == 1){
                $extra = $extras->first();
                if (isset($extra->value)) {
                    return $extra->value;
                }
            }elseif(count($extras) > 1){
                return $extras->pluck("value")->toArray();
            }
        }
    }
}
