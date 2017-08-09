<?php

namespace Well\Repository\Generators;

class ControllerGenerator
{
    public static function generate($name)
    {
        $name_controller = studly_case($name);
        
        $controller = file_get_contents(__DIR__ . '/../Templates/Controller.php');
        $controller = str_replace('_NAME_TABLE_', snake_case($name_controller), $controller);
        $controller = str_replace('_TABLE_', $name_controller, $controller);
                
        $filename = app_path('Http/Controllers/' . $name_controller . 'Controller.php');
                
        if(! file_exists($filename)){
            file_put_contents($filename, $controller);
        }  
    }
}
