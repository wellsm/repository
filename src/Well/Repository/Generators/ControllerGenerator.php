<?php

namespace Well\Repository\Generators;

class ControllerGenerator extends Generator
{
    public function generate($name)
    {
        $name_controller = studly_case($name);
        
        $controller = file_get_contents(__DIR__ . '/../Templates/Controller.php');
        $controller = str_replace('_NAME_TABLE_', snake_case($name_controller), $controller);
        $controller = str_replace('_TABLE_', $name_controller, $controller);
        $controller = str_replace('_CONTROLLER_NAMESPACE_', str_replace('/', '\\', $this->config->generator->paths->controllers), $controller);
        $controller = str_replace('_NAMESPACE_', $this->getNamespace(), $controller);

        $filename = $this->getConfigPath('controllers') . $name_controller . 'Controller.php';
                
        if(! file_exists($filename)){
        	if(! file_exists($this->getConfigPath('controllers'))){
        		mkdir($this->getConfigPath('controllers'), 0755, true);
	        }

            file_put_contents($filename, $controller);
        }  
    }
}
