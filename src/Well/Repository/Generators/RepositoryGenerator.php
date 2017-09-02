<?php

namespace Well\Repository\Generators;

class RepositoryGenerator extends Generator
{
    public function generate($name)
    {
        $name_repository = studly_case($name);

        $repository = file_get_contents(__DIR__ . '/../Stubs/Repository.stub');
        $repository = str_replace('_TABLE_', $name_repository, $repository);
        $repository = str_replace('_ENTITY_NAMESPACE_', str_replace('/', '\\', $this->config->generator->paths->models), $repository);
        $repository = str_replace('_REPOSITORY_NAMESPACE_', str_replace('/', '\\', $this->config->generator->paths->repositories), $repository);
        $repository = str_replace('_NAMESPACE_', $this->getNamespace(), $repository);

        if (!file_exists($this->getConfigPath('repositories'))) {
            mkdir($this->getConfigPath('repositories'), 0777, true);
        }
        
        $filename = $this->getConfigPath('repositories') . $name_repository . 'Repository.php';

        if(! file_exists($filename)){
            file_put_contents($filename, $repository);
        } 
    }

}
