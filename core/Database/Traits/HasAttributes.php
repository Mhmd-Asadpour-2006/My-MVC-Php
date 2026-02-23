<?php

namespace Core\Database\Traits;

trait HasAttributes
{
    protected function setAttribute(array $array, $object=null)
    {
        if(!$object){
            $class = get_called_class();
            // class User extends Model // class give a User object
            $object = new $class;
        }
        foreach ($array as $attribute => $value) {
            $object->$attribute = $value;
        }
        return $object;
    }

    protected function setObject(array $array){
        $collection = [];
        foreach ($array as $value) {
            $object = $this->setAttribute($value);
            $collection[] = $object;
        }
        return $collection;
    }
}