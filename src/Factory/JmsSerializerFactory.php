<?php

namespace App\Factory;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

/**
 * Class JmsSerializerFactory
 * @package App\Factory
 */
class JmsSerializerFactory
{
    public static function createSerializer(): Serializer
    {
        return SerializerBuilder::create()->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();
    }
}
