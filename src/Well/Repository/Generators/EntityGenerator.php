<?php

namespace Well\Repository\Generators;

class EntityGenerator extends Generator
{
    public function generate($name)
    {
        $name_entity = studly_case($name);

        $entity = file_get_contents(__DIR__ . '/../Templates/Entity.php');
        $entity = str_replace('_TABLE_', $name_entity, $entity);
        $entity = str_replace('_ENTITY_NAMESPACE_', str_replace('/', '\\', $this->config->generator->paths->models), $entity);
        $entity = str_replace('_NAMESPACE_', $this->getNamespace(), $entity);

        if (!file_exists($this->getConfigPath('models'))) {
            mkdir($this->getConfigPath('models'), 0777, true);
        }

        $filename = $this->getConfigPath('models') . $name_entity . '.php';

        if(! file_exists($filename)){
            file_put_contents($filename, $entity);
        }        
    }

}
