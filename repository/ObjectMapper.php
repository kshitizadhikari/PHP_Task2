<?php
namespace app\repository;

use InvalidArgumentException;

class ObjectMapper
{
    public static function mapToObject(array $data, $className)
    {
        // Construct the full class name by prefixing it with the namespace
        $fullClassName = 'app\\models\\' . $className;

        if (!class_exists($fullClassName)) {
            throw new InvalidArgumentException("Class $fullClassName does not exist");
        }

        $object = new $fullClassName();

        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }
}
?>
