<?php

namespace App\Models;

use JsonSerializable;
use Polly\ORM\AbstractEntity;
use Polly\ORM\LazyLoader;

class BaseModel extends AbstractEntity implements JsonSerializable
{
    public function jsonSerialize()
    {
        $reflectionClass = new \ReflectionClass(get_class($this));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property)
        {
            if($property->getName() == 'errors' || $property->getType() == LazyLoader::class) continue;
            $getter = "get".ucfirst($property->getName());
            $array[$property->getName()] = $this->$getter();
        }
        return $array;
    }
}
