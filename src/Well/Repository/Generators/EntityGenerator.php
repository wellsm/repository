<?php

namespace Well\Repository\Generators;

class EntityGenerator
{

    public static function generate($name)
    {
        $name_entity = studly_case($name);

        $entity = file_get_contents(__DIR__ . '/../Templates/Entity.php');
        $entity = str_replace('_TABLE_', $name_entity, $entity);

        if (!file_exists(app_path('Entities'))) {
            mkdir(app_path('Entities'), 0777, true);
        }

        $filename = app_path('Entities/' . $name_entity . '.php');

        if(! file_exists($filename)){
            file_put_contents($filename, $entity);
        }        
    }

}
